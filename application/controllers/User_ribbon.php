<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_ribbon extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('myfunction');
        $this->load->library('person_data');

        // $this->load->model('admin_ribbon_model');
        $this->load->model('user_ribbon_prop_model');
    }

    public function property_form()
    {
        $unit = $this->user_ribbon_prop_model->get_unitname($this->session->unit)->row_array();
		$data['unitname'] 	= $unit['NPRT_NAME'];
		$data['unitID'] 	= $this->myfunction->encode($unit['NPRT_UNIT']);
        $data['sidemenu'] = $this->load->view('user_view/user_menu/list_user_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('user_view/user_menu/navbar_user', $data);
        $this->load->view('user_view/user_ribbon/user_ribbon_property_form', $data);
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
        $data['year']           = $this->input->post('year');
        $data['p1_rank']        = $this->input->post('p1_rank');
        $data['p1_name']        = $this->input->post('p1_name');
        $data['p1_position']    = $this->input->post('p1_position');
        $data['p2_rank']        = $this->input->post('p2_rank');
        $data['p2_name']        = $this->input->post('p2_name');
        $data['p2_position']    = $this->input->post('p2_position');

        if ($ribbon == 'ม.ป.ช.') {
            $data['persons'] = $this->user_ribbon_prop_model->get_person_prop_mpc($unitID, $data['year'])->result_array();
        } else if ($ribbon == 'ม.ว.ม.') {
            $data['persons'] = $this->user_ribbon_prop_model->get_person_prop_mvm($unitID, $data['year'])->result_array();
        } else if ($ribbon == 'ป.ช.') {
            $data['persons'] = $this->user_ribbon_prop_model->get_person_prop_pc($unitID, $data['year'])->result_array();
        } else if ($ribbon == 'ป.ม.') {
            $data['persons'] = $this->user_ribbon_prop_model->get_person_prop_pm($unitID, $data['year']);
        } else {
            $data['persons'] = [];
        }

        // var_dump($data);
        $this->load->view('user_view/user_ribbon/gen_ribbon_property', $data);
    }

    public function summarize_name_form()
    {
        $unit = $this->user_ribbon_prop_model->get_unitname($this->session->unit)->row_array();
		$data['unitname'] 	= $unit['NPRT_NAME'];
		$data['unitID'] 	= $this->myfunction->encode($unit['NPRT_UNIT']);
        $data['sidemenu'] = $this->load->view('user_view/user_menu/list_user_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('user_view/user_menu/navbar_user', $data);
        $this->load->view('user_view/user_ribbon/user_ribbon_summarize_name_form', $data);
        $this->load->view('main_view/container_footer');
        $this->load->view('foundation_view/footer');
    }

    public function action_summarize_name()
    {
        $this->load->library('pdf');

        $unitID = $this->myfunction->decode($this->input->post('unitid'));

        $data['year']           = $this->input->post('year');
        $data['unit_name']      = $this->person_data->get_unit_name($unitID);
        $data['persons_mpc']    = $this->user_ribbon_prop_model->get_person_prop_mpc($unitID, $data['year'])->result_array();
        $data['persons_mvm']    = $this->user_ribbon_prop_model->get_person_prop_mvm($unitID, $data['year'])->result_array();
        $data['persons_pc']     = $this->user_ribbon_prop_model->get_person_prop_pc($unitID, $data['year'])->result_array();
        $data['persons_pm']     = $this->user_ribbon_prop_model->get_person_prop_pm($unitID, $data['year']);
        
        // var_dump($data);
        // echo json_encode($data);
        $this->load->view('user_view/user_ribbon/gen_ribbon_summarize_name', $data);
    }

    public function ribbon_amount()
    {
        $unit = $this->user_ribbon_prop_model->get_unitname($this->session->unit)->row_array();
		$data['unitname'] 	= $unit['NPRT_NAME'];
		$data['unitID'] 	= $this->myfunction->encode($unit['NPRT_UNIT']);
        $data['sidemenu'] = $this->load->view('user_view/user_menu/list_user_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('user_view/user_menu/navbar_user',$data);
        $this->load->view('user_view/user_ribbon/user_ribbon_amount_form', $data);
        $this->load->view('main_view/container_footer');
        $this->load->view('foundation_view/footer');
    }

    public function action_get_ribbon_amount()
    {
        $this->load->library('pdf');

        $unitID = $this->myfunction->decode($this->input->post('unitid'));

        $data['year']           = $this->input->post('year');
        $data['unit_name']      = $this->person_data->get_unit_name($unitID);
        $data['persons_mpc']    = $this->user_ribbon_prop_model->get_person_prop_mpc($unitID, $data['year'])->result_array();
        $data['persons_mvm']    = $this->user_ribbon_prop_model->get_person_prop_mvm($unitID, $data['year'])->result_array();
        $data['persons_pc']     = $this->user_ribbon_prop_model->get_person_prop_pc($unitID, $data['year'])->result_array();
        $data['persons_pm']     = $this->user_ribbon_prop_model->get_person_prop_pm($unitID, $data['year']);
        
        $data['mpc']['men'] = 0;
        $data['mpc']['women'] = 0;
        foreach ($data['persons_mpc'] as $r) {
            if($r['BIOG_SEX'] == 0) $data['mpc']['men']++;
            if($r['BIOG_SEX'] == 1) $data['mpc']['women']++;
        }

        $data['mvm']['men'] = 0;
        $data['mvm']['women'] = 0;
        foreach ($data['persons_mvm'] as $r) {
            if($r['BIOG_SEX'] == 0) $data['mvm']['men']++;
            if($r['BIOG_SEX'] == 1) $data['mvm']['women']++;
        }

        $data['pc']['men'] = 0;
        $data['pc']['women'] = 0;
        foreach ($data['persons_pc'] as $r) {
            if($r['BIOG_SEX'] == 0) $data['pc']['men']++;
            if($r['BIOG_SEX'] == 1) $data['pc']['women']++;
        }

        $data['pm']['men'] = 0;
        $data['pm']['women'] = 0;
        foreach ($data['persons_pm'] as $r) {
            if($r['BIOG_SEX'] == 0) $data['pm']['men']++;
            if($r['BIOG_SEX'] == 1) $data['pm']['women']++;
        }

        // var_dump($data);
        $this->load->view('user_view/user_ribbon/gen_ribbon_amount', $data);

    }
}