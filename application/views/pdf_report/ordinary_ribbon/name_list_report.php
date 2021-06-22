<?php
// GENERATE FUNCTION
function nameWithRankFull($person)
{
    if (in_array($person['BIOG_RANK'], array('50', '51'))) {
        $biogName = $person['BIOG_NAME'];
    } else {
        $gender = ($person['BIOG_SEX'] == '1') ? 'หญิง' : '';
        $name = substr($person['BIOG_NAME'], strpos($person['BIOG_NAME'], ' '));
        $biogName = "{$person['CRAK_NAME_FULL_PRINT']}{$gender} $name";
    }
    return $biogName;
}

function drawData($pdf, $person, $medalName, $year, $headquarters, $unit_name, $type, $maxRows = 25, $columns = 2)
{
    $pdf->AddPage('P');
    if ($pdf->PageNo() == 1) {
        if ($type == 'retire') $head = 'บัญชีรายชื่อข้าราชการทหารเกษียณผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์';
        else $head = 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์';
        $pdf->writeHTMLCell(0, '', '', '', $head, 0, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(0, '', '', '', $headquarters, 0, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    }
    $pdf->writeHTMLCell(0, '', '', '', $medalName[0], 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);

    $totalLen = count($person);
    $totalPage = ceil($totalLen / ($maxRows * $columns));
    for ($p = 0; $p < $totalPage; $p++) {
        $lastIndex = 0;
        $currentPeople = array();
        for ($i = 0; $i < $maxRows; $i++) {
            for ($e = 0; $e < $columns; $e++) {
                $index = $p * $maxRows * $columns + $i;
                if ($e == 0) {
                    if (isset($person[$index])) {
                        // $biogName = $index + 1 . ". {$person[$index]['BIOG_NAME']}";
                        $biogName = $index + 1 . " " . nameWithRankFull($person[$index]);
                        $pdf->writeHTMLCell(100, '', 30, '', $biogName, 0, 0, 0, true, 'L', true);
                        $lastIndex = $lastIndex > $index ? $lastIndex : $index;
                        array_push($currentPeople, $person[$index]);
                    } else break 2;
                } else {
                    if (isset($person[$index + $e * $maxRows])) {
                        // $biogName = $index + $maxRows * $e + 1 . ". {$person[$index +$e *$maxRows]['BIOG_NAME']}";
                        $biogName = $index + $maxRows * $e + 1 . " " . nameWithRankFull($person[$index + $e * $maxRows]);
                        $pdf->writeHTMLCell(100, '', '', '', $biogName, 0, 0, 0, true, 'L', true);
                        $lastIndex = $lastIndex > $index + $e * $maxRows ? $lastIndex : $index + $e * $maxRows;
                        array_push($currentPeople, $person[$index + $e * $maxRows]);
                    }
                }
            }
            $pdf->Ln();
        }
        // ===================== Old Version========================
        //
        // $indexStart = $p * $columns * $maxRows + 1;
        // $indexEnd = $lastIndex + 1;
        // $footText1 = "ลำดับที่ {$indexStart} - {$indexEnd}";
        // $pdf->writeHTMLCell(0, '', 120, 230, $footText1, 0, 1, 0, true, 'C', true);
        // $men = array_filter($person, function ($r) {
        //     return $r['BIOG_SEX'] == '0';
        // });
        // $women = array_filter($person, function ($r) {
        //     return $r['BIOG_SEX'] == '1';
        // });
        // $footText2 = $medalName[1] . ' ทั้งหมดจำนวน ' . count($person) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
        // $pdf->writeHTMLCell(0, '', 120, '', $footText2, 0, 1, 0, true, 'C', true);
        // if ($p <= $totalPage - 2) {
        //     $pdf->AddPage('L');
        // }
        // ==================================================

        $indexStart = $p * $columns * $maxRows + 1;
        $indexEnd = $lastIndex + 1;
        $footText1 = "ลำดับที่ {$indexStart} - {$indexEnd}";
        // $pdf->writeHTMLCell(0, '', 120, 230, $footText1, 0, 1, 0, true, 'C', true);
        $men = array_filter($currentPeople, function ($r) {
            return $r['BIOG_SEX'] == '0';
        });
        $women = array_filter($currentPeople, function ($r) {
            return $r['BIOG_SEX'] == '1';
        });
        $footText2 = $medalName[1] . " {$indexStart} - {$indexEnd}" . ' <br/>บุรุษ ' . count($men) . '  สตรี ' . count($women);
        $pdf->writeHTMLCell(0, '', 120, 245, $footText2, 0, 1, 0, true, 'C', true);
        if ($p <= $totalPage - 2) {
            $pdf->AddPage('L');
        }
    }
}

class MYPDF extends PDF
{
    public function Header()
    {
        if ($this->PageNo() > 1) {
            $fontname = TCPDF_FONTS::addTTFfont(FCPATH . 'assets/fonts/THSarabun.ttf', 'TrueTypeUnicode', '', 96);
            $this->SetFont($fontname, '', 14);
            $this->writeHTMLCell(55, 5, 180, '', 'แผ่นที่ ' . $this->getAliasNumPage(), 0, 1, 0, true, 'C', true);
        }
    }
    
    public function Footer()
    {
        $fontname = TCPDF_FONTS::addTTFfont(FCPATH . 'assets/fonts/THSarabun.ttf', 'TrueTypeUnicode', '', 96);

        $this->SetFont($fontname, '', 15);

        $this->writeHTMLCell(0, 0, 120, '', 'รับรองถูกต้อง', 0, 1, 0, true, 'C', true);
        $this->writeHTMLCell(0, 0, 120, '', "(ลงชื่อ) {$this->p1_rank}", 0, 1, 0, true, 'L', true);
        $this->writeHTMLCell(0, 0, 120, '', "( {$this->p1_name} )", 0, 1, 0, true, 'C', true);
        $this->writeHTMLCell(0, 0, 120, '', "ตำแหน่ง {$this->p1_position}", 0, 1, 0, true, 'L', true);
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->p1_rank = $p1_rank;
$pdf->p1_name = $p1_name;
$pdf->p1_position = $p1_position;

// $pdf->setPrintHeader(false);
// $pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 30);
$pdf->SetMargins(10, 15, 5, true);
$pdf->SetFooterMargin(35);

// set font
$fontname = TCPDF_FONTS::addTTFfont(FCPATH . 'assets/fonts/THSarabun.ttf', 'TrueTypeUnicode', '', 96);
$pdf->SetFont($fontname, '', 15, '', true);

/******************************************************* */
// add a page มหาปรมาภรณ์ช้างเผือก
if (count($persons_mpc)) {
    $medal = array('มหาปรมาภรณ์ช้างเผือก', 'ม.ป.ช.');
    drawData($pdf, $persons_mpc, $medal, $year, $headquarters, $unit_name, $condition);
}
/******************************************************* */
// add a page มหาวชิรมงกุฎ
if (count($persons_mvm)) {
    $medal = array('มหาวชิรมงกุฎ', 'ม.ว.ม.');
    drawData($pdf, $persons_mvm, $medal, $year, $headquarters, $unit_name, $condition);
}
/******************************************************* */
// add a page ประถมาภรณ์ช้างเผือก
if (count($persons_pc)) {
    $medal = array('ประถมาภรณ์ช้างเผือก', 'ป.ช.');
    drawData($pdf, $persons_pc, $medal, $year, $headquarters, $unit_name, $condition);
}
/******************************************************* */
// add a page ประถมาภรณ์มงกุฎไทย
if (count($persons_pm)) {
    $medal = array('ประถมาภรณ์มงกุฎไทย', 'ป.ม.');
    drawData($pdf, $persons_pm, $medal, $year, $headquarters, $unit_name, $condition);
}

$pdf->Output('A.pdf', 'I');
