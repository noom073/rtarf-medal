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

    public function get_person_prop($unit, $decArray, $rankArray)
    {

        $sql = "SELECT A.BIOG_IDP, A.BIOG_NAME, A.BIOG_DMY_WORK, A.BIOG_DMY_RANK, A.BIOG_SALARY, A.BIOG_POSNAME_FULL, A.BIOG_RANK,
            A.BIOG_DEC, A.BIOG_DECY, A.BIOG_SEX, A.BIOG_SLEVEL, A.BIOG_SCLASS,
            B.CRAK_NAME_FULL_PRINT
            FROM PER_BIOG_VIEW A
            INNER JOIN PER_CRAK_TAB B 
                ON A.BIOG_RANK = B.CRAK_CODE 
                AND A.BIOG_CDEP = B.CRAK_CDEP_CODE 
            WHERE SUBSTR(A.BIOG_UNIT, 1,4) LIKE ?
            AND A.BIOG_DEC NOT IN ('ท.ช.', 'ป.ม.', 'ป.ช.', 'ม.ว.ม.', 'ม.ป.ช.')
            AND (
                A.BIOG_RANK IN ?
                AND A.BIOG_DEC NOT IN ?
            )
            ORDER BY A.BIOG_SEX, A.BIOG_RANK, A.BIOG_CDEP";

        $unitID4Esc = substr($unit, 0, 4);
        $result = $this->oracle->query($sql, array($unitID4Esc, $rankArray, $decArray));
        return $result;
    }

    public function get_employee_prop($unit, $decArray)
    {
        $decNotIn = array_merge(array('ท.ช.', 'ป.ม.', 'ป.ช.', 'ม.ว.ม.', 'ม.ป.ช.'), $decArray);
        $sql = "SELECT A.BIOG_IDP, A.BIOG_NAME, A.BIOG_DMY_WORK, A.BIOG_DMY_RANK, A.BIOG_SALARY, A.BIOG_POSNAME_FULL, A.BIOG_RANK,
            A.BIOG_DEC, A.BIOG_DECY, A.BIOG_SEX, A.BIOG_SLEVEL, A.BIOG_SCLASS,
            B.CRAK_NAME_FULL_PRINT
            FROM PER_BIOG_VIEW A
            INNER JOIN PER_CRAK_TAB B 
                ON A.BIOG_RANK = B.CRAK_CODE 
                AND A.BIOG_CDEP = B.CRAK_CDEP_CODE 
            WHERE SUBSTR(A.BIOG_UNIT, 1,4) LIKE ?
            AND A.BIOG_RANK IN ('50', '51')
            AND A.BIOG_DEC NOT IN ?
            AND substr( A.BIOG_CPOS,1,5)  in ('80169','80170','80171','80172','80179','80178','80177',
 	   	    '80176','80294','80293','80292','80291','80104','80103','80102','80089','80090','80091',
 	   	    '80092','80071','80072','80073','80079','80080','80081','80100','80099','80098','80076',
 	   	    '80077','80257','80256','80268','80267','80274','80275','80410','80409','80252','80251',
 	   	    '80062','80063','80064','80122','80124','80050','80417','80418','80419','80420','80112',
 	   	    '80111','80110','80109','80394','80393','80392','80391','80384','80382','80387','80309',
 	   	    '80310','80312','80313','80424','80421','80507','80472','80471','80470','80469','80217',
 	   	    '80218','80219','80220','80247','80191','80191','80192','80193','80321','80320','80137',
 	   	    '80139','80085','80084','80083','80082','80148')
            ORDER BY A.BIOG_SEX, A.BIOG_RANK, A.BIOG_CDEP";

        $unitID4Esc = substr($unit, 0, 4);
        $result = $this->oracle->query($sql, array($unitID4Esc, $decNotIn));
        return $result;
    }

    public function get_person_coin_prop($unit, $rankArray)
    {

        $sql = "SELECT A.BIOG_IDP, A.BIOG_NAME, A.BIOG_DMY_WORK, A.BIOG_DMY_RANK, A.BIOG_SALARY, A.BIOG_POSNAME_FULL, A.BIOG_RANK,
            A.BIOG_DEC, A.BIOG_DECY, A.BIOG_SEX, A.BIOG_SLEVEL, A.BIOG_SCLASS,
            B.CRAK_NAME_FULL_PRINT
            FROM PER_BIOG_VIEW A
            INNER JOIN PER_CRAK_TAB B 
                ON A.BIOG_RANK = B.CRAK_CODE 
                AND A.BIOG_CDEP = B.CRAK_CDEP_CODE 
            WHERE SUBSTR(A.BIOG_UNIT, 1,4) LIKE ?
            AND A.BIOG_DEC IS NULL
            AND A.BIOG_RANK IN ?
            ORDER BY A.BIOG_SEX, A.BIOG_RANK, A.BIOG_CDEP";

        $unitID4Esc = substr($unit, 0, 4);

        $result = $this->oracle->query($sql, array($unitID4Esc, $rankArray));

        return $result;
    }

    public function jc_person_filter($personsArray, $year)
    {
        $persons = array_filter($personsArray, function ($r) use ($year) {
            $decPeriod  = $year - $r['BIOG_DECY'];
            $workPeriod = $year - $r['BIOG_DECY'];
            $dWorkStart = substr($r['BIOG_DMY_WORK'], 0, 2);
            $mWorkStart = substr($r['BIOG_DMY_WORK'], 2, 2);
            if ($r['BIOG_RANK'] == '09') {
                $flag = ($r['BIOG_DEC'] != 'จ.ช.' and $workPeriod >= 5) ? true : false;
            } elseif (in_array($r['BIOG_RANK'], array('50', '51'))) {
                $flag = ($r['BIOG_SALARY'] >= '12530' and $r['BIOG_DEC'] == 'จ.ม.'
                    and $decPeriod >= 5 and ($dWorkStart < '28' and $mWorkStart <= '05')) ? true : false;
            } else {
                $flag = false;
            }
            return $flag;
        });
        return array_merge($persons);
    }

    public function jm_person_filter($personsArray, $year)
    {
        $persons = array_filter($personsArray, function ($r) use ($year) {
            $decPeriod  = $year - $r['BIOG_DECY'];
            $workPeriod = $year - $r['BIOG_DECY'];
            $dWorkStart = substr($r['BIOG_DMY_WORK'], 0, 2);
            $mWorkStart = substr($r['BIOG_DMY_WORK'], 2, 2);
            if ($r['BIOG_RANK'] == '10') {
                $flag = ($workPeriod >= 5) ? true : false;
            } elseif ($r['BIOG_RANK'] == '11' || $r['BIOG_RANK'] == '21') {
                $flag = ($r['BIOG_DEC'] == 'บ.ช.' && $decPeriod >= 5) ? true : false;
            } elseif (in_array($r['BIOG_RANK'], array('50', '51'))) {
                $flag = ($r['BIOG_SALARY'] >= '12530' and $r['BIOG_DEC'] == 'บ.ช.'
                    and $decPeriod >= 5 and ($dWorkStart < '28' and $mWorkStart <= '05')) ? true : false;
            } else {
                $flag = false;
            }
            return $flag;
        });
        return array_merge($persons);
    }

    public function bc_person_filter($personsArray, $year)
    {
        $persons = array_filter($personsArray, function ($r) use ($year) {
            $decPeriod = $year - $r['BIOG_DECY'];
            $dWorkStart = substr($r['BIOG_DMY_WORK'], 0, 2);
            $mWorkStart = substr($r['BIOG_DMY_WORK'], 2, 2);
            if (($r['BIOG_RANK'] == '11' || $r['BIOG_RANK'] == '21')) {
                $flag = ($r['BIOG_DEC'] == 'บ.ม.' && $decPeriod >= 5) ? true : false;
            } elseif (in_array($r['BIOG_RANK'], array('50', '51'))) {
                if ($r['BIOG_SALARY'] >= '12530') {
                    if ($r['BIOG_DEC'] == null or $r['BIOG_DEC'] == '') {
                        $flag = true;
                    } elseif (
                        $r['BIOG_DEC'] == 'บ.ม.' and $decPeriod >= 5
                        and ($dWorkStart < '28' and $mWorkStart <= '05')
                    ) {
                        $flag = true;
                    }
                } elseif ($r['BIOG_SALARY'] >= '6800' and $r['BIOG_SALARY'] <= '12529') {
                    $flag = ($r['BIOG_DEC'] == 'บ.ม.' and $decPeriod >= 5
                        and ($dWorkStart < '28' and $mWorkStart <= '05')) ? true : false;
                } else {
                    $flag = false;
                }
            } else {
                $flag = false;
            }
            return $flag;
        });
        return array_merge($persons);
    }

    public function bm_person_filter($personsArray, $year)
    {
        $persons = array_filter($personsArray, function ($r) use ($year) {
            $decPeriod = $year - $r['BIOG_DECY'];
            $workPeriod = $year - $r['BIOG_DECY'];
            if (in_array($r['BIOG_RANK'], array('11', '21', '22', '23', '24'))) {
                if ($r['BIOG_RANK'] == '11') {
                    $flag = ($workPeriod >= 5) ? true : false;
                } else {
                    $flag = ($r['BIOG_DEC'] == 'ร.ท.ช.' && $decPeriod >= 5) ? true : false;
                }
            } elseif (in_array($r['BIOG_RANK'], array('50', '51'))) {
                $flag = ($r['BIOG_SALARY'] >= '6800' and $r['BIOG_SALARY'] <= '12529'
                    and ($r['BIOG_DEC'] == null or $r['BIOG_DEC'] == '')) ? true : false;
            } else {
                $flag = false;
            }
            return $flag;
        });
        return array_merge($persons);
    }

    public function rtc_person_filter($personsArray, $year)
    {
        $persons = array_filter($personsArray, function ($r) use ($year) {
            $workPeriod = $year - $r['BIOG_DECY'];
            if (in_array($r['BIOG_RANK'], array('21', '22', '23', '24')) && $workPeriod >= 5) {
                $flag = true;
            } else {
                $flag = false;
            }
            return $flag;
        });
        return array_merge($persons);
    }

    // public function rtm_person_filter($personsArray, $year)
    // {
    //     $persons = array_filter($personsArray, function ($r) use ($year) {
    //         $workPeriod = $year - $r['BIOG_DECY'];
    //         if (
    //             in_array($r['BIOG_RANK'], array('25')) &&
    //             $workPeriod >= 5
    //         ) {
    //             $flag = true;
    //         } else {
    //             $flag = false;
    //         }
    //         return $flag;
    //     });
    //     return array_merge($persons);
    // }

    // public function rgc_person_filter($personsArray, $year)
    // {
    //     $persons = array_filter($personsArray, function ($r) use ($year) {
    //         $workPeriod = $year - $r['BIOG_DECY'];
    //         if (
    //             in_array($r['BIOG_RANK'], array('26')) &&
    //             $workPeriod >= 5
    //         ) {
    //             $flag = true;
    //         } else {
    //             $flag = false;
    //         }
    //         return $flag;
    //     });
    //     return array_merge($persons);
    // }

    // public function rgm_person_filter($personsArray, $year)
    // {
    //     $persons = array_filter($personsArray, function ($r) use ($year) {
    //         $workPeriod = $year - $r['BIOG_DECY'];
    //         if (
    //             in_array($r['BIOG_RANK'], array('27')) &&
    //             $workPeriod >= 5
    //         ) {
    //             $flag = true;
    //         } else {
    //             $flag = false;
    //         }
    //         return $flag;
    //     });
    //     return array_merge($persons);
    // }
}
