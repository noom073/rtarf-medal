<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_non_ribbon extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('myfunction');
        $this->load->library('person_data');

        $this->load->model('admin_nonribbon_model');
        $this->load->model('admin_nonribbon_filter_model', 'anrf_model');
    }

    public function index()
    {
        $data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('admin_view/admin_menu/navbar_admin');
        $this->load->view('admin_view/admin_nonribbon/admin_nonribbon_property_form', $data);
        $this->load->view('main_view/container_footer');
        $this->load->view('foundation_view/footer');
    }

    public function action_get_person_prop()
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
        $data['condition']      = $this->input->post('condition');
        $data['type']           = $this->input->post('type');

        if ($data['type'] == 'officer') {
            $data['persons'] = $this->anrf_model->get_officer_prop($unitID, $medal, $data['year']);
        } else {
            # code...
        }
        
        // var_dump($data);
        $this->load->view('pdf_report/non_ribbon/property_list_report', $data);
    }

    public function summarize_name()
    {
        $data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('admin_view/admin_menu/navbar_admin');
        $this->load->view('admin_view/admin_nonribbon/admin_summarize_name_form', $data);
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
        $data['condition']      = $this->input->post('condition');
        $data['year']           = $this->input->post('year');
        $data['unit_name']      = $this->person_data->get_unit_name($unitID);

        $data['thc'] = $this->admin_nonribbon_model->get_person_prop($unitID, array('ท.ช.'), '05')->result_array();
        $data['thm'] = $this->admin_nonribbon_model->get_person_prop($unitID, array('ท.ม.'), '06')->result_array();
        $data['tc'] = $this->admin_nonribbon_model->get_person_prop($unitID, array('ต.ช.'), '07')->result_array();
        $data['tm'] = $this->admin_nonribbon_model->get_person_prop($unitID, array('ต.ม.'), '08')->result_array();
        $data['jc'] = $this->admin_nonribbon_model->get_person_prop($unitID, array('จ.ช.'), '09')->result_array();

        $rsJm = $this->admin_nonribbon_model->get_person_prop($unitID, array('จ.ม.'), array('10', '11'))->result_array();
        $data['jm'] = $this->admin_nonribbon_model->jm_person_filter($rsJm);

        $rsBc = $this->admin_nonribbon_model->get_person_prop($unitID, array('บ.ช.'), array('11', '21'))->result_array();
        $data['bc'] = $this->admin_nonribbon_model->bc_person_filter($rsBc);

        $rsBm = $this->admin_nonribbon_model->get_person_prop($unitID, array('บ.ม.'), array('11', '21', '22', '23', '24'))->result_array();
        $data['bm'] = $this->admin_nonribbon_model->bm_person_filter($rsBm);

        $rsRtc = $this->admin_nonribbon_model->get_person_coin_prop($unitID, array('21', '22', '23', '24'))->result_array();
        $data['rtc'] = $this->admin_nonribbon_model->rtc_person_filter($rsRtc);

        $rsRtm = $this->admin_nonribbon_model->get_person_coin_prop($unitID, array('25'))->result_array();
        $data['rtm'] = $this->admin_nonribbon_model->rtm_person_filter($rsRtm);

        $rsRgc = $this->admin_nonribbon_model->get_person_coin_prop($unitID, array('26'))->result_array();
        $data['rgc'] = $this->admin_nonribbon_model->rgc_person_filter($rsRgc);

        $rsRgm = $this->admin_nonribbon_model->get_person_coin_prop($unitID, array('27'))->result_array();
        $data['rgm'] = $this->admin_nonribbon_model->rgm_person_filter($rsRgm);

        // var_dump($data);
        // $this->load->view('admin_view/admin_nonribbon/gen_summarize_name', $data);
        $this->load->view('pdf_report/non_ribbon/name_list_report', $data);
    }

    public function nonribbon_amount()
    {
        $data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('admin_view/admin_menu/navbar_admin');
        $this->load->view('admin_view/admin_nonribbon/person_amount_form', $data);
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
        $data['condition']      = $this->input->post('condition');
        $data['year']           = $this->input->post('year');
        $data['unit_name']      = $this->person_data->get_unit_name($unitID);

        $dtthc = $this->admin_nonribbon_model->get_person_prop($unitID, array('ท.ช.'), '05')->result_array();
        $dtthm = $this->admin_nonribbon_model->get_person_prop($unitID, array('ท.ม.'), '06')->result_array();
        $dttc = $this->admin_nonribbon_model->get_person_prop($unitID, array('ต.ช.'), '07')->result_array();
        $dttm = $this->admin_nonribbon_model->get_person_prop($unitID, array('ต.ม.'), '08')->result_array();
        $dtjc = $this->admin_nonribbon_model->get_person_prop($unitID, array('จ.ช.'), '09')->result_array();

        $rsJm = $this->admin_nonribbon_model->get_person_prop($unitID, array('จ.ม.'), array('10', '11'))->result_array();
        $dtjm = $this->admin_nonribbon_model->jm_person_filter($rsJm);

        $rsBc = $this->admin_nonribbon_model->get_person_prop($unitID, array('บ.ช.'), array('11', '21'))->result_array();
        $dtbc = $this->admin_nonribbon_model->bc_person_filter($rsBc);

        $rsBm = $this->admin_nonribbon_model->get_person_prop($unitID, array('บ.ม.'), array('11', '21', '22', '23', '24'))->result_array();
        $dtbm = $this->admin_nonribbon_model->bm_person_filter($rsBm);

        $rsRtc = $this->admin_nonribbon_model->get_person_coin_prop($unitID, array('21', '22', '23', '24'))->result_array();
        $dtrtc = $this->admin_nonribbon_model->rtc_person_filter($rsRtc);

        $rsRtm = $this->admin_nonribbon_model->get_person_coin_prop($unitID, array('25'))->result_array();
        $dtrtm = $this->admin_nonribbon_model->rtm_person_filter($rsRtm);

        $rsRgc = $this->admin_nonribbon_model->get_person_coin_prop($unitID, array('26'))->result_array();
        $dtrgc = $this->admin_nonribbon_model->rgc_person_filter($rsRgc);

        $rsRgm = $this->admin_nonribbon_model->get_person_coin_prop($unitID, array('27'))->result_array();
        $dtrgm = $this->admin_nonribbon_model->rgm_person_filter($rsRgm);

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

        $persons_rtm_men        = array_filter($dtrtm, function ($r) {
            return $r['BIOG_SEX'] == 0;
        });
        $persons_rtm_women      = array_filter($dtrtm, function ($r) {
            return $r['BIOG_SEX'] == 1;
        });
        $data['rtm']['men']     = count($persons_rtm_men);
        $data['rtm']['women']   = count($persons_rtm_women);

        $persons_rgc_men        = array_filter($dtrgc, function ($r) {
            return $r['BIOG_SEX'] == 0;
        });
        $persons_rgc_women      = array_filter($dtrgc, function ($r) {
            return $r['BIOG_SEX'] == 1;
        });
        $data['rgc']['men']     = count($persons_rgc_men);
        $data['rgc']['women']   = count($persons_rgc_women);

        $persons_rgm_men        = array_filter($dtrgm, function ($r) {
            return $r['BIOG_SEX'] == 0;
        });
        $persons_rgm_women      = array_filter($dtrgm, function ($r) {
            return $r['BIOG_SEX'] == 1;
        });
        $data['rgm']['men']     = count($persons_rgm_men);
        $data['rgm']['women']   = count($persons_rgm_women);

        $this->load->view('pdf_report/non_ribbon/total_group_report', $data);
    }
}
