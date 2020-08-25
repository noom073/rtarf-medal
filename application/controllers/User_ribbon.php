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
        $data['unitname']     = $unit['NPRT_NAME'];
        $data['unitID']     = $this->myfunction->encode($unit['NPRT_UNIT']);
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

        $unitID     = $this->myfunction->decode($this->input->post('unitid'));
        $ribbon     = $this->input->post('ribbon_type');
        $condition  = $this->input->post('condition');

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

        if ($condition == 'retire') {
            $data['persons'] = array_filter($data['persons'], function ($r) use ($data) {
                return $r['RETIRE60'] == $data['year'];
            });
        }
        // var_dump($data);
        $this->load->view('user_view/user_ribbon/gen_ribbon_property', $data);
    }

    public function summarize_name_form()
    {
        $unit = $this->user_ribbon_prop_model->get_unitname($this->session->unit)->row_array();
        $data['unitname']     = $unit['NPRT_NAME'];
        $data['unitID']     = $this->myfunction->encode($unit['NPRT_UNIT']);
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

        $unitID     = $this->myfunction->decode($this->input->post('unitid'));
        $condition  = $this->input->post('condition');

        $data['year']           = $this->input->post('year');
        $data['unit_name']      = $this->person_data->get_unit_name($unitID);
        $data['persons_mpc']    = $this->user_ribbon_prop_model->get_person_prop_mpc($unitID, $data['year'])->result_array();
        $data['persons_mvm']    = $this->user_ribbon_prop_model->get_person_prop_mvm($unitID, $data['year'])->result_array();
        $data['persons_pc']     = $this->user_ribbon_prop_model->get_person_prop_pc($unitID, $data['year'])->result_array();
        $data['persons_pm']     = $this->user_ribbon_prop_model->get_person_prop_pm($unitID, $data['year']);

        if ($condition == 'retire') {
            $data['persons_mpc'] = array_filter($data['persons_mpc'], function ($r) use ($data) {
                return $r['RETIRE60'] == $data['year'];
            });

            $data['persons_mvm'] = array_filter($data['persons_mvm'], function ($r) use ($data) {
                return $r['RETIRE60'] == $data['year'];
            });

            $data['persons_pc'] = array_filter($data['persons_pc'], function ($r) use ($data) {
                return $r['RETIRE60'] == $data['year'];
            });

            $data['persons_pm'] = array_filter($data['persons_pm'], function ($r) use ($data) {
                return $r['RETIRE60'] == $data['year'];
            });
        }

        // var_dump($data);
        // echo json_encode($data);
        $this->load->view('user_view/user_ribbon/gen_ribbon_summarize_name', $data);
    }

    public function ribbon_amount()
    {
        $unit = $this->user_ribbon_prop_model->get_unitname($this->session->unit)->row_array();
        $data['unitname']     = $unit['NPRT_NAME'];
        $data['unitID']     = $this->myfunction->encode($unit['NPRT_UNIT']);
        $data['sidemenu'] = $this->load->view('user_view/user_menu/list_user_menu', null, true);
        $this->load->view('foundation_view/header');
        $this->load->view('user_view/user_menu/navbar_user', $data);
        $this->load->view('user_view/user_ribbon/user_ribbon_amount_form', $data);
        $this->load->view('main_view/container_footer');
        $this->load->view('foundation_view/footer');
    }

    public function action_get_ribbon_amount()
    {
        $this->load->library('pdf');

        $unitID     = $this->myfunction->decode($this->input->post('unitid'));
        $condition  = $this->input->post('condition');

        $data['year']           = $this->input->post('year');
        $data['unit_name']      = $this->person_data->get_unit_name($unitID);
        $data['persons_mpc']    = $this->user_ribbon_prop_model->get_person_prop_mpc($unitID, $data['year'])->result_array();
        $data['persons_mvm']    = $this->user_ribbon_prop_model->get_person_prop_mvm($unitID, $data['year'])->result_array();
        $data['persons_pc']     = $this->user_ribbon_prop_model->get_person_prop_pc($unitID, $data['year'])->result_array();
        $data['persons_pm']     = $this->user_ribbon_prop_model->get_person_prop_pm($unitID, $data['year']);

        $data['mpc']['men']     = count(array_filter($data['persons_mpc'], function ($r) {
            return $r['BIOG_SEX'] == 0;
        }));
        $data['mpc']['women']   = count(array_filter($data['persons_mpc'], function ($r) {
            return $r['BIOG_SEX'] == 1;
        }));
        /** ********************************************* */

        $data['mvm']['men']     = count(array_filter($data['persons_mvm'], function ($r) {
            return $r['BIOG_SEX'] == 0;
        }));
        $data['mvm']['women']   = count(array_filter($data['persons_mvm'], function ($r) {
            return $r['BIOG_SEX'] == 1;
        }));
        /** ********************************************* */

        $data['pc']['men']     = count(array_filter($data['persons_pc'], function ($r) {
            return $r['BIOG_SEX'] == 0;
        }));
        $data['pc']['women']   = count(array_filter($data['persons_pc'], function ($r) {
            return $r['BIOG_SEX'] == 1;
        }));
        /** ********************************************* */

        $data['pm']['men']     = count(array_filter($data['persons_pm'], function ($r) {
            return $r['BIOG_SEX'] == 0;
        }));
        $data['pm']['women']   = count(array_filter($data['persons_pm'], function ($r) {
            return $r['BIOG_SEX'] == 1;
        }));
        /** ********************************************* */

        if($condition == 'retire') {
            $data['mpc']['men']     = count(array_filter($data['persons_mpc'], function ($r) use($data) {
                return $r['BIOG_SEX'] == 0 && $r['RETIRE60'] == $data['year'];
            }));
            $data['mpc']['women']   = count(array_filter($data['persons_mpc'], function ($r) use($data) {
                return $r['BIOG_SEX'] == 1 && $r['RETIRE60'] == $data['year'];
            }));
            /** ********************************************* */
    
            $data['mvm']['men']     = count(array_filter($data['persons_mvm'], function ($r) use($data) {
                return $r['BIOG_SEX'] == 0 && $r['RETIRE60'] == $data['year'];
            }));
            $data['mvm']['women']   = count(array_filter($data['persons_mvm'], function ($r) use($data) {
                return $r['BIOG_SEX'] == 1 && $r['RETIRE60'] == $data['year'];
            }));
            /** ********************************************* */
    
            $data['pc']['men']     = count(array_filter($data['persons_pc'], function ($r) use($data) {
                return $r['BIOG_SEX'] == 0 && $r['RETIRE60'] == $data['year'];
            }));
            $data['pc']['women']   = count(array_filter($data['persons_pc'], function ($r) use($data) {
                return $r['BIOG_SEX'] == 1 && $r['RETIRE60'] == $data['year'];
            }));
            /** ********************************************* */
    
            $data['pm']['men']     = count(array_filter($data['persons_pm'], function ($r) use($data) {
                return $r['BIOG_SEX'] == 0 && $r['RETIRE60'] == $data['year'];
            }));
            $data['pm']['women']   = count(array_filter($data['persons_pm'], function ($r) use($data) {
                return $r['BIOG_SEX'] == 1 && $r['RETIRE60'] == $data['year'];
            }));
            /** ********************************************* */
        }

        // var_dump($data);
        $this->load->view('user_view/user_ribbon/gen_ribbon_amount', $data);
    }
}
