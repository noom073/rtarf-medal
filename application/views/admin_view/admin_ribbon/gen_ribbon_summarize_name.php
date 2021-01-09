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
                    }
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
// add a page มหาปรมาภรณ์ช้างเผือก
if (count($persons_mpc)) {
    drawData($pdf, $persons_mpc, 'มหาปรมาภรณ์ช้างเผือก', $year, $unit_name);
}
/******************************************************* */
// add a page มหาวชิรมงกุฎ
if (count($persons_mvm)) {
    drawData($pdf, $persons_mvm, 'มหาวชิรมงกุฎ', $year, $unit_name);
}
/******************************************************* */
// add a page ประถมาภรณ์ช้างเผือก
if (count($persons_pc)) {
    drawData($pdf, $persons_pc, 'ประถมาภรณ์ช้างเผือก', $year, $unit_name);
}
/******************************************************* */
// add a page ประถมาภรณ์มงกุฎไทย
if (count($persons_pm)) {
    drawData($pdf, $persons_pm, 'ประถมาภรณ์มงกุฎไทย', $year, $unit_name);
}

$pdf->Output('A.pdf', 'I');
