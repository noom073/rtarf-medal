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
        $unitID = $this->myfunction->decode($this->input->post('unitid'));
        $ribbon    = $this->input->post('ribbon_type');

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
        } else if ($ribbon == 'ท.ม.') {
        } else if ($ribbon == 'ต.ช.') {
        } else if ($ribbon == 'ต.ม.') {
        } else if ($ribbon == 'จ.ช.') {
        } else if ($ribbon == 'จ.ม.') {
        } else if ($ribbon == 'บ.ช.') {
        } else if ($ribbon == 'บ.ม.') {
        } else if ($ribbon == 'ร.ท.ช.') {
        } else if ($ribbon == 'ร.ท.ม.') {
        } else if ($ribbon == 'ร.ง.ช.') {
        } else if ($ribbon == 'ร.ง.ม.') {
        } else {
            # code...
        }
    }
}
