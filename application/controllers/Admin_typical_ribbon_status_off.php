<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_typical_ribbon_status_off extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('admin_typical_ribbon_model', 'atr_model');
        $this->load->model('lib_model');
        $this->load->library('myfunction');
        $this->load->library('person_data');
        $this->load->library('set_env');
    }

    public function fundation()
    {
        $system = $this->set_env->get_system_status();
        if ($system == 1) {
            redirect('admin_typical_ribbon/fundation');
        } else {
            $data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);

            $this->load->view('foundation_view/header');
            $this->load->view('admin_view/admin_menu/navbar_admin');
            $this->load->view('admin_view/admin_typical_ribbon_status_off/admin_typical_ribbon_fundation', $data);
            $this->load->view('main_view/container_footer');
            $this->load->view('foundation_view/footer');
        }
    }

    public function ajax_get_person_bdec()
    {
        $unitInput     = $this->input->post('unitid');
        $unitID4     = substr($this->myfunction->decode($unitInput), 0, 4);
        $person     = $this->atr_model->get_person_bdec($unitID4)->result_array();
        $response     = json_encode($person);
        $this->output
            ->set_content_type('application/json')
            ->set_output($response);
    }

    public function ajax_update_medal_bdec()
    {
        $data['biogID']     = $this->input->post('id');
        $data['medal']         = $this->input->post('medal');
        $data['nextMedal']    = $this->input->post('nextMedal');

        $update = $this->person_data->save_update_medal_bdec($data);
        if ($update) {
            $result['status']     = true;
            $result['text']     = 'บันทึกสำเร็จ';
        } else {
            $result['status']     = false;
            $result['text']     = 'บันทึกไม่สำเร็จ';
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function ajax_search_person()
    {
        $data['type']    = $this->input->post('type_opt', true);
        $data['text']    = $this->input->post('text_search', true);
        $unitInput         = $this->input->post('unitID', true);
        $data['unitID4'] = substr($this->myfunction->decode($unitInput), 0, 4);
        $personData        = $this->atr_model->search_person_in_biog_back($data)->result_array();
        $persons         = array_filter($personData, function ($x) {
            return $x['BIOG_RANK'] <= '06'; // filter person's rank <= 06 only
        });
        if (count($persons) > 0) {
            $result['status']    = true;
            $result['text']     = "พบข้อมูล";
            $result['data']        = array_merge($persons);;
        } else {
            $result['status']     = false;
            $result['text']     = "ไม่พบข้อมูล";
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function ajax_add_person_to_bdec()
    {
        $data['nextMedal']     = $this->input->post('medal', true);
        $data['biogID']     = $this->input->post('biog_id', true);
        $data['remark']     = $this->input->post('remark', true);

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
        $delete = $this->atr_model->delete_bdec_person($biogID);

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
            redirect('admin_typical_ribbon/property');
        } else {
            $data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);

            $this->load->view('foundation_view/header');
            $this->load->view('admin_view/admin_menu/navbar_admin');
            $this->load->view('admin_view/admin_typical_ribbon_status_off/admin_typical_ribbon_index', $data);
            $this->load->view('main_view/container_footer');
            $this->load->view('foundation_view/footer');
        }
    }

    public function action_get_ribbon_person_prop()
    {
        $this->load->library('pdf');
        $unitID = $this->myfunction->decode($this->input->post('unitid'));
        $ribbon = $this->input->post('ribbon_type');

        $data['headquarters']   = ($unitID == '6001000000') ? 'กระทรวงกลาโหม' : 'กองทัพไทย';
        $data['unit_name']      = ($unitID == '6001000000') ? array('NPRT_NAME' => 'กองบัญชาการกองทัพไทย') : $this->person_data->get_unit_name($unitID);
        $data['ribbon_acm']     = $ribbon;
        $data['ribbon_name']    = $this->person_data->medal_full_name($ribbon);
        $data['year']           = $this->input->post('year');
        $data['p1_rank']        = $this->input->post('p1_rank');
        $data['p1_name']        = $this->input->post('p1_name');
        $data['p1_position']    = $this->input->post('p1_position');
        $data['p2_rank']        = $this->input->post('p2_rank');
        $data['p2_name']        = $this->input->post('p2_name');
        $data['p2_position']    = $this->input->post('p2_position');
        $data['condition']      = $this->input->post('condition');

        $data['persons'] = $this->atr_model->get_person_prop_by_medal_biog_back($unitID, $data)->result_array();
        $this->load->view('pdf_report/ordinary_ribbon/property_list_report', $data);
    }

    public function summarize_name()
    {
        $system = $this->set_env->get_system_status();
        if ($system == 1) {
            redirect('admin_typical_ribbon/summarize_name');
        } else {
            $data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);

            $this->load->view('foundation_view/header');
            $this->load->view('admin_view/admin_menu/navbar_admin');
            $this->load->view('admin_view/admin_typical_ribbon_status_off/admin_typical_ribbon_summarize_name_form', $data);
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
        $data['headquarters']   = ($unitID == '6001000000') ? 'กระทรวงกลาโหม' : 'กองทัพไทย';
        $data['unit_name']      = ($unitID == '6001000000') ? array('NPRT_NAME' => 'กองบัญชาการกองทัพไทย') : $this->person_data->get_unit_name($unitID);
        $data['p1_rank']        = $this->input->post('p1_rank');
        $data['p1_name']        = $this->input->post('p1_name');
        $data['p1_position']    = $this->input->post('p1_position');

        $data['ribbon_acm'] = 'ม.ป.ช.';
        $data['persons_mpc']    = $this->atr_model->get_person_prop_by_medal_biog_back($unitID, $data)->result_array();
        $data['ribbon_acm'] = 'ม.ว.ม.';
        $data['persons_mvm']    = $this->atr_model->get_person_prop_by_medal_biog_back($unitID, $data)->result_array();
        $data['ribbon_acm'] = 'ป.ช.';
        $data['persons_pc']     = $this->atr_model->get_person_prop_by_medal_biog_back($unitID, $data)->result_array();
        $data['ribbon_acm'] = 'ป.ม.';
        $data['persons_pm']     = $this->atr_model->get_person_prop_by_medal_biog_back($unitID, $data)->result_array();

        // var_dump($data);
        $this->load->view('pdf_report/ordinary_ribbon/name_list_report', $data);
    }

    public function ribbon_amount()
    {
        $system = $this->set_env->get_system_status();
        if ($system == 1) {
            redirect('admin_typical_ribbon/ribbon_amount');
        } else {
            $data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
            $this->load->view('foundation_view/header');
            $this->load->view('admin_view/admin_menu/navbar_admin');
            $this->load->view('admin_view/admin_typical_ribbon_status_off/admin_typical_ribbon_amount_form', $data);
            $this->load->view('main_view/container_footer');
            $this->load->view('foundation_view/footer');
        }
    }

    public function action_get_ribbon_amount()
    {
        $this->load->library('pdf');

        $unitID = $this->myfunction->decode($this->input->post('unitid'));

        $data['year']        = $this->input->post('year');
        $data['condition']  = $this->input->post('condition');
        $data['headquarters']   = ($unitID == '6001000000') ? 'กระทรวงกลาโหม' : 'กองทัพไทย';
        $data['unit_name']      = ($unitID == '6001000000') ? array('NPRT_NAME' => 'กองบัญชาการกองทัพไทย') : $this->person_data->get_unit_name($unitID);
        $data['p1_rank']        = $this->input->post('p1_rank');
        $data['p1_name']        = $this->input->post('p1_name');
        $data['p1_position']    = $this->input->post('p1_position');

        $data['ribbon_acm'] = 'ม.ป.ช.';
        $data['persons_mpc']    = $this->atr_model->get_person_prop_by_medal_biog_back($unitID, $data)->result_array();
        $data['ribbon_acm'] = 'ม.ว.ม.';
        $data['persons_mvm']    = $this->atr_model->get_person_prop_by_medal_biog_back($unitID, $data)->result_array();
        $data['ribbon_acm'] = 'ป.ช.';
        $data['persons_pc']     = $this->atr_model->get_person_prop_by_medal_biog_back($unitID, $data)->result_array();
        $data['ribbon_acm'] = 'ป.ม.';
        $data['persons_pm']     = $this->atr_model->get_person_prop_by_medal_biog_back($unitID, $data)->result_array();

        $persons_mpc_men        = array_filter($data['persons_mpc'], function ($r) {
            return $r['BIOG_SEX'] == 0;
        });
        $persons_mpc_women      = array_filter($data['persons_mpc'], function ($r) {
            return $r['BIOG_SEX'] == 1;
        });
        $data['mpc']['men']     = count($persons_mpc_men);
        $data['mpc']['women']   = count($persons_mpc_women);

        $persons_mvm_men        = array_filter($data['persons_mvm'], function ($r) {
            return $r['BIOG_SEX'] == 0;
        });
        $persons_mvm_women      = array_filter($data['persons_mvm'], function ($r) {
            return $r['BIOG_SEX'] == 1;
        });
        $data['mvm']['men']     = count($persons_mvm_men);
        $data['mvm']['women']   = count($persons_mvm_women);

        $persons_pc_men        = array_filter($data['persons_pc'], function ($r) {
            return $r['BIOG_SEX'] == 0;
        });
        $persons_pc_women      = array_filter($data['persons_pc'], function ($r) {
            return $r['BIOG_SEX'] == 1;
        });
        $data['pc']['men']     = count($persons_pc_men);
        $data['pc']['women']   = count($persons_pc_women);

        $persons_pm_men        = array_filter($data['persons_pm'], function ($r) {
            return $r['BIOG_SEX'] == 0;
        });
        $persons_pm_women      = array_filter($data['persons_pm'], function ($r) {
            return $r['BIOG_SEX'] == 1;
        });
        $data['pm']['men']     = count($persons_pm_men);
        $data['pm']['women']   = count($persons_pm_women);

        // var_dump($data);
        // $this->load->view('admin_view/admin_typical_ribbon/gen_ribbon_amount', $data);
        $this->load->view('pdf_report/ordinary_ribbon/total_group_report', $data);
    }

    public function person_detail_back()
    {
        $biogID = $this->input->get('id');
        $data['person'] = $this->atr_model->get_person_detail_back($biogID)->row_array();
        $data['ranks'] = $this->lib_model->get_all_rank()->result_array();
        $data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('admin_view/admin_menu/navbar_admin');
        $this->load->view('admin_view/admin_typical_ribbon_status_off/admin_person_detail_back', $data);
        $this->load->view('main_view/container_footer');
        $this->load->view('foundation_view/footer');
    }

    public function ajax_update_person_detail_back()
    {
        $input['biogName']      = $this->input->post('name', true);
        $input['rank']          = $this->input->post('rank', true);
        $input['posnameFull']   = $this->input->post('posnameFull', true);
        $input['salary']        = str_replace(' ', '', $this->input->post('salary', true));
        $input['slevel']        = str_replace(' ', '', $this->input->post('slevel', true));
        $input['sclass']        = str_replace(' ', '', $this->input->post('sclass', true));
        $input['idp']           = $this->input->post('idp', true);
        $update = $this->atr_model->update_person_detail_back($input);
        if ($update) {
            $result['status'] = true;
            $result['text'] = 'บันทึกสำเร็จ';
        } else {
            $result['status'] = false;
            $result['text'] = 'บันทึกไม่สำเร็จ';
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}
