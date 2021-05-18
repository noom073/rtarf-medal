<?php
// SETTING COLUMNS
// $maxRows = 15;
// $columns = 2;

// GENERATE FUNCTION
function drawData($pdf, $person, $medalName, $year, $headquarters, $unit_name, $type, $maxRows = 25, $columns = 2)
{
    $pdf->AddPage('P');
    if ($type == 'officer') $head = 'บัญชีรายชื่อข้าราชการทหาร ผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์';
    else $head = 'บัญชีรายชื่อลูกจ้างประจำ ผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์';
    $pdf->writeHTMLCell(0, '', '', '', $head, 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $headquarters, 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $medalName[0], 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);

    $totalLen = count($person);
    $totalPage = ceil($totalLen / ($maxRows * $columns));
    // $lastIndex = 0;
    for ($p = 0; $p < $totalPage; $p++) {
        $lastIndex = 0;
        for ($i = 0; $i < $maxRows; $i++) {
            for ($e = 0; $e < $columns; $e++) {
                $index = $p * $maxRows * $columns + $i;
                if ($e == 0) {
                    if (isset($person[$index])) {
                        $data = $index + 1 . ". {$person[$index]['BIOG_NAME']}";
                        $pdf->writeHTMLCell(100, '', 30, '', $data, 0, 0, 0, true, 'L', true);
                        $lastIndex = $lastIndex > $index ? $lastIndex : $index;
                    } else break 2;
                } else {
                    if (isset($person[$index + $e * $maxRows])) {
                        $data = $index + $maxRows * $e + 1 . ". {$person[$index +$e *$maxRows]['BIOG_NAME']}";
                        $pdf->writeHTMLCell(100, '', '', '', $data, 0, 0, 0, true, 'L', true);
                        $lastIndex = $lastIndex > $index + $e * $maxRows ? $lastIndex : $index + $e * $maxRows;
                    }
                }
            }
            $pdf->Ln();
        }

        // ============================================
        // $indexStart = $p * $columns * $maxRows + 1;
        // $indexEnd = $lastIndex + 1;
        // $footText1 = "ลำดับที่ {$indexStart} - {$indexEnd}";
        // $pdf->writeHTMLCell(0, '', 150, 160, $footText1, 0, 1, 0, true, 'C', true);
        // $men = array_filter($person, function ($r) {
        //     return $r['BIOG_SEX'] == '0';
        // });
        // $women = array_filter($person, function ($r) {
        //     return $r['BIOG_SEX'] == '1';
        // });
        // $footText2 = $medalName . ' ทั้งหมดจำนวน ' . count($person) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
        // $pdf->writeHTMLCell(0, '', 150, '', $footText2, 0, 1, 0, true, 'C', true);
        // if ($p <= $totalPage - 2) {
        //     $pdf->AddPage('L');
        // }

        $indexStart = $p * $columns * $maxRows + 1;
        $indexEnd = $lastIndex + 1;
        $footText1 = "ลำดับที่ {$indexStart} - {$indexEnd}";
        // $pdf->writeHTMLCell(0, '', 120, 230, $footText1, 0, 1, 0, true, 'C', true);
        $men = array_filter($person, function ($r) {
            return $r['BIOG_SEX'] == '0';
        });
        $women = array_filter($person, function ($r) {
            return $r['BIOG_SEX'] == '1';
        });
        $footText2 = $medalName[1] . "  {$indexStart} - {$indexEnd}" . ' <br/>บุรุษ ' . count($men) . '  สตรี ' . count($women);
        $pdf->writeHTMLCell(0, '', 120, 245, $footText2, 0, 1, 0, true, 'C', true);
        if ($p <= $totalPage - 2) {
            $pdf->AddPage('P');
        }
    }
}

class MYPDF extends PDF
{
    //Page Footer
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

$pdf->setPrintHeader(false);
// $pdf->setPrintFooter(false);
// $pdf->SetHeaderMargin(15);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 30);
$pdf->SetMargins(10, 15, 5, true);
$pdf->SetFooterMargin(35);

// set font
$fontname = TCPDF_FONTS::addTTFfont(FCPATH . 'assets/fonts/THSarabun.ttf', 'TrueTypeUnicode', '', 96);
$pdf->SetFont($fontname, '', 15, '', true);

/******************************************************* */
// add a page ทวีติยาภรณ์ช้างเผือก
if (count($thc)) {
    $medal = array('ทวีติยาภรณ์ช้างเผือก', 'ท.ช.');
    drawData($pdf, $thc, $medal, $year, $headquarters, $unit_name, $type);
}
/******************************************************* */
// add a page ทวีติยาภรณ์มงกุฎไทย
if (count($thm)) {
    $medal = array('ทวีติยาภรณ์มงกุฎไทย', 'ท.ม.');
    drawData($pdf, $thm, $medal, $year, $headquarters, $unit_name, $type);
}
/******************************************************* */
// add a page ตริตาภรณ์ช้างเผือก
if (count($tc)) {
    $medal = array('ตริตาภรณ์ช้างเผือก', 'ต.ช.');
    drawData($pdf, $tc, $medal, $year, $headquarters, $unit_name, $type);
}

/******************************************************* */
// add a page ตริตาภรณ์มงกุฏไทย
if (count($tm)) {
    $medal = array('ตริตาภรณ์มงกุฏไทย', 'ต.ม.');
    drawData($pdf, $tm, $medal, $year, $headquarters, $unit_name, $type);
}

/******************************************************* */
// add a page จัตุรถาภรณ์ช้างเผือก
if (count($jc)) {
    $medal = array('จัตุรถาภรณ์ช้างเผือก', 'จ.ช.');
    drawData($pdf, $jc, $medal, $year, $headquarters, $unit_name, $type);
}

/******************************************************* */
// add a page จัตุรถาภรณ์มงกุฏไทย
if (count($jm)) {
    $medal = array('จัตุรถาภรณ์มงกุฏไทย', 'จ.ม.');
    drawData($pdf, $jm, $medal, $year, $headquarters, $unit_name, $type);
}

/******************************************************* */
// add a page เบญจมาภรณ์ช้างเผือก
if (count($bc)) {
    $medal = array('เบญจมาภรณ์ช้างเผือก', 'บ.ช.');
    drawData($pdf, $bc, $medal, $year, $headquarters, $unit_name, $type);
}

/******************************************************* */
// add a page เบญจมาภรณ์มงกุฎไทย
if (count($bm)) {
    $medal = array('เบญจมาภรณ์มงกุฎไทย', 'บ.ม.');
    drawData($pdf, $bm, $medal, $year, $headquarters, $unit_name, $type);
}

/******************************************************* */
// add a page เหรียญทองช้างเผือก
if (count($rtc)) {
    $medal = array('เหรียญทองช้างเผือก', 'ร.ท.ช.');
    drawData($pdf, $rtc, $medal, $year, $headquarters, $unit_name, $type);
}

/******************************************************* */

$pdf->Output('A.pdf', 'I');
