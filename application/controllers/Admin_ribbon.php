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
        $data['year']           = $this->input->post('year');
        $data['p1_rank']        = $this->input->post('p1_rank');
        $data['p1_name']        = $this->input->post('p1_name');
        $data['p1_position']    = $this->input->post('p1_position');
        $data['p2_rank']        = $this->input->post('p2_rank');
        $data['p2_name']        = $this->input->post('p2_name');
        $data['p2_position']    = $this->input->post('p2_position');

        if ($ribbon == 'ม.ป.ช.') {
            $data['persons'] = $this->admin_ribbon_prop_model->get_person_prop_mpc($unitID, $data['year'])->result_array();
        } else if ($ribbon == 'ม.ว.ม.') {
            $data['persons'] = $this->admin_ribbon_prop_model->get_person_prop_mvm($unitID, $data['year'])->result_array();
        } else if ($ribbon == 'ป.ช.') {
            $data['persons'] = $this->admin_ribbon_prop_model->get_person_prop_pc($unitID, $data['year'])->result_array();
        } else if ($ribbon == 'ป.ม.') {
            $persons = $this->admin_ribbon_prop_model->get_person_prop_pm($unitID, $data['year'])->result_array();
            $data['persons'] = array();
            $specialCpos = array(
                '01165', '01107', '01109', '01092', '01093', '01131',
                '01117', '01164', '01119', '01123', '05010'
            );

            foreach ($persons as $r) {
                $cpos5 = substr($r['BIOG_CPOS'], 0, 5);
                $fcol5 = $this->person_data->check_col5_5($r['BIOG_ID']);
                // var_dump($r);

                if (
                    ($r['BIOG_RANK'] == '04' && $r['BIOG_DEC'] == 'ท.ช.' && ($data['year'] - $r['BIOG_DECY']) >= 3)

                    || ($r['BIOG_RANK'] == '04' && $r['BIOG_DEC'] == 'ท.ช.' && $r['RETIRE60'] == $data['year'])

                    || ($r['BIOG_RANK'] == '05' && $r['BIOG_SLEVEL'] == 'น.5' && $r['BIOG_SCLASS'] >= '20'
                        && in_array($cpos5, $specialCpos) && $r['BIOG_DEC'] == 'ท.ช.'
                        && ($r['RETIRE60'] == $data['year'] || $r['RETIRE60'] == $data['year'] + 1)) //  พ.อ.(พ) เกษียณอายุ

                    || ($r['BIOG_RANK'] == '05' && $r['BIOG_SLEVEL'] == 'น.5' && $r['BIOG_SCLASS'] >= '05.0'
                        && in_array($cpos5, $specialCpos) && $r['BIOG_DEC'] == 'ท.ช.'
                        && ($data['year'] - $r['BIOG_DECY']) >= 3) // พ.อ.(พ) ที่ดำรงตำแหน่งตรงตามคุณสมบัติ

                    || ($r['BIOG_RANK'] == '05' && $r['BIOG_SLEVEL'] == 'น.5' && $r['BIOG_SCLASS'] >= '05.0'
                        && $r['BIOG_DEC'] == 'ท.ช.' && $fcol5 == 1
                        && ($data['year'] - $r['BIOG_DECY']) >= 3) // พ.อ.(พ) รับเงินเดือน น.5/5.0   ไม่น้อยกว่า 5 ปี   และ ได้รับ  ท.ช.  >=3 ปี  (ตามระเบียบของคมช.) 
                ) {
                    array_push($data['persons'], $r);
                }
            }
        } else {
            $data['persons'] = [];
        }

        // var_dump($data);
        $this->load->view('admin_view/admin_ribbon/gen_ribbon_property', $data);
    }

    public function summarize_name_form()
    {
        $data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('admin_view/admin_menu/navbar_admin');
        $this->load->view('admin_view/admin_ribbon/admin_ribbon_summarize_name_form', $data);
        $this->load->view('main_view/container_footer');
        $this->load->view('foundation_view/footer');
    }

    public function action_summarize_name()
    {
        $this->load->library('pdf');

        $unitID = $this->myfunction->decode($this->input->post('unitid'));

        $data['year']           = $this->input->post('year');
        $data['unit_name']      = $this->person_data->get_unit_name($unitID);
        $data['persons_mpc']    = $this->admin_ribbon_prop_model->get_person_prop_mpc($unitID, $data['year'])->result_array();
        $data['persons_mvm']    = $this->admin_ribbon_prop_model->get_person_prop_mvm($unitID, $data['year'])->result_array();
        $data['persons_pc']     = $this->admin_ribbon_prop_model->get_person_prop_pc($unitID, $data['year'])->result_array();

        $persons_pm     = $this->admin_ribbon_prop_model->get_person_prop_pm($unitID, $data['year'])->result_array();
        $data['persons_pm'] = array();
        $specialCpos = array(
            '01165', '01107', '01109', '01092', '01093', '01131',
            '01117', '01164', '01119', '01123', '05010'
        );

        foreach ($persons_pm as $r) {
            $cpos5 = substr($r['BIOG_CPOS'], 0, 5);
            $fcol5 = $this->person_data->check_col5_5($r['BIOG_ID']);
            // var_dump($r);

            if (
                ($r['BIOG_RANK'] == '04' && $r['BIOG_DEC'] == 'ท.ช.' && ($data['year'] - $r['BIOG_DECY']) >= 3)

                || ($r['BIOG_RANK'] == '04' && $r['BIOG_DEC'] == 'ท.ช.' && $r['RETIRE60'] == $data['year'])

                || ($r['BIOG_RANK'] == '05' && $r['BIOG_SLEVEL'] == 'น.5' && $r['BIOG_SCLASS'] >= '20'
                    && in_array($cpos5, $specialCpos) && $r['BIOG_DEC'] == 'ท.ช.'
                    && ($r['RETIRE60'] == $data['year'] || $r['RETIRE60'] == $data['year'] + 1)) //  พ.อ.(พ) เกษียณอายุ

                || ($r['BIOG_RANK'] == '05' && $r['BIOG_SLEVEL'] == 'น.5' && $r['BIOG_SCLASS'] >= '05.0'
                    && in_array($cpos5, $specialCpos) && $r['BIOG_DEC'] == 'ท.ช.'
                    && ($data['year'] - $r['BIOG_DECY']) >= 3) // พ.อ.(พ) ที่ดำรงตำแหน่งตรงตามคุณสมบัติ

                || ($r['BIOG_RANK'] == '05' && $r['BIOG_SLEVEL'] == 'น.5' && $r['BIOG_SCLASS'] >= '05.0'
                    && $r['BIOG_DEC'] == 'ท.ช.' && $fcol5 == 1
                    && ($data['year'] - $r['BIOG_DECY']) >= 3) // พ.อ.(พ) รับเงินเดือน น.5/5.0   ไม่น้อยกว่า 5 ปี   และ ได้รับ  ท.ช.  >=3 ปี  (ตามระเบียบของคมช.) 
            ) {
                array_push($data['persons_pm'], $r);
            }
        }

        // var_dump($data);
        // echo json_encode($data);
        $this->load->view('admin_view/admin_ribbon/gen_ribbon_summarize_name', $data);
    }

    public function ribbon_amount()
    {
        $data['sidemenu'] = $this->load->view('admin_view/admin_menu/list_admin_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('admin_view/admin_menu/navbar_admin');
        $this->load->view('admin_view/admin_ribbon/admin_ribbon_amount_form', $data);
        $this->load->view('main_view/container_footer');
        $this->load->view('foundation_view/footer');
    }

    public function action_get_ribbon_amount()
    {
        $this->load->library('pdf');

        $unitID = $this->myfunction->decode($this->input->post('unitid'));

        $data['year']           = $this->input->post('year');
        $data['unit_name']      = $this->person_data->get_unit_name($unitID);
        $data['persons_mpc']    = $this->admin_ribbon_prop_model->get_person_prop_mpc($unitID, $data['year'])->result_array();
        $data['persons_mvm']    = $this->admin_ribbon_prop_model->get_person_prop_mvm($unitID, $data['year'])->result_array();
        $data['persons_pc']     = $this->admin_ribbon_prop_model->get_person_prop_pc($unitID, $data['year'])->result_array();

        $persons_pm     = $this->admin_ribbon_prop_model->get_person_prop_pm($unitID, $data['year'])->result_array();
        $data['persons_pm'] = array();
        $specialCpos = array(
            '01165', '01107', '01109', '01092', '01093', '01131',
            '01117', '01164', '01119', '01123', '05010'
        );

        foreach ($persons_pm as $r) {
            $cpos5 = substr($r['BIOG_CPOS'], 0, 5);
            $fcol5 = $this->person_data->check_col5_5($r['BIOG_ID']);
            // var_dump($r);

            if (
                ($r['BIOG_RANK'] == '04' && $r['BIOG_DEC'] == 'ท.ช.' && ($data['year'] - $r['BIOG_DECY']) >= 3)

                || ($r['BIOG_RANK'] == '04' && $r['BIOG_DEC'] == 'ท.ช.' && $r['RETIRE60'] == $data['year'])

                || ($r['BIOG_RANK'] == '05' && $r['BIOG_SLEVEL'] == 'น.5' && $r['BIOG_SCLASS'] >= '20'
                    && in_array($cpos5, $specialCpos) && $r['BIOG_DEC'] == 'ท.ช.'
                    && ($r['RETIRE60'] == $data['year'] || $r['RETIRE60'] == $data['year'] + 1)) //  พ.อ.(พ) เกษียณอายุ

                || ($r['BIOG_RANK'] == '05' && $r['BIOG_SLEVEL'] == 'น.5' && $r['BIOG_SCLASS'] >= '05.0'
                    && in_array($cpos5, $specialCpos) && $r['BIOG_DEC'] == 'ท.ช.'
                    && ($data['year'] - $r['BIOG_DECY']) >= 3) // พ.อ.(พ) ที่ดำรงตำแหน่งตรงตามคุณสมบัติ

                || ($r['BIOG_RANK'] == '05' && $r['BIOG_SLEVEL'] == 'น.5' && $r['BIOG_SCLASS'] >= '05.0'
                    && $r['BIOG_DEC'] == 'ท.ช.' && $fcol5 == 1
                    && ($data['year'] - $r['BIOG_DECY']) >= 3) // พ.อ.(พ) รับเงินเดือน น.5/5.0   ไม่น้อยกว่า 5 ปี   และ ได้รับ  ท.ช.  >=3 ปี  (ตามระเบียบของคมช.) 
            ) {
                array_push($data['persons_pm'], $r);
            }
        }

        $count['mpc']['men'] = 0;
        $count['mpc']['women'] = 0;
        foreach ($data['persons_mpc'] as $r) {
            if($r['BIOG_SEX'] == 0) $count['mpc']['men']++;
            if($r['BIOG_SEX'] == 1) $count['mpc']['women']++;
        }

        $count['mvm']['men'] = 0;
        $count['mvm']['women'] = 0;
        foreach ($data['persons_mvm'] as $r) {
            if($r['BIOG_SEX'] == 0) $count['mvm']['men']++;
            if($r['BIOG_SEX'] == 1) $count['mvm']['women']++;
        }

        $count['pc']['men'] = 0;
        $count['pc']['women'] = 0;
        foreach ($data['persons_pc'] as $r) {
            if($r['BIOG_SEX'] == 0) $count['pc']['men']++;
            if($r['BIOG_SEX'] == 1) $count['pc']['women']++;
        }

        $count['pm']['men'] = 0;
        $count['pm']['women'] = 0;
        foreach ($data['persons_pm'] as $r) {
            if($r['BIOG_SEX'] == 0) $count['pm']['men']++;
            if($r['BIOG_SEX'] == 1) $count['pm']['women']++;
        }

        var_dump($count);
    }
}
