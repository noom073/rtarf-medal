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
        $ribbon = $this->input->post('ribbon_type');

        $data['unit_name']      = $this->person_data->get_unit_name($unitID);
        $data['ribbon_acm']     = $ribbon;
        $data['ribbon_name']    = $this->person_data->medal_full_name($ribbon);
        $data['year']           = $this->input->post('year');
        $data['p1_rank']        = $this->input->post('p1_rank');
        $data['p1_name']        = $this->input->post('p1_name');
        $data['p1_position']    = $this->input->post('p1_position');
        $data['p2_rank']        = $this->input->post('p2_rank');
        $data['p2_name']        = $this->input->post('p2_name');
        $data['p2_position']    = $this->input->post('p2_position');

        if ($ribbon == 'ท.ช.') {
            $decArray = array('ท.ช.');
            $data['persons'] = $this->admin_nonribbon_model->get_person_prop($unitID, $decArray, '05')->result_array();
        } else if ($ribbon == 'ท.ม.') {
            $decArray = array('ท.ม.');
            $data['persons'] = $this->admin_nonribbon_model->get_person_prop($unitID, $decArray, '06')->result_array();
        } else if ($ribbon == 'ต.ช.') {
            $decArray = array('ต.ช.');
            $data['persons'] = $this->admin_nonribbon_model->get_person_prop($unitID, $decArray, '07')->result_array();
        } else if ($ribbon == 'ต.ม.') {
            $decArray = array('ต.ม.');
            $data['persons'] = $this->admin_nonribbon_model->get_person_prop($unitID, $decArray, '08')->result_array();
        } else if ($ribbon == 'จ.ช.') {
            $decArray = array('จ.ช.');
            $data['persons'] = $this->admin_nonribbon_model->get_person_prop($unitID, $decArray, '09')->result_array();
        } else if ($ribbon == 'จ.ม.') {
            $decArray = array('จ.ม.');
            $rankAray = array('10', '11');
            $result = $this->admin_nonribbon_model->get_person_prop($unitID, $decArray, $rankAray)->result_array();
            $data['persons'] = $this->admin_nonribbon_model->jm_person_filter($result);
        } else if ($ribbon == 'บ.ช.') {
            $decArray = array('บ.ช.');
            $rankAray = array('11', '21');
            $result = $this->admin_nonribbon_model->get_person_prop($unitID, $decArray, $rankAray)->result_array();
            $data['persons'] = $this->admin_nonribbon_model->bc_person_filter($result);
        } else if ($ribbon == 'บ.ม.') {
            $decArray = array('บ.ม.');
            $rankAray = array('11', '21', '22', '23', '24');
            $result = $this->admin_nonribbon_model->get_person_prop($unitID, $decArray, $rankAray)->result_array();
            $data['persons'] = $this->admin_nonribbon_model->bm_person_filter($result);
        } else if ($ribbon == 'ร.ท.ช.') {
            // $decArray = array('ร.ท.ช.', 'บ.ม.', 'บ.ช.');
            $rankAray = array('21', '22', '23', '24');
            $result = $this->admin_nonribbon_model->get_person_coin_prop($unitID, $rankAray)->result_array();
            $data['persons'] = $this->admin_nonribbon_model->rtc_person_filter($result);
        } else if ($ribbon == 'ร.ท.ม.') {
            // $decArray = array('ร.ท.ม.');
            $rankAray = array('25');
            $result = $this->admin_nonribbon_model->get_person_coin_prop($unitID, $rankAray)->result_array();
            $data['persons'] = $this->admin_nonribbon_model->rtm_person_filter($result);
        } else if ($ribbon == 'ร.ง.ช.') {
            // $decArray = array('ร.ง.ช.');
            $rankAray = array('26');
            $result = $this->admin_nonribbon_model->get_person_coin_prop($unitID, $rankAray)->result_array();
            $data['persons'] = $this->admin_nonribbon_model->rgc_person_filter($result);
        } else if ($ribbon == 'ร.ง.ม.') {
            // $decArray = array('ร.ง.ม.');
            $rankAray = array('27');
            $result = $this->admin_nonribbon_model->get_person_coin_prop($unitID, $rankAray)->result_array();
            $data['persons'] = $this->admin_nonribbon_model->rgm_person_filter($result);
        } else {
            $data['persons'] = [];
        }

        // var_dump($result);
        $this->load->view('admin_view/admin_nonribbon/gen_property', $data);
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

        // $data['persons_mpc']    = $this->admin_ribbon_prop_model->get_person_prop_mpc($unitID, $data['year'])->result_array();
        // $data['persons_mvm']    = $this->admin_ribbon_prop_model->get_person_prop_mvm($unitID, $data['year'])->result_array();
        // $data['persons_pc']     = $this->admin_ribbon_prop_model->get_person_prop_pc($unitID, $data['year'])->result_array();
        // $data['persons_pm']     = $this->admin_ribbon_prop_model->get_person_prop_pm($unitID, $data['year']);

        // var_dump($data);
        $this->load->view('admin_view/admin_nonribbon/gen_summarize_name', $data);
    }
}
