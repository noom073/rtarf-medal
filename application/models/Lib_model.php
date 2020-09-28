<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_model extends CI_Model {

    var $oracle;

    function __construct() {
        parent ::__construct();
		$this->oracle = $this->load->database('oracle', true);
    }	

	public function to_army_rank($rankID) {
        $this->oracle->select("CRAK_NAME_ACM, CRAK_NAME_ACM1" );
        $this->oracle->where("CRAK_CDEP_CODE", 1);
        $this->oracle->where("CRAK_CODE", $rankID);
        $result = $this->oracle->get('PER_CRAK_TAB');

        return $result;
    }
    
    public function retire60($dmy_born)
    {
        // $result = $this->oracle->query("SELECT retire60('{$dmy_born}') as YEAR_RETIRE FROM dual");
        // return $result;
        $d = substr($dmy_born, 0,2);
        $m = substr($dmy_born, 2,2);
        $y = substr($dmy_born, 4,4);

        if($m >= 10) {
            $retireYear = $y + 61;
        } else {
            $retireYear = $y + 60;
        }

        return $retireYear;
    }

    public function get_formula_col5_5($biog_id)
    {
        $this->oracle->select("ADD_MONTHS(to_date(to_char(MIN(to_number(to_char(to_number(substr(SALA_DMY,5))-543)
            ||substr(SALA_DMY,3,2)
            ||substr(SALA_DMY,1,2)))),'yyyymmdd'),60) DMY");
        $this->oracle->where("SALA_ID", $biog_id);
        $this->oracle->where("SALA_LEVEL >= 'น.5'");
        $this->oracle->where("SALA_CLASS >= '05.0'");
        $this->oracle->where("to_number(to_number(substr(SALA_DMY, 5))-543 ||substr(SALA_DMY, 3, 2) ||
            substr(SALA_DMY, 1, 2)) > 0");
        $this->oracle->group_by("SALA_ID");
        $result = $this->oracle->get("PER_SALA_TAB");

        return $result;
    }

    public function get_all_rank()
    {
        $this->oracle->select('CRAK_CODE, CRAK_NAME_ACM, CRAK_CDEP_CODE');
        $result = $this->oracle->get('PER_CRAK_TAB');

        return $result;
    }

    public function get_cdec_year2($id, $array)
    {
        $this->oracle->select('CDEC_DMYGET');
        $this->oracle->where('CDEC_ID', $id);
        $this->oracle->where_in('CDEC_COIN', $array);

        $result = $this->oracle->get('PER_CDEC_TAB');
        return $result;
    }

    public function get_unit_name($unitID)
    {
        $this->oracle->select("NPRT_ACM, NPRT_NAME");
        $this->oracle->where("NPRT_UNIT", $unitID);
        $result = $this->oracle->get('PER_NPRT_TAB');
        // echo $this->oracle->last_query();

        return $result;
    }

    public function get_person_in_bdec($id, $medal)
    {
        $this->oracle->where('BDEC_ID');
        $this->oracle->where('BDEC_COIN');
        $query = $this->oracle->get('PER_BDEC_TAB');

        return $query;
    }

    public function update_medal_bdec($biogID, $medal, $nextMedal, $cseq)
    {
        $this->oracle->set('BDEC_COIN', $nextMedal);
        $this->oracle->set('BDEC_CSEQ', $cseq);

        $this->oracle->where('BDEC_ID', $biogID);
        $this->oracle->where('BDEC_COIN', $medal);
        $result = $this->oracle->update('PER_BDEC_TAB');
        // echo $this->oracle->last_query();
        return $result;
    }
}
