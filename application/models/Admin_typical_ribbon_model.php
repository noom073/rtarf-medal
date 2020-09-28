<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_typical_ribbon_model extends CI_Model
{

    protected $oracle;

    function __construct()
    {
        $this->oracle = $this->load->database('oracle', true);
    }

    public function get_person_bdec($unitID)
    {
        $this->oracle->like('substr(BDEC_UNIT, 1, 4)', $unitID);
        $this->oracle->where('BDEC_CSEQ <= 4');
        $this->oracle->order_by('BDEC_RANK');
        $result = $this->oracle->get('PER_BDEC_TAB');
        
        return $result;
    }
}
