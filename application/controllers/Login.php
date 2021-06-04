<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
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
		$data['username'] = $this->input->post('username');
		$data['password'] = $this->input->post('password');

		$system = $this->set_env->get_system_status();
		if ($system == 0) {
			$result['status'] = false;
			$result['text'] = '! ระบบได้ปิดการแก้ไขแล้ว';
		} else {
			$sessData = array(
				'user' => $data['username'],
				'privilege' => $data['username'],
				'unit' => $data['username'],
				'isLogged' => true
			);
			$this->session->set_userdata($sessData);
			
			$result['status'] = true;
			$result['text'] = 'เข้าระบบสำเร็จ';
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login/index');
	}
}
