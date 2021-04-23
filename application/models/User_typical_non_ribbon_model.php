<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_typical_non_ribbon_model extends CI_Model
{

    protected $oracle;

    function __construct()
    {
        $this->oracle = $this->load->database('oracle', true);
        $this->load->library('set_env');
        $this->systemStatus = $this->set_env->get_system_status();
    }

    public function get_person_bdec($unitID)
    {
        $this->oracle->where('BDEC_CSEQ > 4');
        $this->oracle->like('substr(BDEC_UNIT, 1, 4)', $unitID, 'none');
        $this->oracle->order_by('BDEC_RANK');
        $result = $this->oracle->get('PER_BDEC_TAB');
        return $result;
    }

    public function delete_bdec_person($id)
    {
        $this->oracle->where('BDEC_ID', $id);
        $query = $this->oracle->delete('PER_BDEC_TAB');

        return $query;
    }

    // public function get_person_prop_by_medal($unitID, $array)
    // {
    //     if ($this->systemStatus == '1') $biogTable = 'PER_BIOG_VIEW';
    //     else $biogTable = 'PER_BIOG_BACK_DEC_TAB';

    //     $unitID4    = $this->oracle->escape_like_str(substr($unitID, 0, 4));
    //     $year       = (int) $array['year'];

    //     if ($array['condition'] == 'retire') $retireCondition = "AND RETIRE60(B.BIOG_DMY_BORN) = {$year}";
    //     else $retireCondition = '';

    //     $sql = "SELECT A.BDEC_NAME,B.BIOG_NAME, B.BIOG_DMY_WORK,
    //         B.BIOG_SALARY, B.BIOG_POSNAME_FULL, B.BIOG_DEC, B.BIOG_DECY, B.BIOG_SEX, B.BIOG_SLEVEL, B.BIOG_SCLASS,
    //         C.CRAK_NAME_FULL
    //         FROM PER_BDEC_TAB A
    //         INNER JOIN {$biogTable} B
    //             ON A.BDEC_ID = B.BIOG_ID
    //         INNER JOIN PER_CRAK_TAB C
    //             ON B.BIOG_RANK = C.CRAK_CODE 
    //             AND B.BIOG_CDEP = C.CRAK_CDEP_CODE 
    //         WHERE A.BDEC_UNIT LIKE '$unitID4%'
    //         AND A.BDEC_COIN LIKE '{$array['ribbon_acm']}'
    //         {$retireCondition}
    //         order by B.BIOG_SEX, B.BIOG_RANK, B.BIOG_CDEP";

    //     $result = $this->oracle->query($sql);

    //     return $result;
    // }

    // public function get_person_prop_by_medal_biog_back($unitID, $array)
    // {
    //     if ($this->systemStatus == '1') $biogTable = 'PER_BIOG_VIEW';
    //     else $biogTable = 'PER_BIOG_BACK_DEC_TAB';

    //     $unitID4    = $this->oracle->escape_like_str(substr($unitID, 0, 4));
    //     $year       = (int) $array['year'];

    //     if ($array['condition'] == 'retire') $retireCondition = "AND RETIRE60(B.BIOG_DMY_BORN) = {$year}";
    //     else $retireCondition = '';

    //     $sql = "SELECT A.BDEC_NAME,B.BIOG_NAME, B.BIOG_DMY_WORK,
    //         B.BIOG_SALARY, B.BIOG_POSNAME_FULL, B.BIOG_DEC, B.BIOG_DECY, B.BIOG_SEX, B.BIOG_SLEVEL, B.BIOG_SCLASS,
    //         C.CRAK_NAME_FULL
    //         FROM PER_BDEC_TAB A
    //         INNER JOIN {$biogTable} B
    //             ON A.BDEC_ID = B.BIOG_ID
    //         INNER JOIN PER_CRAK_TAB C
    //             ON B.BIOG_RANK = C.CRAK_CODE 
    //             AND B.BIOG_CDEP = C.CRAK_CDEP_CODE 
    //         WHERE A.BDEC_UNIT LIKE '$unitID4%'
    //         AND A.BDEC_COIN LIKE '{$array['ribbon_acm']}'
    //         {$retireCondition}
    //         order by B.BIOG_SEX, B.BIOG_RANK, B.BIOG_CDEP";

    //     $result = $this->oracle->query($sql);

    //     return $result;
    // }

    public function search_person_in_biog_back($array)
    {
        if ($array['type'] == 'id') {
            $this->oracle->where('A.BIOG_ID', $array['text']);
        } else if ($array['type'] == 'name') {
            $this->oracle->like('A.BIOG_NAME', $array['text'], 'both');
        } else if ($array['type'] == 'lastname') {
            $this->oracle->where("A.BIOG_NAME like '%  %{$array['text']}%'");
        }

        $this->oracle->select('A.BIOG_ID, A.BIOG_NAME, A.BIOG_RANK, A.BIOG_UNIT, A.BIOG_DEC, B.BDEC_ID, B.BDEC_COIN');
        $this->oracle->join('PER_BDEC_TAB B', 'A.BIOG_ID = B.BDEC_ID ', 'left');
        $this->oracle->where("SUBSTR(A.BIOG_UNIT, 1,4) = '{$array['unitID4']}'");
        $this->oracle->order_by("A.BIOG_RANK, A.BIOG_CDEP");
        $query = $this->oracle->get('PER_BIOG_BACK_DEC_TAB A');
        return $query;
    }

    public function get_officer_prop($unitID, $medal)
    {
        if ($this->systemStatus == '1') $biogTable = 'PER_BIOG_VIEW';
        else $biogTable = 'PER_BIOG_BACK_DEC_TAB';

        $unitID4    = $this->oracle->escape_like_str(substr($unitID, 0, 4));

        $sql = "SELECT A.BDEC_NAME, A.BDEC_REM,
            B.BIOG_NAME, B.BIOG_DMY_WORK, B.BIOG_SALARY, B.BIOG_POSNAME_FULL, B.BIOG_DEC, 
            B.BIOG_DECY, B.BIOG_SEX, B.BIOG_SLEVEL, B.BIOG_SCLASS,B.BIOG_DMY_RANK, B.BIOG_RANK, B.BIOG_IDP,
            B.BIOG_ID, B.BIOG_CDEP,
            C.CRAK_NAME_FULL, C.CRAK_NAME_FULL_PRINT
            FROM PER_BDEC_TAB A
            INNER JOIN {$biogTable} B
                ON A.BDEC_ID = B.BIOG_ID
            INNER JOIN PER_CRAK_TAB C
                ON B.BIOG_RANK = C.CRAK_CODE 
                AND B.BIOG_CDEP = C.CRAK_CDEP_CODE 
            WHERE SUBSTR(A.BDEC_UNIT, 1, 4) LIKE ?
            AND A.BDEC_COIN LIKE ?
            AND A.BDEC_RANK BETWEEN '05' AND '24'
            AND A.BDEC_CSEQ > 4
            -- order by B.BIOG_SEX, B.BIOG_RANK, B.BIOG_CDEP
            order by B.BIOG_RANK, B.BIOG_SEX, B.BIOG_CDEP, 
                SUBSTR(B.BIOG_NAME, INSTR(B.BIOG_NAME, ' ')+1, 
                LENGTH(B.BIOG_NAME)-INSTR(B.BIOG_NAME, ' '))";
        $result = $this->oracle->query($sql, array($unitID4, $medal));

        return $result;
    }

    public function get_employee_prop($unitID, $medal)
    {
        if ($this->systemStatus == '1') $biogTable = 'PER_BIOG_VIEW';
        else $biogTable = 'PER_BIOG_BACK_DEC_TAB';

        $unitID4    = $this->oracle->escape_like_str(substr($unitID, 0, 4));

        $sql = "SELECT A.BDEC_NAME, A.BDEC_REM,
            B.BIOG_NAME, B.BIOG_DMY_WORK,
            B.BIOG_SALARY, B.BIOG_POSNAME_FULL, B.BIOG_DEC, B.BIOG_DECY, B.BIOG_SEX, B.BIOG_SLEVEL, B.BIOG_SCLASS,
            B.BIOG_DMY_RANK, B.BIOG_RANK, B.BIOG_IDP ,B.BIOG_ID, B.BIOG_CDEP,
            C.CRAK_NAME_FULL, C.CRAK_NAME_FULL_PRINT
            FROM PER_BDEC_TAB A
            INNER JOIN {$biogTable} B
                ON A.BDEC_ID = B.BIOG_ID
            INNER JOIN PER_CRAK_TAB C
                ON B.BIOG_RANK = C.CRAK_CODE 
                AND B.BIOG_CDEP = C.CRAK_CDEP_CODE 
            WHERE SUBSTR(A.BDEC_UNIT, 1, 4) LIKE ?
            AND A.BDEC_COIN LIKE ?
            AND A.BDEC_RANK BETWEEN '50' AND '51'
            AND A.BDEC_CSEQ > 4
            -- order by B.BIOG_SEX, B.BIOG_RANK, B.BIOG_CDEP
            order by B.BIOG_RANK, B.BIOG_SEX, B.BIOG_CDEP, 
                SUBSTR(B.BIOG_NAME, INSTR(B.BIOG_NAME, ' ')+1, 
                LENGTH(B.BIOG_NAME)-INSTR(B.BIOG_NAME, ' '))";
        $result = $this->oracle->query($sql, array($unitID4, $medal));

        return $result;
    }
}
