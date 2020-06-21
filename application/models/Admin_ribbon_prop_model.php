<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_ribbon_prop_model extends CI_Model
{

    protected $oracle;

    function __construct()
    {
        $this->oracle = $this->load->database('oracle', true);
    }

    public function get_person_prop_mpc($unitID)
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
            AND (to_char(sysdate, 'YYYY')+543) - A.BIOG_DECY >= 3	
            OR 
            (
                A.BIOG_RANK = '02'
                AND A.BIOG_DEC = 'ม.ว.ม.' 
                AND retire60(A.BIOG_DMY_BORN) = to_char(sysdate, 'YYYY')+543
            )
            OR 
            (
                A.BIOG_RANK = '03'
                AND A.BIOG_DEC = 'ม.ว.ม.' 
                AND (to_char(sysdate, 'YYYY')+543) - A.BIOG_DECY >= 5
            )
        )");

        return $result;
    }

    public function get_person_prop_mvm($unitID)
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
            AND (to_char(sysdate, 'YYYY')+543) - A.BIOG_DECY >= 3	
            OR 
            (
                A.BIOG_RANK = '02'
                AND A.BIOG_DEC = 'ป.ช.' 
                AND retire60(A.BIOG_DMY_BORN) = to_char(sysdate, 'YYYY')+543
            )
            OR 
            (
                A.BIOG_RANK = '03'
                AND A.BIOG_DEC = 'ป.ช.' 
                AND (to_char(sysdate, 'YYYY')+543) - A.BIOG_DECY >= 3
            )
            OR 
            (
                A.BIOG_RANK = '03'
                AND A.BIOG_DEC = 'ป.ช.' 
                AND retire60(A.BIOG_DMY_BORN) = to_char(sysdate, 'YYYY')+543
            )
            OR 
            (
                A.BIOG_RANK = '04'
                AND A.BIOG_DEC = 'ป.ช.' 
                AND (to_char(sysdate, 'YYYY')+543) - A.BIOG_DECY >= 5
            )
        )");

        return $result;
    }

    public function get_person_prop_pc($unitID)
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
            AND (to_char(sysdate, 'YYYY')+543) - A.BIOG_DECY >= 3	
            OR 
            (
                A.BIOG_RANK = '02'
                AND A.BIOG_DEC = 'ป.ม.' 
                AND retire60(A.BIOG_DMY_BORN) = to_char(sysdate, 'YYYY')+543
            )
            OR 
            (
                A.BIOG_RANK = '03'
                AND A.BIOG_DEC = 'ป.ม.' 
                AND (to_char(sysdate, 'YYYY')+543) - A.BIOG_DECY >= 3
            )
            OR 
            (
                A.BIOG_RANK = '03'
                AND A.BIOG_DEC = 'ป.ม.' 
                AND retire60(A.BIOG_DMY_BORN) = to_char(sysdate, 'YYYY')+543
            )
            OR 
            (
                A.BIOG_RANK = '04'
                AND A.BIOG_DEC = 'ป.ม.' 
                AND (to_char(sysdate, 'YYYY')+543) - A.BIOG_DECY >= 3
            )
            OR 
            (
                A.BIOG_RANK = '04'
                AND A.BIOG_DEC = 'ป.ม.' 
                AND retire60(A.BIOG_DMY_BORN) = to_char(sysdate, 'YYYY')+543
            )
        )");

        return $result;
    }

    public function get_person_prop_pm($unitID)
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
            A.BIOG_RANK = '04'
            AND A.BIOG_DEC = 'ท.ช.' 
            AND (to_char(sysdate, 'YYYY')+543) - A.BIOG_DECY >= 3    
            OR 
            (
                A.BIOG_RANK = '04'
                AND A.BIOG_DEC = 'ท.ช.' 
                AND retire60(A.BIOG_DMY_BORN) = to_char(sysdate, 'YYYY')+543
            )
            OR 
            (
                A.BIOG_RANK = '05'
                AND A.BIOG_SLEVEL = 'น.5'
                AND A.BIOG_SCLASS = '20'
                AND substr(A.BIOG_CPOS,1,5) IN ('01165', '01107', '01109', '01092', '01093', '01131',
                    '01117', '01164', '01119', '01123', '05010')
                AND A.BIOG_DEC = 'ท.ช.'
                AND (
                    retire60(A.BIOG_DMY_BORN) = to_char(sysdate, 'YYYY')+543 
                    OR 
                    retire60(A.BIOG_DMY_BORN) = (to_char(sysdate, 'YYYY')+543)+1
                )
            )
            OR 
            (
                A.BIOG_RANK = '05'
                AND A.BIOG_SLEVEL = 'น.5'
                AND A.BIOG_SCLASS = '5'
                AND substr(A.BIOG_CPOS,1,5) IN ('01165', '01107', '01109', '01092', '01093', '01131',
                    '01117', '01164', '01119', '01123', '05010')
                AND A.BIOG_DEC = 'ท.ช.'
                AND (to_char(sysdate, 'YYYY')+543) - A.BIOG_DECY >= 3    
            )
        )");

        return $result;
    }
}
