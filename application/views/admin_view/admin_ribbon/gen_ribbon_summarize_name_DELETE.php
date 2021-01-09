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
// add a page มหาปรมาภรณ์ช้างเผือก
if (count($persons_mpc)) {
    $pdf->SetMargins(10, 10, 5, true);
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', 'มหาปรมาภรณ์ช้างเผือก', 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);

    $mpcNum = 1;
    $html = '';
    foreach ($persons_mpc as $r) {
        $html .= "{$mpcNum}&nbsp;{$r['BIOG_NAME']} <br />";
        $mpcNum++;
    }
    $men = array_filter($persons_mpc, function ($r) {
        return $r['BIOG_SEX'] == '0';
    });
    $women = array_filter($persons_mpc, function ($r) {
        return $r['BIOG_SEX'] == '1';
    });
    $pdf->footText = 'มหาปรมาภรณ์ช้างเผือก จำนวน ' . count($persons_mpc) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
    $pdf->SetMargins(45, 10, 5, true);
    $pdf->setEqualColumns(2);
    $pdf->writeHTML($html);
    $pdf->resetColumns();
}
/******************************************************* */
// add a page มหาวชิรมงกุฎ
if (count($persons_mvm)) {
    $pdf->SetMargins(10, 10, 5, true);
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', 'มหาวชิรมงกุฎ', 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);

    $mvmNum = 1;
    $html = '';
    foreach ($persons_mvm as $r) {
        $html .= "{$mvmNum}&nbsp;{$r['BIOG_NAME']} <br />";
        $mvmNum++;
    }
    $men = array_filter($persons_mvm, function ($r) {
        return $r['BIOG_SEX'] == '0';
    });
    $women = array_filter($persons_mvm, function ($r) {
        return $r['BIOG_SEX'] == '1';
    });
    $pdf->footText = 'มหาวชิรมงกุฎ จำนวน ' . count($persons_mvm) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
    $pdf->SetMargins(45, 10, 5, true);
    $pdf->setEqualColumns(2);
    $pdf->writeHTML($html);
    $pdf->resetColumns();
}
/******************************************************* */
// add a page ประถมาภรณ์ช้างเผือก
if (count($persons_pc)) {
    $pdf->SetMargins(10, 10, 5, true);
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', 'ประถมาภรณ์ช้างเผือก', 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);

    $pcNum = 1;
    $html = '';
    foreach ($persons_pc as $r) {
        $html .= "{$pcNum}&nbsp;{$r['BIOG_NAME']} <br />";
        $pcNum++;
    }
    $men = array_filter($persons_pc, function ($r) {
        return $r['BIOG_SEX'] == '0';
    });
    $women = array_filter($persons_pc, function ($r) {
        return $r['BIOG_SEX'] == '1';
    });
    $pdf->footText = 'ประถมาภรณ์ช้างเผือก จำนวน ' . count($persons_pc) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
    $pdf->SetMargins(45, 10, 5, true);
    $pdf->setEqualColumns(2);
    $pdf->writeHTML($html);
    $pdf->resetColumns();
}
/******************************************************* */
// add a page ประถมาภรณ์มงกุฎไทย
if (count($persons_pm)) {
    $pdf->SetMargins(10, 10, 5, true);
    $pdf->AddPage('L');
    $pdf->writeHTMLCell(0, '', '', '', 'บัญชีรายชื่อข้าราชการทหารผู้ขอพระราชทานเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', $unit_name['NPRT_NAME'], 0, 1, 0, true, 'C', true);
    $pdf->writeHTMLCell(0, '', '', '', 'ประถมาภรณ์มงกุฎไทย', 0, 1, 0, true, 'C', true);
    $pdf->Ln(5);

    $pmNum = 1;
    $html = '';
    foreach ($persons_pm as $r) {
        $html .= "{$pmNum}&nbsp;{$r['BIOG_NAME']} <br />";
        $pmNum++;
    }
    $men = array_filter($persons_pm, function ($r) {
        return $r['BIOG_SEX'] == '0';
    });
    $women = array_filter($persons_pm, function ($r) {
        return $r['BIOG_SEX'] == '1';
    });
    $pdf->footText = 'ประถมาภรณ์มงกุฎไทย จำนวน ' . count($persons_pm) . ' นาย <br>บุรุษ ' . count($men) . ' นาย  สตรี ' . count($women) . ' นาย';
    $pdf->SetMargins(45, 10, 5, true);
    $pdf->setEqualColumns(2);
    $pdf->writeHTML($html);
    $pdf->resetColumns();
}

$pdf->Output('A.pdf', 'I');
