<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_nonribbon_filter_model extends CI_Model
{

    private $oracle;

    function __construct()
    {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', true);
    }  

    public function get_unitname($unitID4)
    {
        $this->oracle->select('NPRT_NAME, NPRT_ACM, NPRT_UNIT');
        $this->oracle->where('NPRT_UNIT', $unitID4.'000000');
        $result = $this->oracle->get('PER_NPRT_TAB');
        // echo $this->oracle->last_query();
        return $result;
    }

    private function get_officer_list($unit, $rank, $medal)
    {
        $sql = "SELECT A.BIOG_IDP, A.BIOG_ID, A.BIOG_NAME, A.BIOG_DMY_WORK, A.BIOG_DMY_RANK, A.BIOG_SALARY, A.BIOG_POSNAME_FULL, A.BIOG_RANK,
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
            OR A.BIOG_DEC IS NULL
            ORDER BY A.BIOG_SEX, A.BIOG_RANK, A.BIOG_CDEP";

        $unitID4Esc = substr($unit, 0, 4);
        $result = $this->oracle->query($sql, array($unitID4Esc, $rank, $medal));
        // echo $this->oracle->last_query();
        return $result;
    }

    public function get_rank_for_medal($medal)
    {
        switch ($medal) {
            case 'ท.ช.':
                $rank = array('05');
                break;
            case 'ท.ม.':
                $rank = array('06');
                break;
            case 'ต.ช.':
                $rank = array('07');
                break;
            case 'ต.ม.':
                $rank = array('08');
                break;
            case 'จ.ช.':
                $rank = array('09');
                break;
            case 'จ.ม.':
                $rank = array('10', '11', '21');
                break;
            case 'บ.ช.':
                $rank = array('11', '21');
                break;
            case 'บ.ม.':
                $rank = array('11', '21', '22', '23', '24');
                break;
            case 'ร.ท.ช.':
                $rank = array('21', '22', '23', '24');
                break;
            default:
                $rank = array('05');
                break;
        }
        return $rank;
    }

    public function get_officer_prop($unit, $medal, $year)
    {
        $rank = $this->get_rank_for_medal($medal);
        $getPersons = $this->get_officer_list($unit, $rank, $medal);
        if ($getPersons->num_rows() > 0) {
            $persons = $getPersons->result_array();
            switch ($medal) {
                case 'ท.ช.':
                    $personsProp = $this->get_thc_person_prop($persons, $year);
                    break;
                case 'ท.ม.':
                    $personsProp = $this->get_thm_person_prop($persons, $year);
                    break;
                case 'ต.ช.':
                    $personsProp = $this->get_tc_person_prop($persons, $year);
                    break;
                case 'ต.ม.':
                    $personsProp = $this->get_tm_person_prop($persons, $year);
                    break;
                case 'จ.ช.':
                    $personsProp = $this->get_jc_person_prop($persons, $year);
                    break;
                case 'จ.ม.':
                    $personsProp = $this->get_jm_person_prop($persons, $year);
                    break;
                case 'บ.ช.':
                    $personsProp = $this->get_bc_person_prop($persons, $year);
                    break;
                case 'บ.ม.':
                    $personsProp = $this->get_bm_person_prop($persons, $year);
                    break;
                case 'ร.ท.ช.':
                    $personsProp = $this->get_rtc_person_prop($persons, $year);
                    break;
                default:
                    $personsProp = $this->get_thc_person_prop($persons, $year);
                    break;
            }
        } else {
            $personsProp = [];
        }
        return $personsProp;
    }

    private function get_thc_person_prop($persons, $year)
    {
        $data = array_filter($persons, function ($r) use ($year) {
            $notInArray = array('ท.ช.', 'ป.ม.', '');
            $numberhasDecYear = (int) $year - $r['BIOG_DECY']; // เทียบปีครองเครื่องราชฯ
            $flag = ($r['BIOG_RANK'] == '05'
                and $numberhasDecYear > 1
                and in_array($r['BIOG_DEC'], $notInArray) == false) ? true : false;
            return $flag;
        });
        $persons = array_merge($data);
        return $persons;
    }

    private function get_thm_person_prop($persons, $year)
    {
        $data = array_filter($persons, function ($r) use ($year) {
            $notInArray = array('ท.ม.', '');
            $numberhasDecYear = (int) $year - $r['BIOG_DECY']; // เทียบปีครองเครื่องราชฯ
            $flag = ($r['BIOG_RANK'] == '06'
                and $numberhasDecYear > 1
                and in_array($r['BIOG_DEC'], $notInArray) == false) ? true : false;
            return $flag;
        });
        $persons = array_merge($data);
        return $persons;
    }

    private function get_tc_person_prop($persons, $year)
    {
        $data = array_filter($persons, function ($r) use ($year) {
            $notInArray = array('ต.ช.', '');
            $numberhasDecYear = (int) $year - $r['BIOG_DECY']; // เทียบปีครองเครื่องราชฯ
            $flag = ($r['BIOG_RANK'] == '07'
                and $numberhasDecYear > 1
                and in_array($r['BIOG_DEC'], $notInArray) == false) ? true : false;
            return $flag;
        });
        $persons = array_merge($data);
        return $persons;
    }

    private function get_tm_person_prop($persons, $year)
    {
        $data = array_filter($persons, function ($r) use ($year) {
            $notInArray = array('ต.ม.', '');
            $numberhasDecYear = (int) $year - $r['BIOG_DECY']; // เทียบปีครองเครื่องราชฯ
            $flag = ($r['BIOG_RANK'] == '08'
                and $numberhasDecYear > 1
                and in_array($r['BIOG_DEC'], $notInArray) == false) ? true : false;
            return $flag;
        });
        $persons = array_merge($data);
        return $persons;
    }

    private function get_jc_person_prop($persons, $year)
    {
        $data = array_filter($persons, function ($r) use ($year) {
            $notInArray = array('จ.ช.', '');
            $numberhasDecYear = (int) $year - $r['BIOG_DECY']; // เทียบปีครองเครื่องราชฯ
            $flag = ($r['BIOG_RANK'] == '09'
                and $numberhasDecYear > 1
                and in_array($r['BIOG_DEC'], $notInArray) == false) ? true : false;
            return $flag;
        });
        $persons = array_merge($data);
        return $persons;
    }

    private function get_jm_person_prop($persons, $year)
    {
        $data = array_filter($persons, function ($r) use ($year) {
            if ($r['BIOG_RANK'] == '10') {
                $dateWork = $this->myfunction->convertDateToDateTime($r['BIOG_DMY_WORK']);
                $y = $year - 543;
                $curDate = new DateTime($y . '-05-28');
                $diffWorkYear = (int) $dateWork->diff($curDate)->format('%R%y'); // เทียบปีทำงาน
                $notInArray = array('จ.ม.', 'จ.ช.');
                $numberhasDecYear = (int) $year - $r['BIOG_DECY']; // เทียบปีครองเครื่องราชฯ
                $flag = ($diffWorkYear >= 5
                    and $numberhasDecYear > 1
                    and in_array($r['BIOG_DEC'], $notInArray) == false) ? true : false;
            } elseif ($r['BIOG_RANK'] == '11') {
                $numberhasDecYear = (int) $year - $r['BIOG_DECY']; // เทียบปีครองเครื่องราชฯ
                $flag = ($numberhasDecYear >= 5
                    and $r['BIOG_DEC'] == 'บ.ช.') ? true : false;
            } elseif ($r['BIOG_RANK'] == '21') {
                $getDecDetail = $this->get_cdec_bc_detail($r['BIOG_ID']); // ดึงรายละเอียดเครื่องราชฯ บ.ช.
                if ($getDecDetail->num_rows() > 0) {
                    $cDetail = $getDecDetail->row_array();
                    $dateBc = $this->myfunction->convertDateToDateTime($cDetail['CDEC_DMYGET']);
                    $y = $year - 543;
                    $curDate = new DateTime($y . '-05-28');
                    $diffDecYear = (int) $dateBc->diff($curDate)->format('%R%y'); // เทียบปีครองเครื่องราชฯ บ.ช.
                    $flag = ($diffDecYear >= 5
                        and $r['BIOG_DEC'] == 'บ.ช.') ? true : false;
                } else {
                    $flag = false;
                }
            } else {
                $flag = false;
            }

            return $flag;
        });
        $persons = array_merge($data);
        return $persons;
    }

    private function get_bc_person_prop($persons, $year)
    {
        $data = array_filter($persons, function ($r) use ($year) {
            if ($r['BIOG_RANK'] == '11') {
                $dateRank = $this->myfunction->convertDateToDateTime($r['BIOG_DMY_RANK']);
                $y = $year - 543;
                $curDate = new DateTime($y . '-05-28');
                $diffRankYear = (int) $dateRank->diff($curDate)->format('%R%y'); // เทียบปีครองยศ
                $flag = ($diffRankYear >= 5
                    and $r['BIOG_DEC'] == 'บ.ม.') ? true : false;
            } elseif ($r['BIOG_RANK'] == '21') {
                $getDecDetail = $this->get_cdec_bm_detail($r['BIOG_ID']); // ดึงรายละเอียดเครื่องราชฯ บ.ม.
                if ($getDecDetail->num_rows() > 0) {
                    $cDetail = $getDecDetail->row_array();
                    $dateBm = $this->myfunction->convertDateToDateTime($cDetail['CDEC_DMYGET']);
                    $y = $year - 543;
                    $curDate = new DateTime($y . '-05-28');
                    $diffDecYear = (int) $dateBm->diff($curDate)->format('%R%y'); // เทียบปีครองเครื่องราชฯ บ.ม.
                    $flag = ($diffDecYear >= 5
                        and $r['BIOG_DEC'] == 'บ.ม.') ? true : false;
                } else {
                    $flag = false;
                }
            } else {
                $flag = false;
            }
            return $flag;
        });
        $persons = array_merge($data);
        return $persons;
    }

    private function get_bm_person_prop($persons, $year)
    {
        $data = array_filter($persons, function ($r) use ($year) {
            if ($r['BIOG_RANK'] == '11') {
                $notInArray = array('บ.ม.', 'บ.ช.', 'จ.ม.');
                $flag = (in_array($r['BIOG_DEC'], $notInArray) == false
                    or ($r['BIOG_DEC'] == '' or $r['BIOG_DEC'] == 'ร.ท.ช.')) ? true : false;
            } elseif (in_array($r['BIOG_RANK'], array('21', '22', '23', '24'))) {
                $getDecDetail = $this->get_cdec_rtc_detail($r['BIOG_ID']); // ดึงรายละเอียดเครื่องราชฯ ร.ท.ช.
                if ($getDecDetail->num_rows() > 0) {
                    $cDetail = $getDecDetail->row_array();
                    $dateRtc = $this->myfunction->convertDateToDateTime($cDetail['CDEC_DMYGET']);
                    $y = $year - 543;
                    $curDate = new DateTime($y . '-05-28');
                    $diffDecYear = (int) $dateRtc->diff($curDate)->format('%R%y'); // เทียบปีครองเครื่องราชฯ ร.ท.ช.
                    $notInArray = array('บ.ม.', 'บ.ช.', 'จ.ม.');
                    $flag = ($diffDecYear >= 5
                        and (in_array($r['BIOG_DEC'], $notInArray) == false
                            or $r['BIOG_DEC'] == ''
                            or $r['BIOG_DEC'] == null)) ? true : false;
                } else {
                    $flag = false;
                }
            } else {
                $flag = false;
            }
            return $flag;
        });
        $persons = array_merge($data);
        return $persons;
    }

    private function get_rtc_person_prop($persons, $year)
    {
        $data = array_filter($persons, function ($r) use ($year) {
            if (in_array($r['BIOG_RANK'], array('21', '22', '23', '24'))) {
                $dateWork = $this->myfunction->convertDateToDateTime($r['BIOG_DMY_WORK']);
                $y = $year - 543;
                $curDate = new DateTime($y . '-05-28');
                $diffWorkYear = (int) $dateWork->diff($curDate)->format('%R%y'); // เทียบปีทำงาน
                $notInArray = array('บ.ม.', 'บ.ช.', 'จ.ม.');
                $checkRtc = $this->get_cdec_rtc_detail($r['BIOG_ID'])->num_rows();
                $flag = ($diffWorkYear >= 5
                    and in_array($r['BIOG_DEC'], $notInArray) == false
                    and $checkRtc == 0) ? true : false;
            } else {
                $flag = false;
            }
            return $flag;
        });
        $persons = array_merge($data);
        return $persons;
    }

    private function get_cdec_rtc_detail($biogID)
    {
        $sql = "SELECT CDEC_ID, CDEC_COIN, CDEC_DMYGET
            FROM PER_CDEC_TAB
            WHERE CDEC_COIN IN ('รทช','รทช.','ร.ท.ช','ร.ท.ช.','เหรียญทองช้างเผือก')
            AND CDEC_ID = ?";
        $query = $this->oracle->query($sql, array($biogID));
        return $query;
    }

    private function get_cdec_jm_detail($biogID)
    {
        $sql = "SELECT CDEC_ID, CDEC_COIN, CDEC_DMYGET
            FROM PER_CDEC_TAB
            WHERE CDEC_COIN IN ('จม','จม.','จ.ม.') 
            AND CDEC_ID = ?";
        $query = $this->oracle->query($sql, array($biogID));
        return $query;
    }

    private function get_cdec_bc_detail($biogID)
    {
        $sql = "SELECT CDEC_ID, CDEC_COIN, CDEC_DMYGET
            FROM PER_CDEC_TAB
            WHERE CDEC_COIN IN ('บช','บช.','บ.ช.')
            AND CDEC_ID = ?";
        $query = $this->oracle->query($sql, array($biogID));
        return $query;
    }

    private function get_cdec_bm_detail($biogID)
    {
        $sql = "SELECT CDEC_ID, CDEC_COIN, CDEC_DMYGET
            FROM PER_CDEC_TAB
            WHERE CDEC_COIN IN ('บม','บม.','บ.ม.') 
            AND CDEC_ID = ?";
        $query = $this->oracle->query($sql, array($biogID));
        return $query;
    }

    private function get_employee_list($unit, $decArray)
    {
        $decNotIn = array_merge(array('ท.ช.', 'ป.ม.', 'ป.ช.', 'ม.ว.ม.', 'ม.ป.ช.'), $decArray);
        $sql = "SELECT A.BIOG_IDP, A.BIOG_ID, A.BIOG_NAME, A.BIOG_DMY_WORK, A.BIOG_DMY_RANK, A.BIOG_SALARY, A.BIOG_POSNAME_FULL, A.BIOG_RANK,
            A.BIOG_DEC, A.BIOG_DECY, A.BIOG_SEX, A.BIOG_SLEVEL, A.BIOG_SCLASS,
            B.CRAK_NAME_FULL_PRINT
            FROM PER_BIOG_VIEW A
            INNER JOIN PER_CRAK_TAB B 
                ON A.BIOG_RANK = B.CRAK_CODE 
                AND A.BIOG_CDEP = B.CRAK_CDEP_CODE 
            WHERE SUBSTR(A.BIOG_UNIT, 1,4) LIKE ?
            AND A.BIOG_RANK IN ('50', '51')
            AND A.BIOG_DEC NOT IN ?
            AND substr( A.BIOG_CPOS,1,5) in ('80169','80170','80171','80172','80179','80178','80177',
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

    public function get_employee_prop($unit, $medal, $year)
    {
        $decArray = array($medal);
        $getPersons = $this->get_employee_list($unit, $decArray);
        if ($getPersons->num_rows() > 0) {
            $persons = $getPersons->result_array();
            switch ($medal) {
                case 'ท.ช.':
                    $personsProp = [];
                    break;
                case 'ท.ม.':
                    $personsProp = [];
                    break;
                case 'ต.ช.':
                    $personsProp = [];
                    break;
                case 'ต.ม.':
                    $personsProp = [];
                    break;
                case 'จ.ช.':
                    $personsProp = $this->get_jc_employee_prop($persons, $year);
                    break;
                case 'จ.ม.':
                    $personsProp = $this->get_jm_employee_prop($persons, $year);
                    break;
                case 'บ.ช.':
                    $personsProp = $this->get_bc_employee_prop($persons, $year);
                    break;
                case 'บ.ม.':
                    $personsProp = $this->get_bm_employee_prop($persons, $year);
                    break;
                case 'ร.ท.ช.':
                    $personsProp = [];
                    break;
                default:
                    $personsProp = [];
                    break;
            }
        } else {
            $personsProp = [];
        }
        return $personsProp;
    }

    public function get_jc_employee_prop($persons, $year)
    {
        $data = array_filter($persons, function ($r) use ($year) {
            if (in_array($r['BIOG_RANK'], array('50', '51'))) {
                $dateWork = $this->myfunction->convertDateToDateTime($r['BIOG_DMY_WORK']);
                $y = $year - 543;
                $curDate = new DateTime($y . '-05-28');
                $diffWorkYear = (int) $dateWork->diff($curDate)->format('%R%y'); // เทียบปีทำงาน
                $getJmDetail = $this->get_cdec_jm_detail($r['BIOG_ID']);
                if ($getJmDetail->num_rows() > 0) {
                    $jmDetail = $getJmDetail->row_array();
                    $dateDecJm = $this->myfunction->convertDateToDateTime($jmDetail['CDEC_DMYGET']);
                    $diffDecJmYear = (int) $dateDecJm->diff($curDate)->format('%R%y'); // เทียบปีครอง จ.ม.
                    $flag = ($diffWorkYear >= 8
                        and $r['BIOG_DEC'] == 'จ.ม.'
                        and $diffDecJmYear >= 5
                        and $r['BIOG_SALARY'] >= '12530') ? true : false;
                } else {
                    $flag = false;
                }
            } else {
                $flag = false;
            }
            return $flag;
        });
        $persons = array_merge($data);
        return $persons;
    }

    public function get_jm_employee_prop($persons, $year)
    {
        $data = array_filter($persons, function ($r) use ($year) {
            if (in_array($r['BIOG_RANK'], array('50', '51'))) {
                $dateWork = $this->myfunction->convertDateToDateTime($r['BIOG_DMY_WORK']);
                $y = $year - 543;
                $curDate = new DateTime($y . '-05-28');
                $diffWorkYear = (int) $dateWork->diff($curDate)->format('%R%y'); // เทียบปีทำงาน
                $getBcDetail = $this->get_cdec_bc_detail($r['BIOG_ID']);
                if ($getBcDetail->num_rows() > 0) {
                    $BcDetail = $getBcDetail->row_array();
                    $dateDecBc = $this->myfunction->convertDateToDateTime($BcDetail['CDEC_DMYGET']);
                    $diffDecBcYear = (int) $dateDecBc->diff($curDate)->format('%R%y'); // เทียบปีครอง บ.ช.
                    $flag = ($diffWorkYear >= 8
                        and $r['BIOG_DEC'] == 'บ.ช.'
                        and $diffDecBcYear >= 5
                        and $r['BIOG_SALARY'] >= '12530') ? true : false;
                } else {
                    $flag = false;
                }
            } else {
                $flag = false;
            }
            return $flag;
        });
        $persons = array_merge($data);
        return $persons;
    }

    public function get_bc_employee_prop($persons, $year)
    {
        $data = array_filter($persons, function ($r) use ($year) {
            $dateWork = $this->myfunction->convertDateToDateTime($r['BIOG_DMY_WORK']);
            $y = $year - 543;
            $curDate = new DateTime($y . '-05-28');
            $diffWorkYear = (int) $dateWork->diff($curDate)->format('%R%y'); // เทียบปีทำงาน
            if (in_array($r['BIOG_RANK'], array('50', '51')) and $diffWorkYear >= 8) {
                if ($r['BIOG_SALARY'] >= '12530') {
                    if ($r['BIOG_DEC'] == null) {
                        $flag = true;
                    } elseif ($r['BIOG_DEC'] == 'บ.ม.') {
                        $getBmDetail = $this->get_cdec_bm_detail($r['BIOG_ID']);
                        if ($getBmDetail->num_rows() > 0) {
                            $BmDetail = $getBmDetail->row_array();
                            $dateDecBm = $this->myfunction->convertDateToDateTime($BmDetail['CDEC_DMYGET']);
                            $diffDecBmYear = (int) $dateDecBm->diff($curDate)->format('%R%y'); // เทียบปีครอง บ.ม.
                            $flag = ($diffDecBmYear >= 5) ? true : false;
                        } else {
                            $flag = false;
                        }
                    } else {
                        $flag = false;
                    }
                } elseif ($r['BIOG_SALARY'] >= '6800' and $r['BIOG_SALARY'] <= '12529') {
                    $getBmDetail = $this->get_cdec_bm_detail($r['BIOG_ID']);
                    if ($getBmDetail->num_rows() > 0) {
                        $BmDetail = $getBmDetail->row_array();
                        $dateDecBm = $this->myfunction->convertDateToDateTime($BmDetail['CDEC_DMYGET']);
                        $diffDecBmYear = (int) $dateDecBm->diff($curDate)->format('%R%y'); // เทียบปีครอง บ.ม.
                        $flag = ($diffDecBmYear >= 5) ? true : false;
                    }
                } else {
                    $flag = false;
                }
            } else {
                $flag = false;
            }
            return $flag;
        });
        $persons = array_merge($data);
        return $persons;
    }

    public function get_bm_employee_prop($persons, $year)
    {
        $data = array_filter($persons, function ($r) use ($year) {
            $dateWork = $this->myfunction->convertDateToDateTime($r['BIOG_DMY_WORK']);
            $y = $year - 543;
            $curDate = new DateTime($y . '-05-28');
            $diffWorkYear = (int) $dateWork->diff($curDate)->format('%R%y'); // เทียบปีทำงาน
            if (in_array($r['BIOG_RANK'], array('50', '51')) and $diffWorkYear >= 8) {
                $flag = ($r['BIOG_DEC'] == null
                    and ($r['BIOG_SALARY'] >= '6800' and $r['BIOG_SALARY'] <= '12529')) ? true : false;
            } else {
                $flag = false;
            }
            return $flag;
        });
        $persons = array_merge($data);
        return $persons;
    }

    private function check_before_insert_bdec($biogID, $nextMedal)
    {
        $this->oracle->where('BDEC_ID', $biogID);
        $this->oracle->where('BDEC_COIN', $nextMedal);
        $query = $this->oracle->get('PER_BDEC_TAB');

        return $query;
    }

    private function insert_bdec($row, $nextMedal, $round, $bdecSeq)
    {
        $this->oracle->set('BDEC_ROUND', $round);
        $this->oracle->set('BDEC_ID', $row['BIOG_ID']);
        $this->oracle->set('BDEC_NAME', $row['BIOG_NAME']);
        $this->oracle->set('BDEC_RANK', $row['BIOG_RANK']);
        $this->oracle->set('BDEC_UNIT', $row['BIOG_UNIT']);
        $this->oracle->set('BDEC_COIN', $nextMedal);
        $this->oracle->set('BDEC_CSEQ', $bdecSeq);

        $insert = $this->oracle->insert('PER_BDEC_TAB');
        return $insert;
    }

    public function process_insert_to_bdec($person, $nextMedal)
    {
        if ($nextMedal == 'ท.ช.') $cseq = '5';
        else if ($nextMedal == 'ท.ม.') $cseq = '6';
        else if ($nextMedal == 'ต.ช.') $cseq = '7';
        else if ($nextMedal == 'ต.ม.') $cseq = '8';
        else if ($nextMedal == 'จ.ช.') $cseq = '9';
        else if ($nextMedal == 'จ.ม.') $cseq = '10';
        else if ($nextMedal == 'บ.ช.') $cseq = '11';
        else if ($nextMedal == 'บ.ม.') $cseq = '12';
        else if ($nextMedal == 'ร.ท.ช.') $cseq = '13';
        else $cseq = null;

        $checkPersonInBdec = $this->check_before_insert_bdec($person['BIOG_ID'], $nextMedal);
        if ($checkPersonInBdec->num_rows() == 0) {
            $insert = $this->insert_bdec($person, $nextMedal, 'P0', $cseq);
            if ($insert) {
                $result['status']   = true;
                $result['text']     = 'บันทึกสำเร็จ';
                $result['data']     = array( 
                    'BIOG_ID' => $person['BIOG_ID'],
                    'BIOG_NAME' => $person['BIOG_NAME'],
                    'BIOG_RANK' => $person['BIOG_RANK'],
                    'BIOG_UNIT' => $person['BIOG_UNIT'],
                    'BIOG_DEC' => $person['BIOG_DEC'],
                    'NEXT_DEC' => $nextMedal
                );
            } else {
                $result['status']   = false;
                $result['text']     = 'บันทึกไม่สำเร็จ';
                $result['data']     = array( 
                    'BIOG_ID' => $person['BIOG_ID'],
                    'BIOG_NAME' => $person['BIOG_NAME'],
                    'BIOG_RANK' => $person['BIOG_RANK'],
                    'BIOG_UNIT' => $person['BIOG_UNIT'],
                    'BIOG_DEC' => $person['BIOG_DEC'],
                    'NEXT_DEC' => $nextMedal
                );
            }            
        } else {
            $result['status']   = false;
            $result['text']     = 'มีข้อมูลแล้ว';
            $result['data']     = array( 
                'BIOG_ID' => $person['BIOG_ID'],
                'BIOG_NAME' => $person['BIOG_NAME'],
                'BIOG_RANK' => $person['BIOG_RANK'],
                'BIOG_UNIT' => $person['BIOG_UNIT'],
                'BIOG_DEC' => $person['BIOG_DEC'],
                'NEXT_DEC' => $nextMedal
            );
        }

        return $result;
    }
}
