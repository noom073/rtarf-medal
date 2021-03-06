<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_fundamental extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('admin_fundamental_model');
		$this->load->library('myfunction');
	}

	public function index()
	{
		$data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
		$this->load->view('foundation_view/header');
		$this->load->view('admin_view/admin_menu/navbar_admin');
		$this->load->view('admin_view/admin_fdmt/admin_fdmt_profile', $data);
		$this->load->view('main_view/container_footer');
		$this->load->view('foundation_view/footer');
	}

	public function ajax_search_person()
	{
		$unitid = $this->input->post('unitid');
		$data['type'] = $this->input->post('type');
		$data['text'] = $this->input->post('text');
		$data['unitid'] = $this->myfunction->decode($unitid);
		$result = $this->admin_fundamental_model->get_person($data);
		if ($result->num_rows() > 0) {
			$person = array();
			foreach ($result->result_array() as $r) {
				$r['BIOG_ID'] = $this->myfunction->encode($r['BIOG_ID']);
				$person[] = $r;
			}
			$respone['status'] 	= true;
			$respone['data'] 	= $person;
		} else {
			$respone['status'] 	= false;
			$respone['data'] 	= 'ไม่พบข้อมูล';
		}
		echo json_encode($respone);
	}

	public function biog($encBiog_id)
	{
		$biog_id = $this->myfunction->decode($encBiog_id);

		$data['person'] = $this->admin_fundamental_model->get_person_row($biog_id)->row_array();
		$data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
		$this->load->view('foundation_view/header');
		$this->load->view('admin_view/admin_menu/navbar_admin');
		$this->load->view('admin_view/admin_fdmt/admin_biog_profile', $data);
		$this->load->view('main_view/container_footer');
		$this->load->view('foundation_view/footer');
	}

	public function ribbon_report()
	{
		// echo 'ribbon';
		$data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
		$this->load->view('foundation_view/header');
		$this->load->view('admin_view/admin_menu/navbar_admin');
		$this->load->view('admin_view/admin_fdmt/admin_ribbon_form', $data);
		$this->load->view('main_view/container_footer');
		$this->load->view('foundation_view/footer');
	}

	public function ajax_ribbon_generate_report()
	{
		$this->load->library('pdf');
		$this->load->library('person_data');
		$data['year']		= $this->input->post('year');
		$unitid				= $this->myfunction->decode($this->input->post('unitid'));
		$unitcode4          = substr($unitid, 0, 4);
		$data['headquarters']   = ($unitid == '6001000000') ? 'กระทรวงกลาโหม' : 'กองทัพไทย';
		$data['unit_name']      = ($unitid == '6001000000') ? array('NPRT_NAME' => 'กองบัญชาการกองทัพไทย') : $this->person_data->get_unit_name($unitid);
		$data['persons'] 	= $this->admin_fundamental_model->get_ribbon_person($unitcode4)->result_array();
		$this->load->view('pdf_report/ribbon_list_report', $data);
	}

	public function non_ribbon_report()
	{
		// echo 'non-ribbon form';
		$this->load->model('lib_model');

		$data['ranks'] = $this->lib_model->get_all_rank()->result_array();
		$data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
		$this->load->view('foundation_view/header');
		$this->load->view('admin_view/admin_menu/navbar_admin');
		$this->load->view('admin_view/admin_fdmt/admin_non_ribbon_form', $data);
		$this->load->view('main_view/container_footer');
		$this->load->view('foundation_view/footer');
	}

	public function non_ribbon_generate_report()
	{
		set_time_limit(500);
		$this->load->library('pdf');
		$this->load->library('person_data');

		$data['year']		= $this->input->post('year');
		$data['rankid']		= $this->input->post('rankid');
		$unitid				= $this->myfunction->decode($this->input->post('unitid'));
		$data['headquarters']   = ($unitid == '6001000000') ? 'กระทรวงกลาโหม' : 'กองทัพไทย';
		$data['unit_name']      = ($unitid == '6001000000') ? array('NPRT_NAME' => 'กองบัญชาการกองทัพไทย') : $this->person_data->get_unit_name($unitid);
		// $data['unit_name'] 	= $this->admin_fundamental_model->get_unit_name($unitid)->row_array();
		$unitcode4          = substr($unitid, 0, 4);

		$data['persons'] 	= $this->admin_fundamental_model
			->get_non_ribbon_person($unitcode4, $data['rankid'], $data['rankid'])
			->result_array();

		if ($data['rankid'] >= '05' && $data['rankid'] <= '11') {
			$data['rankType'] 	= 'commission';
			$this->load->view('pdf_report/non_ribbon_a_list_report', $data);
		} else if ($data['rankid'] >= '21' && $data['rankid'] <= '27') {
			$data['rankType'] 	= 'non-commission';
			$this->load->view('pdf_report/non_ribbon_b_list_report', $data);
		} else if ($data['rankid'] >= '50' && $data['rankid'] <= '61') {
			$data['rankType'] 	= 'employee';
			$this->load->view('pdf_report/non_ribbon_c_list_report', $data);
		} else {
			$data['rankType'] = 'not in rank';
			redirect('admin_fundamental/non_ribbon_report');
		}
	}

	public function not_request_medal()
	{
		// echo 'non-ribbon form';
		$this->load->model('lib_model');

		$data['ranks'] = $this->lib_model->get_all_rank()->result_array();
		$data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
		$this->load->view('foundation_view/header');
		$this->load->view('admin_view/admin_menu/navbar_admin');
		$this->load->view('admin_view/admin_fdmt/admin_not_request_medal_form', $data);
		$this->load->view('main_view/container_footer');
		$this->load->view('foundation_view/footer');
	}

	public function not_request_medal_generate_report()
	{
		$this->load->library('pdf');
		$this->load->library('person_data');

		$data['year']		= $this->input->post('year');
		$data['rankid']		= $this->input->post('rankid');
		$unitid				= $this->myfunction->decode($this->input->post('unitid'));
		$data['headquarters']   = ($unitid == '6001000000') ? 'กระทรวงกลาโหม' : 'กองทัพไทย';
		$data['unit_name']      = ($unitid == '6001000000') ? array('NPRT_NAME' => 'กองบัญชาการกองทัพไทย') : $this->person_data->get_unit_name($unitid);
		// $data['unit_name'] 	= $this->admin_fundamental_model->get_unit_name($unitid)->row_array();
		$unitcode4          = substr($unitid, 0, 4);

		$persons = $this->admin_fundamental_model
			->get_non_ribbon_person($unitcode4, $data['rankid'], $data['rankid'])
			->result_array();
		$data['persons']	= $this->admin_fundamental_model->get_person_has_not_medal($persons);

		if ($data['rankid'] >= '05' && $data['rankid'] <= '11') {
			$data['rankType']	= 'commission';
			$this->load->view('pdf_report/not_req_medal_a_list_report', $data);
		} else if ($data['rankid'] >= '21' && $data['rankid'] <= '27') {
			$data['rankType'] 	= 'non-commission';
			$this->load->view('pdf_report/not_req_medal_b_list_report', $data);
		} else if ($data['rankid'] >= '50' && $data['rankid'] <= '61') {
			$data['rankType'] 	= 'employee';
			$data['persons'] 	= $persons;
			$this->load->view('pdf_report/not_req_medal_c_list_report', $data);
		} else {
			$data['rankType'] = 'not in rank';
			redirect('admin_fundamental/non_ribbon_report');
		}
	}
}
