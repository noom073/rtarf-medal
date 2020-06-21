<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_ribbon extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('myfunction');
        $this->load->library('person_data');

        $this->load->model('admin_ribbon_model');
        $this->load->model('admin_ribbon_prop_model');
    }

    public function property_form()
    {
        $data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('admin_view/admin_menu/navbar_admin');
        $this->load->view('admin_view/admin_ribbon/admin_ribbon_property_form', $data);
        $this->load->view('main_view/container_footer');
        $this->load->view('foundation_view/footer');
    }

    public function action_get_ribbon_person_prop()
    {
        $this->load->library('pdf');

        $unitID = $this->myfunction->decode($this->input->post('unitid'));
        $ribbon    = $this->input->post('ribbon_type');

        $data['unit_name']      = $this->person_data->get_unit_name($unitID);
        $data['ribbon_acm']     = $ribbon;
        $data['ribbon_name']    = $this->person_data->medal_full_name($ribbon);
        $data['p1_rank']        = $this->input->post('p1_rank');
        $data['p1_name']        = $this->input->post('p1_name');
        $data['p1_position']    = $this->input->post('p1_position');
        $data['p2_rank']        = $this->input->post('p2_rank');
        $data['p2_name']        = $this->input->post('p2_name');
        $data['p2_position']    = $this->input->post('p2_position');

        if ($ribbon == 'ม.ป.ช.') {
            $data['persons'] = $this->admin_ribbon_prop_model->get_person_prop_mpc($unitID)->result_array();
        } else if ($ribbon == 'ม.ว.ม.') {
            $data['persons'] = $this->admin_ribbon_prop_model->get_person_prop_mvm($unitID)->result_array();
        } else if ($ribbon == 'ป.ช.') {
            $data['persons'] = $this->admin_ribbon_prop_model->get_person_prop_pc($unitID)->result_array();
        } else if ($ribbon == 'ป.ม.') {
            $data['persons'] = $this->admin_ribbon_prop_model->get_person_prop_pm($unitID)->result_array();
        } else {
            $data['persons'] = [];
        }

        $this->load->view('admin_view/admin_ribbon/gen_ribbon_property', $data);
    }
}
