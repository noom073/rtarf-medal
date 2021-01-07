<?php
class MYPDF extends PDF
{
    //Page Footer
    public $footText;
    public function Footer()
    {
        $fontname = TCPDF_FONTS::addTTFfont(FCPATH . 'assets/fonts/THSarabun.ttf', 'TrueTypeUnicode', '', 96);
        $this->SetFont($fontname, '', 16);

        $this->writeHTMLCell(0, '', 200, '', $this->footText, 0, 1, 0, true, 'L', true);
        // $this->writeHTMLCell(0, '', 200, '', 'ลงชื่อ', 0, 1, 0, true, 'L', true);
        // $this->SetX(210);
        // $this->Cell(0, 0, '(                                                )', 0, 1, 'L', 0, '', 0);
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setPrintHeader(false);
// $pdf->setPrintFooter(false);
// $pdf->SetHeaderMargin(15);
$pdf->SetFooterMargin(40);

// set auto page breaks

$pdf->SetAutoPageBreak(TRUE, 50);

// set font
$fontname = TCPDF_FONTS::addTTFfont(FCPATH . 'assets/fonts/THSarabun.ttf', 'TrueTypeUnicode', '', 96);
$pdf->SetFont($fontname, '', 15, '', true);

/******************************************************* */
// add a page ทวีติยาภรณ์ช้างเผือก
if (count($thc)) {
    $pdf->SetMargins(10, 10, 5, true);
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', 'ทวีติยาภรณ์ช้างเผือก', 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);
    $thcNum = 1;
    $html = '';
    foreach ($thc as $r) {
        $html .= "{$thcNum}&nbsp;{$r['BIOG_NAME']} <br />";
        $thcNum++;
    }
    $men = array_filter($thc, function ($r) {
        return $r['BIOG_SEX'] == '0';
    });
    $women = array_filter($thc, function ($r) {
        return $r['BIOG_SEX'] == '1';
    });
    $pdf->footText = 'ทวีติยาภรณ์ช้างเผือก จำนวน ' . count($thc) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
    // $pdf->writeHTMLCell(0, '', 200, 170, $footText, 0, 1, 0, true, 'L', true);
    $pdf->SetMargins(45, 10, 5, true);
    $pdf->setEqualColumns(2);
    $pdf->writeHTML($html);
    $pdf->resetColumns();
}
/******************************************************* */
// add a page ทวีติยาภรณ์มงกุฎไทย
if (count($thm)) {
    $pdf->SetMargins(10, 10, 5, true);
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', 'ทวีติยาภรณ์มงกุฎไทย', 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);
    $thmNum = 1;
    $html = '';
    foreach ($thm as $r) {
        $html .= "{$thmNum}&nbsp;{$r['BIOG_NAME']} <br />";
        $thmNum++;
    }
    $men = array_filter($thm, function ($r) {
        return $r['BIOG_SEX'] == '0';
    });
    $women = array_filter($thm, function ($r) {
        return $r['BIOG_SEX'] == '1';
    });
    $pdf->footText = 'ทวีติยาภรณ์มงกุฎไทย จำนวน ' . count($thm) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
    // $pdf->writeHTMLCell(0, '', 200, 170, $footText, 0, 1, 0, true, 'L', true);
    $pdf->SetMargins(45, 10, 5, true);
    $pdf->setEqualColumns(2);
    $pdf->writeHTML($html);
    $pdf->resetColumns();
}
/******************************************************* */
// add a page ตริตาภรณ์ช้างเผือก
if (count($tc)) {
    $pdf->SetMargins(10, 10, 5, true);
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', 'ตริตาภรณ์ช้างเผือก', 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);
    $tcNum = 1;
    $html = '';
    foreach ($tc as $r) {
        $html .= "{$tcNum}&nbsp;{$r['BIOG_NAME']} <br />";
        $tcNum++;
    }
    $men = array_filter($tc, function ($r) {
        return $r['BIOG_SEX'] == '0';
    });
    $women = array_filter($tc, function ($r) {
        return $r['BIOG_SEX'] == '1';
    });
    $pdf->footText = 'ตริตาภรณ์ช้างเผือก จำนวน ' . count($tc) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
    // $pdf->writeHTMLCell(0, '', 200, 170, $footText, 0, 1, 0, true, 'L', true);
    $pdf->SetMargins(45, 10, 5, true);
    $pdf->setEqualColumns(2);
    $pdf->writeHTML($html);
    $pdf->resetColumns();
}

/******************************************************* */
// add a page ตริตาภรณ์มงกุฏไทย
if (count($tm)) {
    $pdf->SetMargins(10, 10, 5, true);
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', 'ตริตาภรณ์มงกุฏไทย', 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);
    $tmNum = 1;
    $html = '';
    foreach ($tm as $r) {
        $html .= "{$tmNum}&nbsp;{$r['BIOG_NAME']} <br />";
        $tmNum++;
    }
    $men = array_filter($tm, function ($r) {
        return $r['BIOG_SEX'] == '0';
    });
    $women = array_filter($tm, function ($r) {
        return $r['BIOG_SEX'] == '1';
    });
    $pdf->footText = 'ตริตาภรณ์มงกุฏไทย จำนวน ' . count($tm) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
    // $pdf->writeHTMLCell(0, '', 200, 170, $footText, 0, 1, 0, true, 'L', true);
    $pdf->SetMargins(45, 10, 5, true);
    $pdf->setEqualColumns(2);
    $pdf->writeHTML($html);
    $pdf->resetColumns();
}

/******************************************************* */
// add a page จัตุรถาภรณ์ช้างเผือก
if (count($jc)) {
    $pdf->SetMargins(10, 10, 5, true);
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', 'จัตุรถาภรณ์ช้างเผือก', 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);
    $jcNum = 1;
    $html = '';
    foreach ($jc as $r) {
        $html .= "{$jcNum}&nbsp;{$r['BIOG_NAME']} <br />";
        $jcNum++;
    }
    $men = array_filter($jc, function ($r) {
        return $r['BIOG_SEX'] == '0';
    });
    $women = array_filter($jc, function ($r) {
        return $r['BIOG_SEX'] == '1';
    });
    $pdf->footText = 'จัตุรถาภรณ์ช้างเผือก จำนวน ' . count($jc) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
    // $pdf->writeHTMLCell(0, '', 200, 170, $footText, 0, 1, 0, true, 'L', true);
    $pdf->SetMargins(45, 10, 5, true);
    $pdf->setEqualColumns(2);
    $pdf->writeHTML($html);
    $pdf->resetColumns();
}

/******************************************************* */
// add a page จัตุรถาภรณ์มงกุฏไทย
if (count($jm)) {
    $pdf->SetMargins(10, 10, 5, true);
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', 'จัตุรถาภรณ์มงกุฏไทย', 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);
    $jmNum = 1;
    $html = '';
    foreach ($jm as $r) {
        $html .= "{$jmNum}&nbsp;{$r['BIOG_NAME']} <br />";
        $jmNum++;
    }
    $men = array_filter($jm, function ($r) {
        return $r['BIOG_SEX'] == '0';
    });
    $women = array_filter($jm, function ($r) {
        return $r['BIOG_SEX'] == '1';
    });
    $pdf->footText = 'จัตุรถาภรณ์มงกุฏไทย จำนวน ' . count($jm) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
    // $pdf->writeHTMLCell(0, '', 200, 170, $footText, 0, 1, 0, true, 'L', true);
    $pdf->SetMargins(45, 10, 5, true);
    $pdf->setEqualColumns(2);
    $pdf->writeHTML($html);
    $pdf->resetColumns();
}

/******************************************************* */
// add a page เบญจมาภรณ์ช้างเผือก
if (count($bc)) {
    $pdf->SetMargins(10, 10, 5, true);
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', 'เบญจมาภรณ์ช้างเผือก', 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);
    $bcNum = 1;
    $html = '';
    foreach ($bc as $r) {
        $html .= "{$bcNum}&nbsp;{$r['BIOG_NAME']} <br />";
        $bcNum++;
    }
    $men = array_filter($bc, function ($r) {
        return $r['BIOG_SEX'] == '0';
    });
    $women = array_filter($bc, function ($r) {
        return $r['BIOG_SEX'] == '1';
    });
    $pdf->footText = 'เบญจมาภรณ์ช้างเผือก จำนวน ' . count($bc) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
    // $pdf->writeHTMLCell(0, '', 200, 170, $footText, 0, 1, 0, true, 'L', true);
    $pdf->SetMargins(45, 10, 5, true);
    $pdf->setEqualColumns(2);
    $pdf->writeHTML($html);
    $pdf->resetColumns();
}

/******************************************************* */
// add a page เบญจมาภรณ์มงกุฎไทย
if (count($bm)) {
    $pdf->SetMargins(10, 10, 5, true);
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', 'เบญจมาภรณ์มงกุฎไทย', 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);
    $bmNum = 1;
    $html = '';
    foreach ($bm as $r) {
        $html .= "{$bmNum}&nbsp;{$r['BIOG_NAME']} <br />";
        $bmNum++;
    }
    $men = array_filter($bm, function ($r) {
        return $r['BIOG_SEX'] == '0';
    });
    $women = array_filter($bm, function ($r) {
        return $r['BIOG_SEX'] == '1';
    });
    $pdf->footText = 'เบญจมาภรณ์มงกุฎไทย จำนวน ' . count($bm) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
    // $pdf->writeHTMLCell(0, '', 200, 170, $footText, 0, 1, 0, true, 'L', true);
    $pdf->SetMargins(45, 10, 5, true);
    $pdf->setEqualColumns(2);
    $pdf->writeHTML($html);
    $pdf->resetColumns();
}

/******************************************************* */
// add a page เหรียญทองช้างเผือก
if (count($rtc)) {
    $pdf->SetMargins(10, 10, 5, true);
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', 'เหรียญทองช้างเผือก', 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);
    $rtcNum = 1;
    $html = '';
    foreach ($rtc as $r) {
        $html .= "{$rtcNum}&nbsp;{$r['BIOG_NAME']} <br />";
        $rtcNum++;
    }
    $men = array_filter($rtc, function ($r) {
        return $r['BIOG_SEX'] == '0';
    });
    $women = array_filter($rtc, function ($r) {
        return $r['BIOG_SEX'] == '1';
    });
    $pdf->footText = 'เหรียญทองช้างเผือก จำนวน ' . count($rtc) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
    // $pdf->writeHTMLCell(0, '', 200, 170, $footText, 0, 1, 0, true, 'L', true);
    $pdf->SetMargins(45, 10, 5, true);
    $pdf->setEqualColumns(2);
    $pdf->writeHTML($html);
    $pdf->resetColumns();
}

/******************************************************* */
// add a page เหรียญทองมงกุฎไทย
if (count($rtm)) {
    $pdf->SetMargins(10, 10, 5, true);
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', 'เหรียญทองมงกุฎไทย', 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);
    $rtmNum = 1;
    $html = '';
    foreach ($rtm as $r) {
        $html .= "{$rtmNum}&nbsp;{$r['BIOG_NAME']} <br />";
        $rtmNum++;
    }
    $men = array_filter($rtm, function ($r) {
        return $r['BIOG_SEX'] == '0';
    });
    $women = array_filter($rtm, function ($r) {
        return $r['BIOG_SEX'] == '1';
    });
    $pdf->footText = 'เหรียญทองมงกุฎไทย จำนวน ' . count($rtm) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
    // $pdf->writeHTMLCell(0, '', 200, 170, $footText, 0, 1, 0, true, 'L', true);
    $pdf->SetMargins(45, 10, 5, true);
    $pdf->setEqualColumns(2);
    $pdf->writeHTML($html);
    $pdf->resetColumns();
}

/******************************************************* */
// add a page เหรียญเงินช้างเผือก
if (count($rgc)) {
    $pdf->SetMargins(10, 10, 5, true);
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', 'เหรียญเงินช้างเผือก', 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);
    $rgcNum = 1;
    $html = '';
    foreach ($rgc as $r) {
        $html .= "{$rgcNum}&nbsp;{$r['BIOG_NAME']} <br />";
        $rgcNum++;
    }
    $men = array_filter($rgc, function ($r) {
        return $r['BIOG_SEX'] == '0';
    });
    $women = array_filter($rgc, function ($r) {
        return $r['BIOG_SEX'] == '1';
    });
    $pdf->footText = 'เหรียญเงินช้างเผือก จำนวน ' . count($rgc) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
    // $pdf->writeHTMLCell(0, '', 200, 170, $footText, 0, 1, 0, true, 'L', true);
    $pdf->SetMargins(45, 10, 5, true);
    $pdf->setEqualColumns(2);
    $pdf->writeHTML($html);
    $pdf->resetColumns();
}

/******************************************************* */
// add a page เหรียญเงินมงกุฎไทย
if (count($rgm)) {
    $pdf->SetMargins(10, 10, 5, true);
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', 'เหรียญเงินมงกุฎไทย', 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);
    $rgmNum = 1;
    $html = '';
    foreach ($rgm as $r) {
        $html .= "{$rgmNum}&nbsp;{$r['BIOG_NAME']} <br />";
        $rgmNum++;
    }
    $men = array_filter($rgm, function ($r) {
        return $r['BIOG_SEX'] == '0';
    });
    $women = array_filter($rgm, function ($r) {
        return $r['BIOG_SEX'] == '1';
    });
    $pdf->footText = 'เหรียญเงินมงกุฎไทย จำนวน ' . count($rgm) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
    // $pdf->writeHTMLCell(0, '', 200, 170, $footText, 0, 1, 0, true, 'L', true);
    $pdf->SetMargins(45, 10, 5, true);
    $pdf->setEqualColumns(2);
    $pdf->writeHTML($html);
    $pdf->resetColumns();
}

/******************************************************* */

$pdf->Output('A.pdf', 'I');
