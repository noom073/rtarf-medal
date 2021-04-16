<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_typical_non_ribbon_status_off extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('admin_typical_non_ribbon_model', 'atnr_model');
		$this->load->library('myfunction');
		$this->load->library('person_data');
		$this->load->library('set_env');
	}

	public function fundation()
	{
		$system = $this->set_env->get_system_status();
		if ($system == 1) {
			redirect('admin_typical_non_ribbon/fundation');
		} else {
			$data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
	
			$this->load->view('foundation_view/header');
			$this->load->view('admin_view/admin_menu/navbar_admin');
			$this->load->view('admin_view/admin_typical_non_ribbon_status_off/admin_typical_non_ribbon_fundation', $data);
			$this->load->view('main_view/container_footer');
			$this->load->view('foundation_view/footer');
		}
	}

	public function ajax_get_person_bdec()
	{
		$unitInput 	= $this->input->post('unitid', true);
		$unitID4 	= substr($this->myfunction->decode($unitInput), 0, 4);
		$person 	= $this->atnr_model->get_person_bdec($unitID4)->result_array();
		$response 	= json_encode($person);
		$this->output
			->set_content_type('application/json')
			->set_output($response);
	}

	public function ajax_update_medal_bdec()
	{
		$data['biogID'] 	= $this->input->post('id');
		$data['medal'] 		= $this->input->post('medal');
		$data['nextMedal']	= $this->input->post('nextMedal');

		$update = $this->person_data->save_update_medal_bdec($data);
		if ($update) {
			$result['status'] 	= true;
			$result['text'] 	= 'บันทึกสำเร็จ';
		} else {
			$result['status'] 	= false;
			$result['text'] 	= 'บันทึกไม่สำเร็จ';
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	public function ajax_search_person()
	{
		$data['type']	= $this->input->post('type_opt', true);
		$data['text']	= $this->input->post('text_search', true);
		$unitInput 		= $this->input->post('unitID', true);
		$data['unitID4'] = substr($this->myfunction->decode($unitInput), 0, 4);
		$personData		= $this->atnr_model->search_person_in_biog_back($data)->result_array();
		$persons 		= array_filter($personData, function ($x) {
			return $x['BIOG_RANK'] >= '06'; // filter person's rank <= 06 only
		});
		if (count($persons) > 0) {
			$result['status']	= true;
			$result['text'] 	= "พบข้อมูล";
			$result['data']		= array_merge($persons);
		} else {
			$result['status'] 	= false;
			$result['text'] 	= "ไม่พบข้อมูล";
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	public function ajax_add_person_to_bdec()
	{
		$data['nextMedal'] 	= $this->input->post('medal', true);
		$data['biogID']	= $this->input->post('biog_id', true);
		$data['remark']	 = $this->input->post('remark', true);

		$insert = $this->person_data->add_person_bdec($data);
		if ($insert == 'SUCCESS') {
			$result['status'] = true;
			$result['text'] = 'บันทึกสำเร็จ';
		} else if ($insert == 'ERR-DUPLICATE') {
			$result['status'] = false;
			$result['text'] = 'มีรายชื่อแล้ว';
		} else if ($insert == 'ERR-INSERT-FAIL') {
			$result['status'] = false;
			$result['text'] = 'ไม่สามารถบันทึกได้';
		} else {
			$result['status'] = false;
			$result['text'] = 'NOT IN CASE';
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	public function ajax_delete_bdec_person()
	{
		$biogID = $this->input->post('bdec_id', true);
		$delete = $this->atnr_model->delete_bdec_person($biogID);

		if ($delete) {
			$result['status'] = true;
			$result['text'] = 'ลบข้อมูลสำเร็จ';
		} else {
			$result['status'] = false;
			$result['text'] = 'ไม่สามารถลบข้อมูลได้';
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	public function property()
	{
		$system = $this->set_env->get_system_status();
		if ($system == 1) {
			redirect('admin_typical_non_ribbon/property');
		} else {
			$data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
	
			$this->load->view('foundation_view/header');
			$this->load->view('admin_view/admin_menu/navbar_admin');
			$this->load->view('admin_view/admin_typical_non_ribbon_status_off/admin_typical_non_ribbon_index', $data);
			$this->load->view('main_view/container_footer');
			$this->load->view('foundation_view/footer');
		}
	}

	public function action_get_non_ribbon_person_prop()
	{
		$this->load->library('pdf');
		$unitID = $this->myfunction->decode($this->input->post('unitid'));
		$medal = $this->input->post('ribbon_type');

		$data['unit_name']      = $this->person_data->get_unit_name($unitID);
		$data['ribbon_acm']     = $medal;
		$data['ribbon_name']    = $this->person_data->medal_full_name($medal);
		$data['year']           = $this->input->post('year');
		$data['p1_rank']        = $this->input->post('p1_rank');
		$data['p1_name']        = $this->input->post('p1_name');
		$data['p1_position']    = $this->input->post('p1_position');
		$data['p2_rank']        = $this->input->post('p2_rank');
		$data['p2_name']        = $this->input->post('p2_name');
		$data['p2_position']    = $this->input->post('p2_position');
		$data['type']      		= $this->input->post('type');

		if ($data['type']=='officer') {
			$data['persons'] = $this->atnr_model->get_officer_prop($unitID, $medal)->result_array();
		} else {
			$data['persons'] = $this->atnr_model->get_employee_prop($unitID, $medal)->result_array();
		}

		// $this->load->view('admin_view/admin_typical_non_ribbon/gen_non_ribbon_property', $data);
		$this->load->view('pdf_report/ordinary_non_ribbon/property_list_report', $data);
	}

	public function summarize_name()
	{
		$system = $this->set_env->get_system_status();
		if ($system == 1) {
			redirect('admin_typical_non_ribbon/summarize_name');
		} else {
			$data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
	
			$this->load->view('foundation_view/header');
			$this->load->view('admin_view/admin_menu/navbar_admin');
			$this->load->view('admin_view/admin_typical_non_ribbon_status_off/admin_typical_non_ribbon_summarize_name_form', $data);
			$this->load->view('main_view/container_footer');
			$this->load->view('foundation_view/footer');
		}
	}

	public function action_summarize_name()
	{
		$this->load->library('pdf');
		$unitID = $this->myfunction->decode($this->input->post('unitid'));

		$data['year']           = $this->input->post('year');
		$data['condition']      = $this->input->post('condition');
		$data['unit_name']      = $this->person_data->get_unit_name($unitID);
		$data['type']      		= $this->input->post('type');
		$data['p1_rank']        = $this->input->post('p1_rank');
		$data['p1_name']        = $this->input->post('p1_name');
		$data['p1_position']    = $this->input->post('p1_position');

		if ($data['type']== 'officer') {
			$data['thc']	= $this->atnr_model->get_officer_prop($unitID, 'ท.ช.')->result_array();
			$data['thm']    = $this->atnr_model->get_officer_prop($unitID, 'ท.ม.')->result_array();
			$data['tc']		= $this->atnr_model->get_officer_prop($unitID, 'ต.ช.')->result_array();
			$data['tm']    	= $this->atnr_model->get_officer_prop($unitID, 'ต.ม.')->result_array();
			$data['jc']    	= $this->atnr_model->get_officer_prop($unitID, 'จ.ช.')->result_array();
			$data['jm']    	= $this->atnr_model->get_officer_prop($unitID, 'จ.ม.')->result_array();
			$data['bc']    	= $this->atnr_model->get_officer_prop($unitID, 'บ.ช.')->result_array();
			$data['bm']    	= $this->atnr_model->get_officer_prop($unitID, 'บ.ม.')->result_array();
			$data['rtc']    = $this->atnr_model->get_officer_prop($unitID, 'ร.ท.ช.')->result_array();
		} else {
			$data['thc']	= $this->atnr_model->get_employee_prop($unitID, 'ท.ช.')->result_array();
			$data['thm']    = $this->atnr_model->get_employee_prop($unitID, 'ท.ม.')->result_array();
			$data['tc']		= $this->atnr_model->get_employee_prop($unitID, 'ต.ช.')->result_array();
			$data['tm']    	= $this->atnr_model->get_employee_prop($unitID, 'ต.ม.')->result_array();
			$data['jc']    	= $this->atnr_model->get_employee_prop($unitID, 'จ.ช.')->result_array();
			$data['jm']    	= $this->atnr_model->get_employee_prop($unitID, 'จ.ม.')->result_array();
			$data['bc']    	= $this->atnr_model->get_employee_prop($unitID, 'บ.ช.')->result_array();
			$data['bm']    	= $this->atnr_model->get_employee_prop($unitID, 'บ.ม.')->result_array();
			$data['rtc']    = $this->atnr_model->get_employee_prop($unitID, 'ร.ท.ช.')->result_array();
		}

		// $this->load->view('admin_view/admin_typical_non_ribbon/gen_non_ribbon_summarize_name', $data);
		$this->load->view('pdf_report/ordinary_non_ribbon/name_list_report', $data);
	}

	public function ribbon_amount()
	{
		$system = $this->set_env->get_system_status();
		if ($system == 1) {
			redirect('admin_typical_non_ribbon/ribbon_amount');
		} else {
			$data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
			$this->load->view('foundation_view/header');
			$this->load->view('admin_view/admin_menu/navbar_admin');
			$this->load->view('admin_view/admin_typical_non_ribbon_status_off/admin_typical_non_ribbon_amount_form', $data);
			$this->load->view('main_view/container_footer');
			$this->load->view('foundation_view/footer');
		}
	}

	public function action_get_ribbon_amount()
	{
		$this->load->library('pdf');

		$unitID = $this->myfunction->decode($this->input->post('unitid'));

		$data['year']    	= $this->input->post('year');
		$data['condition']  = $this->input->post('condition');
		$data['unit_name'] 	= $this->person_data->get_unit_name($unitID);
		$data['type']      	= $this->input->post('type');
		$data['p1_rank']    = $this->input->post('p1_rank');
		$data['p1_name']    = $this->input->post('p1_name');
		$data['p1_position']= $this->input->post('p1_position');

		if ($data['type']=='officer') {
			$dtthc	= $this->atnr_model->get_officer_prop($unitID, 'ท.ช.')->result_array();
			$dtthm 	= $this->atnr_model->get_officer_prop($unitID, 'ท.ม.')->result_array();
			$dttc 	= $this->atnr_model->get_officer_prop($unitID, 'ต.ช.')->result_array();
			$dttm 	= $this->atnr_model->get_officer_prop($unitID, 'ต.ม.')->result_array();
			$dtjc 	= $this->atnr_model->get_officer_prop($unitID, 'จ.ช.')->result_array();
			$dtjm 	= $this->atnr_model->get_officer_prop($unitID, 'จ.ม.')->result_array();
			$dtbc 	= $this->atnr_model->get_officer_prop($unitID, 'บ.ช.')->result_array();
			$dtbm 	= $this->atnr_model->get_officer_prop($unitID, 'บ.ม')->result_array();
			$dtrtc 	= $this->atnr_model->get_officer_prop($unitID, 'ร.ท.ช.')->result_array();
		} else {
			$dtthc 	= $this->atnr_model->get_employee_prop($unitID, 'ท.ช.')->result_array();
			$dtthm 	= $this->atnr_model->get_employee_prop($unitID, 'ท.ม.')->result_array();
			$dttc 	= $this->atnr_model->get_employee_prop($unitID, 'ต.ช.')->result_array();
			$dttm 	= $this->atnr_model->get_employee_prop($unitID, 'ต.ม.')->result_array();
			$dtjc 	= $this->atnr_model->get_employee_prop($unitID, 'จ.ช.')->result_array();
			$dtjm 	= $this->atnr_model->get_employee_prop($unitID, 'จ.ม.')->result_array();
			$dtbc 	= $this->atnr_model->get_employee_prop($unitID, 'บ.ช.')->result_array();
			$dtbm 	= $this->atnr_model->get_employee_prop($unitID, 'บ.ม')->result_array();
			$dtrtc 	= $this->atnr_model->get_employee_prop($unitID, 'ร.ท.ช.')->result_array();
		}

		$persons_thc_men        = array_filter($dtthc, function ($r) {
			return $r['BIOG_SEX'] == 0;
		});
		$persons_thc_women      = array_filter($dtthc, function ($r) {
			return $r['BIOG_SEX'] == 1;
		});
		$data['thc']['men']     = count($persons_thc_men);
		$data['thc']['women']   = count($persons_thc_women);

		$persons_thm_men        = array_filter($dtthm, function ($r) {
			return $r['BIOG_SEX'] == 0;
		});
		$persons_thm_women      = array_filter($dtthm, function ($r) {
			return $r['BIOG_SEX'] == 1;
		});
		$data['thm']['men']     = count($persons_thm_men);
		$data['thm']['women']   = count($persons_thm_women);

		$persons_tc_men        = array_filter($dttc, function ($r) {
			return $r['BIOG_SEX'] == 0;
		});
		$persons_tc_women      = array_filter($dttc, function ($r) {
			return $r['BIOG_SEX'] == 1;
		});
		$data['tc']['men']     = count($persons_tc_men);
		$data['tc']['women']   = count($persons_tc_women);

		$persons_tm_men        = array_filter($dttm, function ($r) {
			return $r['BIOG_SEX'] == 0;
		});
		$persons_tm_women      = array_filter($dttm, function ($r) {
			return $r['BIOG_SEX'] == 1;
		});
		$data['tm']['men']     = count($persons_tm_men);
		$data['tm']['women']   = count($persons_tm_women);

		$persons_jc_men        = array_filter($dtjc, function ($r) {
			return $r['BIOG_SEX'] == 0;
		});
		$persons_jc_women      = array_filter($dtjc, function ($r) {
			return $r['BIOG_SEX'] == 1;
		});
		$data['jc']['men']     = count($persons_jc_men);
		$data['jc']['women']   = count($persons_jc_women);

		$persons_jm_men        = array_filter($dtjm, function ($r) {
			return $r['BIOG_SEX'] == 0;
		});
		$persons_jm_women      = array_filter($dtjm, function ($r) {
			return $r['BIOG_SEX'] == 1;
		});
		$data['jm']['men']     = count($persons_jm_men);
		$data['jm']['women']   = count($persons_jm_women);

		$persons_bc_men        = array_filter($dtbc, function ($r) {
			return $r['BIOG_SEX'] == 0;
		});
		$persons_bc_women      = array_filter($dtbc, function ($r) {
			return $r['BIOG_SEX'] == 1;
		});
		$data['bc']['men']     = count($persons_bc_men);
		$data['bc']['women']   = count($persons_bc_women);

		$persons_bm_men        = array_filter($dtbm, function ($r) {
			return $r['BIOG_SEX'] == 0;
		});
		$persons_bm_women      = array_filter($dtbm, function ($r) {
			return $r['BIOG_SEX'] == 1;
		});
		$data['bm']['men']     = count($persons_bm_men);
		$data['bm']['women']   = count($persons_bm_women);

		$persons_rtc_men        = array_filter($dtrtc, function ($r) {
			return $r['BIOG_SEX'] == 0;
		});
		$persons_rtc_women      = array_filter($dtrtc, function ($r) {
			return $r['BIOG_SEX'] == 1;
		});
		$data['rtc']['men']     = count($persons_rtc_men);
		$data['rtc']['women']   = count($persons_rtc_women);

		// var_dump($data);
		// $this->load->view('admin_view/admin_typical_non_ribbon/gen_non_ribbon_amount', $data);
		$this->load->view('pdf_report/ordinary_non_ribbon/total_group_report', $data);
	}
}
