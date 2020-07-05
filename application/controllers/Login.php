<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url', 'security');
	}

	public function index()
	{
		$this->load->view('foundation_view/header');
		$this->load->view('foundation_view/navbar_normal');
		$this->load->view('login_view/login_index');
		$this->load->view('main_view/container_footer');
		$this->load->view('foundation_view/footer');
	}

	public function ajax_login_process()
	{
		$data['username'] = $this->security->xss_clean($this->input->post('username'));
		$data['password'] = $this->security->xss_clean($this->input->post('password'));

		echo json_encode($data);

	}
}
