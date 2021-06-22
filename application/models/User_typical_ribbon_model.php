<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_typical_ribbon_model extends CI_Model
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
        $this->oracle->order_by('BDEC_CSEQ, BDEC_RANK');
        $result = $this->oracle->get('PER_BDEC_TAB');

        return $result;
    }

    public function delete_bdec_person($id)
    {
        $this->oracle->where('BDEC_ID', $id);
        $query = $this->oracle->delete('PER_BDEC_TAB');

        return $query;
    }

    public function get_person_prop_by_medal($unitID, $array)
    {
        $unitID4    = $this->oracle->escape_like_str(substr($unitID, 0, 4));
        $year       = (int) $array['year'];

        if ($array['condition'] == 'retire') {
            $retireCondition = "AND RETIRE60(B.BIOG_DMY_BORN ) = {$year}";
        } else {
            $retireCondition = "AND RETIRE60(B.BIOG_DMY_BORN ) > {$year}";
        }

        $result = $this->oracle->query("SELECT A.BDEC_NAME, A.BDEC_REM,
            B.BIOG_ID, B.BIOG_NAME, B.BIOG_DMY_WORK,B.BIOG_SALARY, B.BIOG_POSNAME_FULL, B.BIOG_DEC, B.BIOG_CDEP,
            B.BIOG_DECY, B.BIOG_SEX, B.BIOG_SCLASS, B.BIOG_SLEVEL, B.BIOG_DMY_RANK, B.BIOG_RANK, B.BIOG_IDP,
            C.CRAK_NAME_FULL, C.CRAK_NAME_FULL_PRINT
        FROM PER_BDEC_TAB A
        INNER JOIN PER_BIOG_VIEW B
            ON A.BDEC_ID = B.BIOG_ID
        INNER JOIN PER_CRAK_TAB C
            ON B.BIOG_RANK = C.CRAK_CODE 
            AND B.BIOG_CDEP = C.CRAK_CDEP_CODE 
        WHERE A.BDEC_UNIT LIKE '$unitID4%'
        AND A.BDEC_COIN LIKE '{$array['ribbon_acm']}'
        {$retireCondition}
        -- order by B.BIOG_SEX, B.BIOG_RANK, B.BIOG_CDEP
        order by B.BIOG_RANK, B.BIOG_SEX, B.BIOG_CDEP, 
                NLSSORT(SUBSTR(B.BIOG_NAME, INSTR(B.BIOG_NAME, ' ')+1, 
                    LENGTH(B.BIOG_NAME)-INSTR(B.BIOG_NAME, ' ')), 'NLS_SORT = THAI_M'
                )");

        return $result;
    }
}
