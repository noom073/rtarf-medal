<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_nonribbon_model extends CI_Model
{

    private $oracle;
    function __construct()
    {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', true);
    }

    function test($data)
    {
        $result = $this->oracle->escape_like_str($data);
        return $result;
    }

    public function get_person_tc($unit)
    {
        $unitID4    = $this->oracle->escape(substr($unit, 0, 4));

        $result = $this->oracle->query("SELECT A.BIOG_NAME, A.BIOG_DMY_WORK, A.BIOG_SALARY, A.BIOG_POSNAME_FULL, 
        A.BIOG_DEC, A.BIOG_DECY, A.BIOG_SEX,
        B.CRAK_NAME_FULL
        FROM PER_BIOG_VIEW A
        INNER JOIN PER_CRAK_TAB B 
            ON A.BIOG_RANK = B.CRAK_CODE 
            AND A.BIOG_CDEP = B.CRAK_CDEP_CODE
        WHERE SUBSTR(A.BIOG_UNIT, 1, 4) = $unitID4
        AND A.BIOG_DEC NOT IN ('ท.ช.', 'ป.ม.', 'ป.ช.', 'ม.ว.ม.', 'ม.ป.ช.')
        AND (
            A.BIOG_RANK = '06'
            AND A.BIOG_DEC <> 'ท.ม.'
        )");

        return $result;
    }
}
