<?php

class MYPDF extends PDF
{
    //Page header
    public function Header()
    {
        $fontname = TCPDF_FONTS::addTTFfont(FCPATH . 'assets/fonts/THSarabun.ttf', 'TrueTypeUnicode', '', 96);

        $this->SetFont($fontname, '', 16);

        $head = '<span>บัญชีแสดงคุณสมบัติของข้าราชการทหาร ซึ่งเสนอขอพระราชทานเครื่องราชอิสริยาภรณ์ประจำปี พ.ศ.' . $this->myYear . '</span>';
        $this->writeHTMLCell(0, '', '', '', $head, 0, 1, 0, true, 'C', true);
        // $this->writeHTMLCell(0, '', '', '', 'ของข้าราชการ กองทัพไทย', 0, 1, 0, true, 'C', true);
        $this->writeHTMLCell(0, '', '', '', 'กองทัพไทย', 0, 1, 0, true, 'C', true);
        $this->writeHTMLCell(0, '', '', '', $this->headerUnitName, 0, 1, 0, true, 'C', true);
    }

    //Page Footer
    public function Footer()
    {
        $fontname = TCPDF_FONTS::addTTFfont(FCPATH . 'assets/fonts/THSarabun.ttf', 'TrueTypeUnicode', '', 96);

        $this->SetFont($fontname, '', 16);        

        $this->writeHTMLCell(95, 0, 200, '', 'รับรองถูกต้อง', 0, 1, 0, true, 'C', true);
        $this->writeHTMLCell(95, 0, 200, '', "(ลงชื่อ) {$this->p2_rank}", 0, 1, 0, true, 'L', true);
        $this->writeHTMLCell(95, 0, 200, '', "( {$this->p2_name} )", 0, 1, 0, true, 'C', true);
        $this->writeHTMLCell(95, 0, 200, '', "ตำแหน่ง {$this->p2_position}", 0, 1, 0, true, 'L', true);
    }
}

$dm = date('dm') . strval(date('Y') + 543);

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->headerUnitName = $unit_name['NPRT_NAME'];
$pdf->p2_rank = $p2_rank;
$pdf->p2_name = $p2_name;
$pdf->p2_position = $p2_position;
// $pdf->myYear = strval(date('Y') + 543);
$pdf->myYear = $year;
$pdf->curDate = $this->myfunction->dmy_to_thai($dm, 0);
$pdf->SetMargins(5, 45, 5);
$pdf->SetHeaderMargin(15);
$pdf->SetFooterMargin(30);

// set auto page breaks

$pdf->SetAutoPageBreak(TRUE, 37);

// set font
$fontname = TCPDF_FONTS::addTTFfont(FCPATH . 'assets/fonts/THSarabun.ttf', 'TrueTypeUnicode', '', 96);
$pdf->SetFont($fontname, '', 15, '', true);

// add a page
$pdf->AddPage('L');

// set Content To print
$html = '';
$html .= '<table border=".5" cellpadding="3" cellspacing="0">';
$html .=    '<thead>';
$html .=        '<tr>';
$html .=            '<th rowspan="2" width="4%" style="text-align: center">ลำดับ</th>';
$html .=            '<th rowspan="2" width="18%" style="text-align: center">ชื่อตัว - ชื่อสกุล</th>';
$html .=            '<th colspan="3" width="22%" style="text-align: center">เป็นข้าราชการ</th>';
$html .=            '<th rowspan="2" width="22%" style="text-align: center">ตำแหน่ง <br /> ปัจจุบันและอดีตเฉพาะปีที่ได้รับ <br /> พระราชทานเครื่องราชอิสริยาภรณ์</th>';
$html .=            '<th colspan="3" width="19.5%" style="text-align: center">เครื่องราชอิสริยาภรณ์</th>';
$html .=            '<th rowspan="2" width="14.5%" style="text-align: center">หมายเหตุ <br /> (เริ่มบรรจุกรณีขอครั้งแรก, โอนมาจาก, ชื่อตัว - ชื่อสกุลเดิม ชื่อตำแหน่งตามบัญชีอื่น, ปีเกษียณ)</th>';
$html .=        '</tr>';
$html .=        '<tr>';
$html .=            '<th style="text-align: center" width="8.5%">ระดับ/ขั้น (ปัจจุบัน)</th>';
$html .=            '<th style="text-align: center" width="8%">ตั้งแต่ วัน เดือน ปี</th>';
$html .=            '<th style="text-align: center" width="5.5%">เงินเดือน (ปัจจุบัน)</th>';

