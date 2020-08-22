<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_typical_ribbon extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('admin_model');
		$this->load->library('myfunction');
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

	
}
