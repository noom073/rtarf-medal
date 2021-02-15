<?php
// SETTING COLUMNS
// $maxRows = 15;
// $columns = 2;

// GENERATE FUNCTION
function drawData($pdf, $person, $medalName, $year, $unit_name, $maxRows = 15, $columns = 2)
{
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $medalName, 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);

    $totalLen = count($person);
    $totalPage = ceil($totalLen / ($maxRows * $columns));
    $lastIndex = 0;
    for ($p = 0; $p < $totalPage; $p++) {
        $lastIndex = 0;
        for ($i = 0; $i < $maxRows; $i++) {
            for ($e = 0; $e < $columns; $e++) {
                $index = $p * $maxRows * $columns + $i;
                if ($e == 0) {
                    if (isset($person[$index])) {
                        $data = $index + 1 . ". {$person[$index]['BIOG_NAME']}";
                        $pdf->writeHTMLCell(100, '', 70, '', $data, 0, 0, 0, true, 'L', true);
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
        $indexStart = $p * $columns * $maxRows + 1;
        $indexEnd = $lastIndex + 1;
        $footText1 = "ลำดับที่ {$indexStart} - {$indexEnd}";
        $pdf->writeHTMLCell(0, '', 150, 160, $footText1, 0, 1, 0, true, 'C', true);
        $men = array_filter($person, function ($r) {
            return $r['BIOG_SEX'] == '0';
        });
        $women = array_filter($person, function ($r) {
            return $r['BIOG_SEX'] == '1';
        });
        $footText2 = $medalName . ' ทั้งหมดจำนวน ' . count($person) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
        $pdf->writeHTMLCell(0, '', 150, '', $footText2, 0, 1, 0, true, 'C', true);
        if ($p <= $totalPage - 2) {
            $pdf->AddPage('L');
        }
    }
}

// create new PDF document
$pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// $pdf->SetHeaderMargin(15);
// $pdf->SetFooterMargin(40);

// set auto page breaks

$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetMargins(10, 15, 5, true);
// set font
$fontname = TCPDF_FONTS::addTTFfont(FCPATH . 'assets/fonts/THSarabun.ttf', 'TrueTypeUnicode', '', 96);
$pdf->SetFont($fontname, '', 15, '', true);

/******************************************************* */
// add a page ทวีติยาภรณ์ช้างเผือก
if (count($thc)) {
    drawData($pdf, $thc, 'ทวีติยาภรณ์ช้างเผือก', $year, $unit_name);
}
/******************************************************* */
// add a page ทวีติยาภรณ์มงกุฎไทย
if (count($thm)) {
    drawData($pdf, $thm, 'ทวีติยาภรณ์มงกุฎไทย', $year, $unit_name);
}
/******************************************************* */
// add a page ตริตาภรณ์ช้างเผือก
if (count($tc)) {
    drawData($pdf, $tc, 'ตริตาภรณ์ช้างเผือก', $year, $unit_name);
}

/******************************************************* */
// add a page ตริตาภรณ์มงกุฏไทย
if (count($tm)) {
    drawData($pdf, $tm, 'ตริตาภรณ์มงกุฏไทย', $year, $unit_name);
}

/******************************************************* */
// add a page จัตุรถาภรณ์ช้างเผือก
if (count($jc)) {
    drawData($pdf, $jc, 'จัตุรถาภรณ์ช้างเผือก', $year, $unit_name);
}

/******************************************************* */
// add a page จัตุรถาภรณ์มงกุฏไทย
if (count($jm)) {
    drawData($pdf, $jm, 'จัตุรถาภรณ์มงกุฏไทย', $year, $unit_name);
}

/******************************************************* */
// add a page เบญจมาภรณ์ช้างเผือก
if (count($bc)) {
    drawData($pdf, $bc, 'เบญจมาภรณ์ช้างเผือก', $year, $unit_name);
}

/******************************************************* */
// add a page เบญจมาภรณ์มงกุฎไทย
if (count($bm)) {
    drawData($pdf, $bm, 'เบญจมาภรณ์มงกุฎไทย', $year, $unit_name);
}

/******************************************************* */
// add a page เหรียญทองช้างเผือก
if (count($rtc)) {
    drawData($pdf, $rtc, 'เหรียญทองช้างเผือก', $year, $unit_name);
}

/******************************************************* */
// add a page เหรียญทองมงกุฎไทย
if (count($rtm)) {
    drawData($pdf, $rtm, 'เหรียญทองมงกุฎไทย', $year, $unit_name);
}

/******************************************************* */
// add a page เหรียญเงินช้างเผือก
if (count($rgc)) {
    drawData($pdf, $rgc, 'เหรียญเงินช้างเผือก', $year, $unit_name);
}

/******************************************************* */
// add a page เหรียญเงินมงกุฎไทย
if (count($rgm)) {
    drawData($pdf, $rgm, 'เหรียญเงินมงกุฎไทย', $year, $unit_name);
}

/******************************************************* */

$pdf->Output('A.pdf', 'I');