$html .=            '<th style="text-align: center" width="6%">ที่ได้รับ <br /> (จากชั้นสูงไปชั้นรอง)</th>';
$html .=            '<th style="text-align: center" width="8.5%">วัน เดือน ปี (28 ก.ค. ...)</th>';
$html .=            '<th style="text-align: center" width="5%">ขอครั้งนี้</th>';

$html .=        '</tr>';
$html .=    '</thead>';
$html .=    '<tbody>';
$html .=        '<tr nobr="true">';
$html .=            '<td width="4%" style="text-align: center"></td>';
$html .=            '<td width="18%">' . $ribbon_name . '</td>';
$html .=            '<td width="8.5%"></td>';
$html .=            '<td width="8%"></td>';
$html .=            '<td width="5.5%"></td>';
$html .=            '<td width="22%"></td>';
$html .=            '<td width="6%"></td>';
$html .=            '<td width="8.5%"></td>';
$html .=            '<td width="5%"></td>';
$html .=            '<td width="14.5%"></td>';
$html .=        '</tr>';

$num = 1;
foreach ($persons as $r) {
    $biog_dmy_rank  = $this->myfunction->dmy_to_thai($r['BIOG_DMY_RANK'], 2);
    $biog_decy  = $this->person_data->set_cdec_date($r['BIOG_DECY']);
    if (in_array($r['BIOG_RANK'], array('50', '51'))) {
        $specialRank = '';
        $gender = '';
        $rankOrSalary = "{$r['BIOG_SLEVEL']}/{$r['BIOG_SCLASS']}";
    } else {
        $specialRank = ($r['BIOG_RANK'] == '05' || $r['BIOG_RANK'] == '21') ? '(พิเศษ)' : '';
        $gender = ($r['BIOG_SEX'] == '1') ? 'หญิง': '';
        $rankOrSalary = "{$r['CRAK_NAME_FULL']}<br/> {$specialRank}";
    }

    $html .=    '<tr nobr="true">';
    $html .=        '<td width="4%" style="text-align: center">' . $num . '</td>';
    $html .=        '<td width="18%">' . $r['BIOG_NAME'] . '<br>' . $r['BIOG_IDP'] . '</td>';
    $html .=        '<td width="8.5%" style="text-align: center">' . $rankOrSalary . '</td>';
    $html .=        '<td width="8%" style="text-align: center">' . $biog_dmy_rank . '</td>';
    $html .=        '<td width="5.5%" style="text-align: center">' . number_format($r['BIOG_SALARY']) . '</td>';
    $html .=        '<td width="22%">' . $r['BIOG_POSNAME_FULL'] . '<br/> <br/>' . "{$r['CRAK_NAME_FULL']}{$gender} {$specialRank}" . '</td>';
    $html .=        '<td width="6%" style="text-align: center">' . $r['BIOG_DEC'] . '</td>';
    $html .=        '<td width="8.5%" style="text-align: center">' . $biog_decy . '</td>';
    $html .=        '<td width="5%" style="text-align: center">' . $ribbon_acm . '</td>';
    $html .=        '<td width="14.5%"></td>';
    $html .=    '</tr>';

    $num++;
}

$html .=    '</tbody>';
$html .= '</table>';
$pdf->writeHTML($html, 0, 0, true, 0);

$y = $pdf->GetY();
$cur = $pdf->getBreakMargin();
// echo $y-$cur;
if (($y - $cur) > 90) $pdf->AddPage('L');

$message = 'ขอรับรองว่ารายละเอียดข้างต้นถูกต้องและเป็นผู้มีคุณสมบัติตามระเบียบ 
    ว่าด้วยการขอพระราชทานเครื่องราชอิสริยาภรณ์ พ.ศ. 2536 ข้อ 8,10,19(3),21
    (เฉพาะกลาโหมพลเรือน),22';
$pdf->writeHTMLCell(110, 0, 130, '', $message, 0, 1, 0, true, 'L', true);
$pdf->writeHTMLCell(110, 0, 130, '', "(ลงชื่อ) {$p1_rank}", 0, 1, 0, true, 'L', true);
$pdf->writeHTMLCell(110, 0, 130, '', "( {$p1_name} )", 0, 1, 0, true, 'C', true);
$pdf->writeHTMLCell(110, 0, 130, '', "ตำแหน่ง {$p1_position}", 0, 1, 0, true, 'L', true);
$pdf->writeHTMLCell(110, 0, 130, '', 'ผุ้เสนอขอพระราชทาน', 0, 1, 0, true, 'C', true);
$pdf->Output('A.pdf', 'I');
