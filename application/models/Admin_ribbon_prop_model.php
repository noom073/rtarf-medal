<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_ribbon_prop_model extends CI_Model
{

    protected $oracle;

    function __construct()
    {
        $this->oracle = $this->load->database('oracle', true);
    }

    public function get_person_prop_mpc($unitID, $year)
    {
        $unitID4 = substr($unitID, 0, 4);

        $result = $this->oracle->query("SELECT A.BIOG_NAME, A.BIOG_DMY_WORK, A.BIOG_SALARY, A.BIOG_POSNAME_FULL, 
        A.BIOG_DEC, A.BIOG_DECY,
        B.CRAK_NAME_FULL
        FROM PER_BIOG_VIEW A
        INNER JOIN PER_CRAK_TAB B 
            ON A.BIOG_RANK = B.CRAK_CODE 
            AND A.BIOG_CDEP = B.CRAK_CDEP_CODE 
        WHERE A.BIOG_UNIT LIKE '$unitID4%'
        AND 
        (
            A.BIOG_RANK IN ('01', '02')
            AND A.BIOG_DEC = 'ม.ว.ม.'
            AND $year - A.BIOG_DECY >= 3	
            OR 
            (
                A.BIOG_RANK = '02'
                AND A.BIOG_DEC = 'ม.ว.ม.' 
                AND retire60(A.BIOG_DMY_BORN) = $year
            )
            OR 
            (
                A.BIOG_RANK = '03'
                AND A.BIOG_DEC = 'ม.ว.ม.' 
                AND $year - A.BIOG_DECY >= 5
            )
        )");

        return $result;
    }

    public function get_person_prop_mvm($unitID, $year)
    {
        $unitID4 = substr($unitID, 0, 4);

        $result = $this->oracle->query("SELECT A.BIOG_NAME, A.BIOG_DMY_WORK, A.BIOG_SALARY, A.BIOG_POSNAME_FULL, 
        A.BIOG_DEC, A.BIOG_DECY,
        B.CRAK_NAME_FULL
        FROM PER_BIOG_VIEW A
        INNER JOIN PER_CRAK_TAB B 
            ON A.BIOG_RANK = B.CRAK_CODE 
            AND A.BIOG_CDEP = B.CRAK_CDEP_CODE 
        WHERE A.BIOG_UNIT LIKE '$unitID4%'
        AND 
        (
            A.BIOG_RANK IN ('01', '02')
            AND A.BIOG_DEC = 'ป.ช.'
            AND $year - A.BIOG_DECY >= 3	
            OR 
            (
                A.BIOG_RANK = '02'
                AND A.BIOG_DEC = 'ป.ช.' 
                AND retire60(A.BIOG_DMY_BORN) = $year
            )
            OR 
            (
                A.BIOG_RANK = '03'
                AND A.BIOG_DEC = 'ป.ช.' 
                AND $year - A.BIOG_DECY >= 3
            )
            OR 
            (
                A.BIOG_RANK = '03'
                AND A.BIOG_DEC = 'ป.ช.' 
                AND retire60(A.BIOG_DMY_BORN) = $year
            )
            OR 
            (
                A.BIOG_RANK = '04'
                AND A.BIOG_DEC = 'ป.ช.' 
                AND $year - A.BIOG_DECY >= 5
            )
        )");

        return $result;
    }

    public function get_person_prop_pc($unitID, $year)
    {
        $unitID4 = substr($unitID, 0, 4);

        $result = $this->oracle->query("SELECT A.BIOG_NAME, A.BIOG_DMY_WORK, A.BIOG_SALARY, A.BIOG_POSNAME_FULL, 
        A.BIOG_DEC, A.BIOG_DECY,
        B.CRAK_NAME_FULL
        FROM PER_BIOG_VIEW A
        INNER JOIN PER_CRAK_TAB B 
            ON A.BIOG_RANK = B.CRAK_CODE 
            AND A.BIOG_CDEP = B.CRAK_CDEP_CODE 
        WHERE A.BIOG_UNIT LIKE '$unitID4%'
        AND 
        (
            A.BIOG_RANK IN ('01', '02')
            AND A.BIOG_DEC = 'ป.ม.'
            AND $year - A.BIOG_DECY >= 3	
            OR 
            (
                A.BIOG_RANK = '02'
                AND A.BIOG_DEC = 'ป.ม.' 
                AND retire60(A.BIOG_DMY_BORN) = $year
            )
            OR 
            (
                A.BIOG_RANK = '03'
                AND A.BIOG_DEC = 'ป.ม.' 
                AND $year - A.BIOG_DECY >= 3
            )
            OR 
            (
                A.BIOG_RANK = '03'
                AND A.BIOG_DEC = 'ป.ม.' 
                AND retire60(A.BIOG_DMY_BORN) = $year
            )
            OR 
            (
                A.BIOG_RANK = '04'
                AND A.BIOG_DEC = 'ป.ม.' 
                AND $year - A.BIOG_DECY >= 3
            )
            OR 
            (
                A.BIOG_RANK = '04'
                AND A.BIOG_DEC = 'ป.ม.' 
                AND retire60(A.BIOG_DMY_BORN) = $year
            )
        )");

        return $result;
    }

    public function get_person_prop_pm($unitID, $year)
    {
        $unitID4 = substr($unitID, 0, 4);

        $result = $this->oracle->query("SELECT A.BIOG_ID, A.BIOG_NAME, A.BIOG_DMY_WORK, A.BIOG_SALARY, A.BIOG_POSNAME_FULL, 
        A.BIOG_SCLASS, A.BIOG_RANK, A.BIOG_SLEVEL, A.BIOG_CPOS,
        A.BIOG_DEC, A.BIOG_DECY, retire60(A.BIOG_DMY_BORN) as RETIRE60,
        B.CRAK_NAME_FULL
        FROM PER_BIOG_VIEW A
        INNER JOIN PER_CRAK_TAB B 
            ON A.BIOG_RANK = B.CRAK_CODE 
            AND A.BIOG_CDEP = B.CRAK_CDEP_CODE 
        WHERE A.BIOG_UNIT LIKE '$unitID4%'
        AND 
        (
            A.BIOG_RANK = '04'
            AND A.BIOG_DEC = 'ท.ช.'   
            OR 
            (
                A.BIOG_RANK = '04'
                AND A.BIOG_DEC = 'ท.ช.' 
            )
            OR 
            (
                A.BIOG_RANK = '05'
                AND A.BIOG_SLEVEL = 'น.5'
                AND A.BIOG_SCLASS >= '05.0'
                AND A.BIOG_DEC = 'ท.ช.'
            )
        )");

        return $result;
    }
}
