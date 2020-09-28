<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_typical_ribbon extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('admin_typical_ribbon_model', 'atr_model');
		$this->load->library('myfunction');
		$this->load->library('person_data');
	}

	public function property()
	{

		$data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);

		$this->load->view('foundation_view/header');
		$this->load->view('admin_view/admin_menu/navbar_admin');
		$this->load->view('admin_view/admin_typical_ribbon/admin_typical_ribbon_index', $data);
		$this->load->view('main_view/container_footer');
		$this->load->view('foundation_view/footer');
	}
	
	public function fundation()
	{
		$data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
	
		$this->load->view('foundation_view/header');
		$this->load->view('admin_view/admin_menu/navbar_admin');
		$this->load->view('admin_view/admin_typical_ribbon/admin_typical_ribbon_fundation', $data);
		$this->load->view('main_view/container_footer');
		$this->load->view('foundation_view/footer');
	}

	public function ajax_get_person_bdec()
	{
		$unitInput 	= $this->input->post('unitid');
		$unitID4 	= substr($this->myfunction->decode($unitInput),0,4);
		$person 	= $this->atr_model->get_person_bdec($unitID4)->result_array();
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

		$response = json_encode($result);
		$this->output
			->set_content_type('application/json')
			->set_output($response);
	}

	
}
