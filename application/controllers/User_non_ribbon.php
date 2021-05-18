<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_non_ribbon extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('myfunction');
        $this->load->library('person_data');
        $this->load->library('set_env');

        $this->load->model('user_nonribbon_filter_model', 'unrf_model');
    }

    public function index()
    {
        $unit = $this->unrf_model->get_unitname($this->session->unit)->row_array();
        $data['unitname']     = $unit['NPRT_NAME'];
        $data['unitID']     = $this->myfunction->encode($unit['NPRT_UNIT']);
        $data['sidemenu'] = $this->load->view('user_view/user_menu/list_user_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('user_view/user_menu/navbar_user', $data);
        $this->load->view('user_view/user_nonribbon/user_nonribbon_property_form', $data);
        $this->load->view('main_view/container_footer');
        $this->load->view('foundation_view/footer');
    }

    public function action_get_person_prop()
    {
        $this->load->library('pdf');

        $unitID = $this->myfunction->decode($this->input->post('unitid'));
        $medal = $this->input->post('ribbon_type');

        $data['headquarters']   = ($unitID == '6001000000') ? 'กระทรวงกลาโหม' : 'กองทัพไทย';
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
        $data['type']           = $this->input->post('type');

        if ($data['type'] == 'officer') {
            $data['persons'] = $this->unrf_model->get_officer_prop($unitID, $medal, $data['year']);
        } elseif ($data['type'] == 'employee') {
            $data['persons'] = $this->unrf_model->get_employee_prop($unitID, $medal, $data['year']);
        } else {
            $data['persons'] = [];
        }

        // var_dump($data);
        $this->load->view('pdf_report/non_ribbon/property_list_report', $data);
    }

    public function summarize_name()
    {
        $unit = $this->unrf_model->get_unitname($this->session->unit)->row_array();
        $data['unitname']     = $unit['NPRT_NAME'];
        $data['unitID']     = $this->myfunction->encode($unit['NPRT_UNIT']);
        $data['sidemenu'] = $this->load->view('user_view/user_menu/list_user_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('user_view/user_menu/navbar_user', $data);
        $this->load->view('user_view/user_nonribbon/user_summarize_name_form', $data);
        $this->load->view('main_view/container_footer');
        $this->load->view('foundation_view/footer');
    }

    public function action_summarize_name()
    {
        $this->load->library('pdf');
        $unitID = $this->myfunction->decode($this->input->post('unitid'));

        $data['p1_rank']        = $this->input->post('p1_rank');
        $data['p1_name']        = $this->input->post('p1_name');
        $data['p1_position']    = $this->input->post('p1_position');
        $data['type']           = $this->input->post('type');
        $data['year']           = $this->input->post('year');
        $data['headquarters']   = ($unitID == '6001000000') ? 'กระทรวงกลาโหม' : 'กองทัพไทย';
        $data['unit_name']      = $this->person_data->get_unit_name($unitID);

        if ($data['type'] == 'officer') {
            $data['validType'] = true;
            $data['thc'] = $this->unrf_model->get_officer_prop($unitID, 'ท.ช.', $data['year']);
            $data['thm'] = $this->unrf_model->get_officer_prop($unitID, 'ท.ม.', $data['year']);
            $data['tc'] = $this->unrf_model->get_officer_prop($unitID, 'ต.ช.', $data['year']);
            $data['tm'] = $this->unrf_model->get_officer_prop($unitID, 'ต.ม.', $data['year']);
            $data['jc'] = $this->unrf_model->get_officer_prop($unitID, 'จ.ช.', $data['year']);
            $data['jm'] = $this->unrf_model->get_officer_prop($unitID, 'จ.ม.', $data['year']);
            $data['bc'] = $this->unrf_model->get_officer_prop($unitID, 'บ.ช.', $data['year']);
            $data['bm'] = $this->unrf_model->get_officer_prop($unitID, 'บ.ม.', $data['year']);
            $data['rtc'] = $this->unrf_model->get_officer_prop($unitID, 'ร.ท.ช.', $data['year']);
        } elseif ($data['type'] == 'employee') {
            $data['validType'] = true;
            $data['thc'] = $this->unrf_model->get_employee_prop($unitID, 'ท.ช.', $data['year']);
            $data['thm'] = $this->unrf_model->get_employee_prop($unitID, 'ท.ม.', $data['year']);
            $data['tc'] = $this->unrf_model->get_employee_prop($unitID, 'ต.ช.', $data['year']);
            $data['tm'] = $this->unrf_model->get_employee_prop($unitID, 'ต.ม.', $data['year']);
            $data['jc'] = $this->unrf_model->get_employee_prop($unitID, 'จ.ช.', $data['year']);
            $data['jm'] = $this->unrf_model->get_employee_prop($unitID, 'จ.ม.', $data['year']);
            $data['bc'] = $this->unrf_model->get_employee_prop($unitID, 'บ.ช.', $data['year']);
            $data['bm'] = $this->unrf_model->get_employee_prop($unitID, 'บ.ม.', $data['year']);
            $data['rtc'] = $this->unrf_model->get_employee_prop($unitID, 'ร.ท.ช.', $data['year']);
        } else {
            $data['validType'] = false;
        }

        // var_dump($data);
        $this->load->view('pdf_report/non_ribbon/name_list_report', $data);
    }

    public function nonribbon_amount()
    {
        $unit = $this->unrf_model->get_unitname($this->session->unit)->row_array();
        $data['unitname']     = $unit['NPRT_NAME'];
        $data['unitID']     = $this->myfunction->encode($unit['NPRT_UNIT']);
        $data['sidemenu'] = $this->load->view('user_view/user_menu/list_user_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('user_view/user_menu/navbar_user', $data);
        $this->load->view('user_view/user_nonribbon/person_amount_form', $data);
        $this->load->view('main_view/container_footer');
        $this->load->view('foundation_view/footer');
    }

    public function action_person_amount()
    {
        $this->load->library('pdf');

        $unitID = $this->myfunction->decode($this->input->post('unitid'));
        $data['p1_rank']        = $this->input->post('p1_rank');
        $data['p1_name']        = $this->input->post('p1_name');
        $data['p1_position']    = $this->input->post('p1_position');
        $data['type']           = $this->input->post('type');
        $data['year']           = $this->input->post('year');
        $data['headquarters']   = ($unitID == '6001000000') ? 'กระทรวงกลาโหม' : 'กองทัพไทย';
        $data['unit_name']      = $this->person_data->get_unit_name($unitID);

        if ($data['type'] == 'officer') {
            $data['validType'] = true;
            $dtthc = $this->unrf_model->get_officer_prop($unitID, 'ท.ช.', $data['year']);
            $dtthm = $this->unrf_model->get_officer_prop($unitID, 'ท.ม.', $data['year']);
            $dttc = $this->unrf_model->get_officer_prop($unitID, 'ต.ช.', $data['year']);
            $dttm = $this->unrf_model->get_officer_prop($unitID, 'ต.ม.', $data['year']);
            $dtjc = $this->unrf_model->get_officer_prop($unitID, 'จ.ช.', $data['year']);
            $dtjm = $this->unrf_model->get_officer_prop($unitID, 'จ.ม.', $data['year']);
            $dtbc = $this->unrf_model->get_officer_prop($unitID, 'บ.ช.', $data['year']);
            $dtbm = $this->unrf_model->get_officer_prop($unitID, 'บ.ม.', $data['year']);
            $dtrtc = $this->unrf_model->get_officer_prop($unitID, 'ร.ท.ช.', $data['year']);
        } elseif ($data['type'] == 'employee') {
            $data['validType'] = true;
            $dtthc = $this->unrf_model->get_employee_prop($unitID, 'ท.ช.', $data['year']);
            $dtthm = $this->unrf_model->get_employee_prop($unitID, 'ท.ม.', $data['year']);
            $dttc = $this->unrf_model->get_employee_prop($unitID, 'ต.ช.', $data['year']);
            $dttm = $this->unrf_model->get_employee_prop($unitID, 'ต.ม.', $data['year']);
            $dtjc = $this->unrf_model->get_employee_prop($unitID, 'จ.ช.', $data['year']);
            $dtjm = $this->unrf_model->get_employee_prop($unitID, 'จ.ม.', $data['year']);
            $dtbc = $this->unrf_model->get_employee_prop($unitID, 'บ.ช.', $data['year']);
            $dtbm = $this->unrf_model->get_employee_prop($unitID, 'บ.ม.', $data['year']);
            $dtrtc = $this->unrf_model->get_employee_prop($unitID, 'ร.ท.ช.', $data['year']);
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
        $this->load->view('pdf_report/non_ribbon/total_group_report', $data);
    }

    public function prepare_save_bdec()
    {
        if ($this->set_env->get_system_status() == 0) {
            redirect('user_fundamental/system_off');
        } else {
            $unit = $this->unrf_model->get_unitname($this->session->unit)->row_array();
            $data['unitname']   = $unit['NPRT_NAME'];
            $data['unitID']     = $this->myfunction->encode($unit['NPRT_UNIT']);
            $data['sidemenu']   = $this->load->view('user_view/user_menu/list_user_menu', null, true);
            $this->load->view('foundation_view/header');
            $this->load->view('user_view/user_menu/navbar_user', $data);
            $this->load->view('user_view/user_nonribbon/save_person_bdec_view', $data);
            $this->load->view('main_view/container_footer');
            $this->load->view('foundation_view/footer');
        }
    }

    // public function ajax_save_person_to_bdec() // BACKUP BEFORE UPDATE PROCESS 07-04-2564
    // {
    //     $result = array();
    //     if ($this->set_env->get_system_status() == 1) {
    //         $unitIDEnc  = $this->input->post('unitid');
    //         $unitID     = $this->myfunction->decode($unitIDEnc);
    //         $data['year']   = (int) date("Y") + 543;

    //         $personThc = $this->user_nonribbon_model->get_person_prop($unitID, array('ท.ช.'), '05')->result_array();
    //         $personThm = $this->user_nonribbon_model->get_person_prop($unitID, array('ท.ม.'), '06')->result_array();
    //         $personTc = $this->user_nonribbon_model->get_person_prop($unitID, array('ต.ช.'), '07')->result_array();
    //         $personTm = $this->user_nonribbon_model->get_person_prop($unitID, array('ต.ม.'), '08')->result_array();
    //         $personJc = $this->user_nonribbon_model->get_person_prop($unitID, array('จ.ช.'), '09')->result_array();

    //         $rsJm = $this->user_nonribbon_model->get_person_prop($unitID, array('จ.ม.'), array('10', '11'))->result_array();
    //         $personJm = $this->user_nonribbon_model->jm_person_filter($rsJm);

    //         $rsBc = $this->user_nonribbon_model->get_person_prop($unitID, array('บ.ช.'), array('11', '21'))->result_array();
    //         $personBc = $this->user_nonribbon_model->bc_person_filter($rsBc);

    //         $rsBm = $this->user_nonribbon_model->get_person_prop($unitID, array('บ.ม.'), array('11', '21', '22', '23', '24'))->result_array();
    //         $personBm = $this->user_nonribbon_model->bm_person_filter($rsBm);

    //         $rsRtc = $this->user_nonribbon_model->get_person_coin_prop($unitID, array('21', '22', '23', '24'))->result_array();
    //         $personRtc = $this->user_nonribbon_model->rtc_person_filter($rsRtc);

    //         foreach ($personThc as $r) {
    //             $insertBdec = $this->user_nonribbon_model->process_insert_to_bdec($r, 'ท.ช.');
    //             array_push($result, $insertBdec);
    //         }
    //         foreach ($personThm as $r) {
    //             $insertBdec = $this->user_nonribbon_model->process_insert_to_bdec($r, 'ท.ม.');
    //             array_push($result, $insertBdec);
    //         }
    //         foreach ($personTc as $r) {
    //             $insertBdec = $this->user_nonribbon_model->process_insert_to_bdec($r, 'ต.ช.');
    //             array_push($result, $insertBdec);
    //         }
    //         foreach ($personTm as $r) {
    //             $insertBdec = $this->user_nonribbon_model->process_insert_to_bdec($r, 'ต.ม.');
    //             array_push($result, $insertBdec);
    //         }
    //         foreach ($personJc as $r) {
    //             $insertBdec = $this->user_nonribbon_model->process_insert_to_bdec($r, 'จ.ช.');
    //             array_push($result, $insertBdec);
    //         }
    //         foreach ($personJm as $r) {
    //             $insertBdec = $this->user_nonribbon_model->process_insert_to_bdec($r, 'จ.ม.');
    //             array_push($result, $insertBdec);
    //         }
    //         foreach ($personBc as $r) {
    //             $insertBdec = $this->user_nonribbon_model->process_insert_to_bdec($r, 'บ.ช.');
    //             array_push($result, $insertBdec);
    //         }
    //         foreach ($personBm as $r) {
    //             $insertBdec = $this->user_nonribbon_model->process_insert_to_bdec($r, 'บ.ม.');
    //             array_push($result, $insertBdec);
    //         }
    //         foreach ($personRtc as $r) {
    //             $insertBdec = $this->user_nonribbon_model->process_insert_to_bdec($r, 'ร.ท.ช.');
    //             array_push($result, $insertBdec);
    //         }
    //     }
    //     $response = json_encode($result);
    //     $this->output
    //         ->set_content_type('application/json')
    //         ->set_output($response);
    // }

    public function ajax_save_person_to_bdec()
    {
        if ($this->set_env->get_system_status() == 1) {
            $unitIDEnc  = $this->input->post('unitid');
            $unitID     = $this->myfunction->decode($unitIDEnc);
            $unitID4    = substr($unitID, 0, 4);
            $data['year']   = (int) date("Y") + 543;
            $typeList = $this->unrf_model->getPersonBeforeInsertBdec($unitID4, $data['year']);
            $insertResult = $this->unrf_model->runInList_insertBdec($typeList);
        } else {
            $insertResult = [];
        }

        $response = json_encode($insertResult);
        $this->output
            ->set_content_type('application/json')
            ->set_output($response);
    }
}
