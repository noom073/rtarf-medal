<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_non_ribbon extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('myfunction');
        $this->load->library('person_data');

        $this->load->model('user_nonribbon_model');
    }

    public function index()
    {
        $unit = $this->user_nonribbon_model->get_unitname($this->session->unit)->row_array();
		$data['unitname'] 	= $unit['NPRT_NAME'];
		$data['unitID'] 	= $this->myfunction->encode($unit['NPRT_UNIT']);
        $data['sidemenu'] = $this->load->view('user_view/user_menu/list_user_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('user_view/user_menu/navbar_user', $data);
        $this->load->view('user_view/user_nonribbon/user_nonribbon_property_form', $data);
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
            $data['persons'] = $this->user_nonribbon_model->get_person_prop($unitID, $decArray, '05')->result_array();
        } else if ($ribbon == 'ท.ม.') {
            $decArray = array('ท.ม.');
            $data['persons'] = $this->user_nonribbon_model->get_person_prop($unitID, $decArray, '06')->result_array();
        } else if ($ribbon == 'ต.ช.') {
            $decArray = array('ต.ช.');
            $data['persons'] = $this->user_nonribbon_model->get_person_prop($unitID, $decArray, '07')->result_array();
        } else if ($ribbon == 'ต.ม.') {
            $decArray = array('ต.ม.');
            $data['persons'] = $this->user_nonribbon_model->get_person_prop($unitID, $decArray, '08')->result_array();
        } else if ($ribbon == 'จ.ช.') {
            $decArray = array('จ.ช.');
            $data['persons'] = $this->user_nonribbon_model->get_person_prop($unitID, $decArray, '09')->result_array();
        } else if ($ribbon == 'จ.ม.') {
            $decArray = array('จ.ม.');
            $rankAray = array('10', '11');
            $result = $this->user_nonribbon_model->get_person_prop($unitID, $decArray, $rankAray)->result_array();
            $data['persons'] = $this->user_nonribbon_model->jm_person_filter($result);
        } else if ($ribbon == 'บ.ช.') {
            $decArray = array('บ.ช.');
            $rankAray = array('11', '21');
            $result = $this->user_nonribbon_model->get_person_prop($unitID, $decArray, $rankAray)->result_array();
            $data['persons'] = $this->user_nonribbon_model->bc_person_filter($result);
        } else if ($ribbon == 'บ.ม.') {
            $decArray = array('บ.ม.');
            $rankAray = array('11', '21', '22', '23', '24');
            $result = $this->user_nonribbon_model->get_person_prop($unitID, $decArray, $rankAray)->result_array();
            $data['persons'] = $this->user_nonribbon_model->bm_person_filter($result);
        } else if ($ribbon == 'ร.ท.ช.') {
            // $decArray = array('ร.ท.ช.', 'บ.ม.', 'บ.ช.');
            $rankAray = array('21', '22', '23', '24');
            $result = $this->user_nonribbon_model->get_person_coin_prop($unitID, $rankAray)->result_array();
            $data['persons'] = $this->user_nonribbon_model->rtc_person_filter($result);
        } else if ($ribbon == 'ร.ท.ม.') {
            // $decArray = array('ร.ท.ม.');
            $rankAray = array('25');
            $result = $this->user_nonribbon_model->get_person_coin_prop($unitID, $rankAray)->result_array();
            $data['persons'] = $this->user_nonribbon_model->rtm_person_filter($result);
        } else if ($ribbon == 'ร.ง.ช.') {
            // $decArray = array('ร.ง.ช.');
            $rankAray = array('26');
            $result = $this->user_nonribbon_model->get_person_coin_prop($unitID, $rankAray)->result_array();
            $data['persons'] = $this->user_nonribbon_model->rgc_person_filter($result);
        } else if ($ribbon == 'ร.ง.ม.') {
            // $decArray = array('ร.ง.ม.');
            $rankAray = array('27');
            $result = $this->user_nonribbon_model->get_person_coin_prop($unitID, $rankAray)->result_array();
            $data['persons'] = $this->user_nonribbon_model->rgm_person_filter($result);
        } else {
            $data['persons'] = [];
        }

        // var_dump($result);
        $this->load->view('user_view/user_nonribbon/gen_property', $data);
    }

    public function summarize_name()
    {
        $unit = $this->user_nonribbon_model->get_unitname($this->session->unit)->row_array();
		$data['unitname'] 	= $unit['NPRT_NAME'];
		$data['unitID'] 	= $this->myfunction->encode($unit['NPRT_UNIT']);
        $data['sidemenu'] = $this->load->view('user_view/user_menu/list_user_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('user_view/user_menu/navbar_user', $data);
        $this->load->view('user_view/user_nonribbon/user_summarize_name_form', $data);
        $this->load->view('main_view/container_footer');
        $this->load->view('foundation_view/footer');
    }

    public function action_summarize_name()
    {
        $this->load->library('pdf');

        $unitID = $this->myfunction->decode($this->input->post('unitid'));

        $data['year']           = $this->input->post('year');
        $data['unit_name']      = $this->person_data->get_unit_name($unitID);

        $data['thc'] = $this->user_nonribbon_model->get_person_prop($unitID, array('ท.ช.'), '05')->result_array();
        $data['thm'] = $this->user_nonribbon_model->get_person_prop($unitID, array('ท.ม.'), '06')->result_array();
        $data['tc'] = $this->user_nonribbon_model->get_person_prop($unitID, array('ต.ช.'), '07')->result_array();
        $data['tm'] = $this->user_nonribbon_model->get_person_prop($unitID, array('ต.ม.'), '08')->result_array();
        $data['jc'] = $this->user_nonribbon_model->get_person_prop($unitID, array('จ.ช.'), '09')->result_array();

        $rsJm = $this->user_nonribbon_model->get_person_prop($unitID, array('จ.ม.'), array('10', '11'))->result_array();
        $data['jm'] = $this->user_nonribbon_model->jm_person_filter($rsJm);

        $rsBc = $this->user_nonribbon_model->get_person_prop($unitID, array('บ.ช.'), array('11', '21'))->result_array();
        $data['bc'] = $this->user_nonribbon_model->bc_person_filter($rsBc);

        $rsBm = $this->user_nonribbon_model->get_person_prop($unitID, array('บ.ม.'), array('11', '21', '22', '23', '24'))->result_array();
        $data['bm'] = $this->user_nonribbon_model->bm_person_filter($rsBm);

        $rsRtc = $this->user_nonribbon_model->get_person_coin_prop($unitID, array('21', '22', '23', '24'))->result_array();
        $data['rtc'] = $this->user_nonribbon_model->rtc_person_filter($rsRtc);

        $rsRtm = $this->user_nonribbon_model->get_person_coin_prop($unitID, array('25'))->result_array();
        $data['rtm'] = $this->user_nonribbon_model->rtm_person_filter($rsRtm);

        $rsRgc = $this->user_nonribbon_model->get_person_coin_prop($unitID, array('26'))->result_array();
        $data['rgc'] = $this->user_nonribbon_model->rgc_person_filter($rsRgc);

        $rsRgm = $this->user_nonribbon_model->get_person_coin_prop($unitID, array('27'))->result_array();
        $data['rgm'] = $this->user_nonribbon_model->rgm_person_filter($rsRgm);

        // $data['persons_mpc']    = $this->admin_ribbon_prop_model->get_person_prop_mpc($unitID, $data['year'])->result_array();
        // $data['persons_mvm']    = $this->admin_ribbon_prop_model->get_person_prop_mvm($unitID, $data['year'])->result_array();
        // $data['persons_pc']     = $this->admin_ribbon_prop_model->get_person_prop_pc($unitID, $data['year'])->result_array();
        // $data['persons_pm']     = $this->admin_ribbon_prop_model->get_person_prop_pm($unitID, $data['year']);

        // var_dump($data);
        $this->load->view('user_view/user_nonribbon/gen_summarize_name', $data);
    }

    public function nonribbon_amount()
    {
        $unit = $this->user_nonribbon_model->get_unitname($this->session->unit)->row_array();
		$data['unitname'] 	= $unit['NPRT_NAME'];
		$data['unitID'] 	= $this->myfunction->encode($unit['NPRT_UNIT']);
        $data['sidemenu'] = $this->load->view('user_view/user_menu/list_user_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('user_view/user_menu/navbar_user',$data);
        $this->load->view('user_view/user_nonribbon/person_amount_form', $data);
        $this->load->view('main_view/container_footer');
        $this->load->view('foundation_view/footer');
    }

    public function action_person_amount()
    {
        $this->load->library('pdf');

        $unitID = $this->myfunction->decode($this->input->post('unitid'));

        $data['year']           = $this->input->post('year');
        $data['unit_name']      = $this->person_data->get_unit_name($unitID);

        $dtthc = $this->user_nonribbon_model->get_person_prop($unitID, array('ท.ช.'), '05')->result_array();
        $dtthm = $this->user_nonribbon_model->get_person_prop($unitID, array('ท.ม.'), '06')->result_array();
        $dttc = $this->user_nonribbon_model->get_person_prop($unitID, array('ต.ช.'), '07')->result_array();
        $dttm = $this->user_nonribbon_model->get_person_prop($unitID, array('ต.ม.'), '08')->result_array();
        $dtjc = $this->user_nonribbon_model->get_person_prop($unitID, array('จ.ช.'), '09')->result_array();

        $rsJm = $this->user_nonribbon_model->get_person_prop($unitID, array('จ.ม.'), array('10', '11'))->result_array();
        $dtjm = $this->user_nonribbon_model->jm_person_filter($rsJm);

        $rsBc = $this->user_nonribbon_model->get_person_prop($unitID, array('บ.ช.'), array('11', '21'))->result_array();
        $dtbc = $this->user_nonribbon_model->bc_person_filter($rsBc);

        $rsBm = $this->user_nonribbon_model->get_person_prop($unitID, array('บ.ม.'), array('11', '21', '22', '23', '24'))->result_array();
        $dtbm = $this->user_nonribbon_model->bm_person_filter($rsBm);

        $rsRtc = $this->user_nonribbon_model->get_person_coin_prop($unitID, array('21', '22', '23', '24'))->result_array();
        $dtrtc = $this->user_nonribbon_model->rtc_person_filter($rsRtc);

        $rsRtm = $this->user_nonribbon_model->get_person_coin_prop($unitID, array('25'))->result_array();
        $dtrtm = $this->user_nonribbon_model->rtm_person_filter($rsRtm);

        $rsRgc = $this->user_nonribbon_model->get_person_coin_prop($unitID, array('26'))->result_array();
        $dtrgc = $this->user_nonribbon_model->rgc_person_filter($rsRgc);

        $rsRgm = $this->user_nonribbon_model->get_person_coin_prop($unitID, array('27'))->result_array();
        $dtrgm = $this->user_nonribbon_model->rgm_person_filter($rsRgm);

        $data['thc']['men'] = 0;
        $data['thc']['women'] = 0;
        foreach ($dtthc as $r) {
            if($r['BIOG_SEX'] == 0) $data['thc']['men']++;
            if($r['BIOG_SEX'] == 1) $data['thc']['women']++;
        }

        $data['thm']['men'] = 0;
        $data['thm']['women'] = 0;
        foreach ($dtthm as $r) {
            if($r['BIOG_SEX'] == 0) $data['thm']['men']++;
            if($r['BIOG_SEX'] == 1) $data['thm']['women']++;
        }

        $data['tc']['men'] = 0;
        $data['tc']['women'] = 0;
        foreach ($dttc as $r) {
            if($r['BIOG_SEX'] == 0) $data['tc']['men']++;
            if($r['BIOG_SEX'] == 1) $data['tc']['women']++;
        }

        $data['tm']['men'] = 0;
        $data['tm']['women'] = 0;
        foreach ($dttm as $r) {
            if($r['BIOG_SEX'] == 0) $data['tm']['men']++;
            if($r['BIOG_SEX'] == 1) $data['tm']['women']++;
        }
        
        $data['jc']['men'] = 0;
        $data['jc']['women'] = 0;
        foreach ($dtjc as $r) {
            if($r['BIOG_SEX'] == 0) $data['jc']['men']++;
            if($r['BIOG_SEX'] == 1) $data['jc']['women']++;
        }

        $data['jm']['men'] = 0;
        $data['jm']['women'] = 0;
        foreach ($dtjm as $r) {
            if($r['BIOG_SEX'] == 0) $data['jm']['men']++;
            if($r['BIOG_SEX'] == 1) $data['jm']['women']++;
        }

        $data['bc']['men'] = 0;
        $data['bc']['women'] = 0;
        foreach ($dtbc as $r) {
            if($r['BIOG_SEX'] == 0) $data['bc']['men']++;
            if($r['BIOG_SEX'] == 1) $data['bc']['women']++;
        }

        $data['bm']['men'] = 0;
        $data['bm']['women'] = 0;
        foreach ($dtbm as $r) {
            if($r['BIOG_SEX'] == 0) $data['bm']['men']++;
            if($r['BIOG_SEX'] == 1) $data['bm']['women']++;
        }

        $data['rtc']['men'] = 0;
        $data['rtc']['women'] = 0;
        foreach ($dtrtc as $r) {
            if($r['BIOG_SEX'] == 0) $data['rtc']['men']++;
            if($r['BIOG_SEX'] == 1) $data['rtc']['women']++;
        }

        $data['rtm']['men'] = 0;
        $data['rtm']['women'] = 0;
        foreach ($dtrtm as $r) {
            if($r['BIOG_SEX'] == 0) $data['rtm']['men']++;
            if($r['BIOG_SEX'] == 1) $data['rtm']['women']++;
        }

        $data['rgc']['men'] = 0;
        $data['rgc']['women'] = 0;
        foreach ($dtrgc as $r) {
            if($r['BIOG_SEX'] == 0) $data['rgc']['men']++;
            if($r['BIOG_SEX'] == 1) $data['rgc']['women']++;
        }

        $data['rgm']['men'] = 0;
        $data['rgm']['women'] = 0;
        foreach ($dtrgm as $r) {
            if($r['BIOG_SEX'] == 0) $data['rgm']['men']++;
            if($r['BIOG_SEX'] == 1) $data['rgm']['women']++;
        }
        // var_dump($data);
        $this->load->view('user_view/user_nonribbon/gen_person_amount', $data);

    }
}
