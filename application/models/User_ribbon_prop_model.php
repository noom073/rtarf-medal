<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_ribbon_prop_model extends CI_Model
{

    protected $oracle;

    function __construct()
    {
        $this->oracle = $this->load->database('oracle', true);
    }

    public function get_person_prop_mpc($unitID, $year)
    {
        $unitID4    = $this->oracle->escape_like_str(substr($unitID, 0, 4));
        $year       = $this->oracle->escape($year);

        $result = $this->oracle->query("SELECT A.BIOG_NAME, A.BIOG_DMY_WORK, A.BIOG_SALARY, A.BIOG_POSNAME_FULL, 
        A.BIOG_DEC, A.BIOG_DECY, A.BIOG_SEX,
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
        )
        order by A.BIOG_SEX, A.BIOG_RANK, A.BIOG_CDEP");

        return $result;
    }

    public function get_person_prop_mvm($unitID, $year)
    {
        $unitID4    = $this->oracle->escape_like_str(substr($unitID, 0, 4));
        $year       = $this->oracle->escape($year);

        $result = $this->oracle->query("SELECT A.BIOG_NAME, A.BIOG_DMY_WORK, A.BIOG_SALARY, A.BIOG_POSNAME_FULL, 
        A.BIOG_DEC, A.BIOG_DECY, A.BIOG_SEX,
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
        )
        order by A.BIOG_SEX, A.BIOG_RANK, A.BIOG_CDEP");

        return $result;
    }

    public function get_person_prop_pc($unitID, $year)
    {
        $unitID4    = $this->oracle->escape_like_str(substr($unitID, 0, 4));
        $year       = $this->oracle->escape($year);

        $result = $this->oracle->query("SELECT A.BIOG_NAME, A.BIOG_DMY_WORK, A.BIOG_SALARY, A.BIOG_POSNAME_FULL, 
        A.BIOG_DEC, A.BIOG_DECY, A.BIOG_SEX,
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
        )
        order by A.BIOG_SEX, A.BIOG_RANK, A.BIOG_CDEP");
        return $result;
    }

    public function get_person_prop_pm($unitID, $year)
    {
        $unitID4    = $this->oracle->escape_like_str(substr($unitID, 0, 4));
        $escYear    = $this->oracle->escape($year);

        $result = $this->oracle->query("SELECT A.BIOG_ID, A.BIOG_NAME, A.BIOG_DMY_WORK, A.BIOG_SALARY, A.BIOG_POSNAME_FULL, 
        A.BIOG_SCLASS, A.BIOG_RANK, A.BIOG_SLEVEL, A.BIOG_CPOS, A.BIOG_SEX,
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
        )
        order by A.BIOG_SEX, A.BIOG_RANK, A.BIOG_CDEP");

        $persons = $result->result_array();
        $data = array();
        $specialCpos = array(
            '01165', '01107', '01109', '01092', '01093', '01131',
            '01117', '01164', '01119', '01123', '05010'
        );

        foreach ($persons as $r) {
            $cpos5 = substr($r['BIOG_CPOS'], 0, 5);
            $fcol5 = $this->person_data->check_col5_5($r['BIOG_ID']);
            // var_dump($r);

            if (
                ($r['BIOG_RANK'] == '04' && $r['BIOG_DEC'] == 'ท.ช.' && ($year - $r['BIOG_DECY']) >= 3)

                || ($r['BIOG_RANK'] == '04' && $r['BIOG_DEC'] == 'ท.ช.' && $r['RETIRE60'] == $year)

                || ($r['BIOG_RANK'] == '05' && $r['BIOG_SLEVEL'] == 'น.5' && $r['BIOG_SCLASS'] >= '20'
                    && in_array($cpos5, $specialCpos) && $r['BIOG_DEC'] == 'ท.ช.'
                    && ($r['RETIRE60'] == $year || $r['RETIRE60'] == $year + 1)) //  พ.อ.(พ) เกษียณอายุ

                || ($r['BIOG_RANK'] == '05' && $r['BIOG_SLEVEL'] == 'น.5' && $r['BIOG_SCLASS'] >= '05.0'
                    && in_array($cpos5, $specialCpos) && $r['BIOG_DEC'] == 'ท.ช.'
                    && ($year - $r['BIOG_DECY']) >= 3) // พ.อ.(พ) ที่ดำรงตำแหน่งตรงตามคุณสมบัติ

                || ($r['BIOG_RANK'] == '05' && $r['BIOG_SLEVEL'] == 'น.5' && $r['BIOG_SCLASS'] >= '05.0'
                    && $r['BIOG_DEC'] == 'ท.ช.' && $fcol5 == 1
                    && ($year - $r['BIOG_DECY']) >= 3) // พ.อ.(พ) รับเงินเดือน น.5/5.0   ไม่น้อยกว่า 5 ปี   และ ได้รับ  ท.ช.  >=3 ปี  (ตามระเบียบของคมช.) 
            ) {
                array_push($data, $r);
            }
        }

        return $data;
    }

    public function get_unitname($unitID4)
    {
        $this->oracle->select('NPRT_NAME, NPRT_ACM, NPRT_UNIT');
        $this->oracle->where('NPRT_UNIT', $unitID4.'000000');
        $result = $this->oracle->get('PER_NPRT_TAB');
        // echo $this->oracle->last_query();
        return $result;
    }
}