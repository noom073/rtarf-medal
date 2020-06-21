<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    var $oracle;

    function __construct() {
        parent ::__construct();
		$this->oracle = $this->load->database('oracle', true);
    }


	public function get_unit() {
        $this->oracle->select("NPRT_UNIT, NPRT_ACM" );
        $this->oracle->where("NPRT_UNIT = SUBSTR(NPRT_UNIT, 1,4)|| '000000'" );
        $this->oracle->not_like("NPRT_UNIT", 6000000000);
        $this->oracle->order_by("NPRT_UNIT");
        $result = $this->oracle->get('PER_NPRT_TAB');
        // echo $this->oracle->last_query();

        return $result;
	}
}
