<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('admin_model');
		$this->load->library('myfunction');
	}

	public function index()
	{

		$data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);

		$this->load->view('foundation_view/header');
		$this->load->view('admin_view/admin_menu/navbar_admin');
		$this->load->view('admin_view/admin_index', $data);
		$this->load->view('main_view/container_footer');
		$this->load->view('foundation_view/footer');
	}

	public function ajax_get_unit()
	{
		$result = $this->admin_model->get_unit();
		if ($result->num_rows() > 0) {
			$unit = $result->result_array();
			$data = [];
			foreach ($unit as $r) {
				$dt['NPRT_ACM']		= $r['NPRT_ACM'];
				$dt['NPRT_UNIT']	= $this->myfunction->encode($r['NPRT_UNIT']);
				$dt['NPRT_KEY']		= substr($r['NPRT_UNIT'], 0, 4);
				$data[] = $dt;
			}
		} else {
			$data = [];
		}

		echo json_encode($data);
	}

	public function set_system_status()
	{
		$data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
		$this->load->view('foundation_view/header');
		$this->load->view('admin_view/admin_menu/navbar_admin');
		$this->load->view('admin_view/admin_setting_status', $data);
		$this->load->view('main_view/container_footer');
		$this->load->view('foundation_view/footer');
	}

	public function ajax_get_system_status()
	{
		$file = 'assets/status/status.conf';
		if (is_readable($file)) {
			$fp = fopen($file, 'r');
			if ($fp) {
				$result['status'] = true;
				$result['text'] = fread($fp, filesize($file));
				fclose($fp);
			} else {
				$result['status'] = false;
				$result['text'] = '';
			}
		} else {
			$result['status'] = false;
			$result['text'] = 'File not found.';
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	public function ajax_on_system_status()
	{
		$file = 'assets/status/status.conf';
		if (is_readable($file)) {
			$fp = fopen($file, 'w+');
			if ($fp) {
				fwrite($fp, '1');
				rewind($fp);
				$data = fread($fp, filesize($file));
				fclose($fp);
				$result['status'] = true;
				$result['text'] = $data;
			} else {
				$result['status'] = false;
				$result['text'] = '';
			}
		} else {
			$result['status'] = false;
			$result['text'] = 'Unwriteable';
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	public function ajax_off_system_status()
	{
		$file = 'assets/status/status.conf';
		if (is_readable($file)) {
			$fp = fopen($file, 'w+');
			if ($fp) {
				fwrite($fp, '0');
				rewind($fp);
				$data = fread($fp, filesize($file));
				fclose($fp);
				$result['status'] = true;
				$result['text'] = $data;
			} else {
				$result['status'] = false;
				$result['text'] = '';
			}
		} else {
			$result['status'] = false;
			$result['text'] = 'Unwriteable';
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}
}
