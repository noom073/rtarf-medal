<?php
// echo $mpc['men'] > 0 ? $mpc['men'] : '-';
// exit;
$thcMen     = $thc['men'] > 0 ? $thc['men'] : '-';
$thcWomen   = $thc['women'] > 0 ? $thc['women'] : '-';
$thmMen     = $thm['men'] > 0 ? $thm['men'] : '-';
$thmWomen   = $thm['women'] > 0 ? $thm['women'] : '-';
$tcMen      = $tc['men'] > 0 ? $tc['men'] : '-';
$tcWomen    = $tc['women'] > 0 ? $tc['women'] : '-';
$tmMen      = $tm['men'] > 0 ? $tm['men'] : '-';
$tmWomen    = $tm['women'] > 0 ? $tm['women'] : '-';
$jcMen      = $jc['men'] > 0 ? $jc['men'] : '-';
$jcWomen    = $jc['women'] > 0 ? $jc['women'] : '-';
$jmMen      = $jm['men'] > 0 ? $jm['men'] : '-';
$jmWomen    = $jm['women'] > 0 ? $jm['women'] : '-';
$bcMen      = $bc['men'] > 0 ? $bc['men'] : '-';
$bcWomen    = $bc['women'] > 0 ? $bc['women'] : '-';
$bmMen      = $bm['men'] > 0 ? $bm['men'] : '-';
$bmWomen    = $bm['women'] > 0 ? $bm['women'] : '-';
$rtcMen      = $rtc['men'] > 0 ? $rtc['men'] : '-';
$rtcWomen    = $rtc['women'] > 0 ? $rtc['women'] : '-';

$countMen   = $thc['men'] + $thm['men'] + $tc['men'] + $tm['men'] + $jc['men'] + $jm['men'] + $bc['men'] + $bm['men'] + $rtc['men'];
$countWomen = $thc['women'] + $thm['women'] + $tc['women'] + $tm['women'] + $jc['women'] + $jm['women'] + $bc['women'] + $bm['women'] + $rtc['women'];
// create new PDF document
$pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// $pdf->SetHeaderMargin(15);
// $pdf->SetFooterMargin(1);

// set auto page breaks

$pdf->SetAutoPageBreak(TRUE, 10);

// set font
$fontname = TCPDF_FONTS::addTTFfont(FCPATH . 'assets/fonts/THSarabun.ttf', 'TrueTypeUnicode', '', 96);
$pdf->SetFont($fontname, '', 15, '', true);

/******************************************************* */
// add a page มหาปรมาภรณ์ช้างเผือก
$pdf->SetMargins(3, 10, 3, true);
$pdf->AddPage('L');
if ($type == 'employee') $head = '<span>ซึ่งขอพระราชทานให้แก่ลูกจ้างประจำ</span>';
else $head = '<span>ซึ่งขอพระราชทานให้แก่ข้าราชการทหาร</span>';

$pdf->writeHTMLCell(0, '', '', '', 'บัญชีแสดงจำนวนชั้นตราเครื่องราชอิสริยาภรณ์', 0, 1, 0, true, 'C', true);
$pdf->writeHTMLCell(0, '', '', '', $head, 0, 1, 0, true, 'C', true);
$pdf->writeHTMLCell(0, '', '', '', "กองทัพไทย", 0, 1, 0, true, 'C', true);
$pdf->writeHTMLCell(0, '', '', '', "ชั้นต่ำกว่าสายสะพาย ประจำปี พ.ศ. {$year}", 0, 1, 0, true, 'C', true);
$pdf->Ln(5);


$html = '';
$html .= '<table border=".5" cellpadding="2" cellspacing="0">';
$html   .= '<thead>';
$html       .= '<tr>';
$html           .= '<th rowspan="3" style="text-align:center;" width="4%">ลำดับ</th>';
$html           .= '<th rowspan="3" style="text-align:center;" width="17%">กรม/ส่วนราชการที่เทียบเท่า</th>';
$html           .= '<th colspan="24" style="text-align:center;" width="63%">เครื่องราชอิสริยาภรณ์</th>';
$html           .= '<th rowspan="2" colspan="2" style="text-align:center;" width="8%">รวม <br /> จำนวน</th>';
$html           .= '<th rowspan="3" style="text-align:center;" width="8%">หมายเหตุ</th>';
$html       .= '</tr>';
$html       .= '<tr>';
$html           .= '<th colspan="2" style="text-align:center;" width="7%">ท.ช.</th>';
$html           .= '<th colspan="2" style="text-align:center;" width="7%">ท.ม.</th>';
$html           .= '<th colspan="2" style="text-align:center;" width="7%">ต.ช.</th>';
$html           .= '<th colspan="2" style="text-align:center;" width="7%">ต.ม.</th>';
$html           .= '<th colspan="2" style="text-align:center;" width="7%">จ.ช.</th>';
$html           .= '<th colspan="2" style="text-align:center;" width="7%">จ.ม.</th>';
$html           .= '<th colspan="2" style="text-align:center;" width="7%">บ.ช.</th>';
$html           .= '<th colspan="2" style="text-align:center;" width="7%">บ.ม.</th>';
$html           .= '<th colspan="2" style="text-align:center;" width="7%">ร.ท.ช.</th>';
$html       .= '</tr>';
$html       .= '<tr>';
$html           .= '<th style="text-align:center;" width="3.5%">บุรุษ</th>';
$html           .= '<th style="text-align:center;" width="3.5%">สตรี</th>';
$html           .= '<th style="text-align:center;" width="3.5%">บุรุษ</th>';
$html           .= '<th style="text-align:center;" width="3.5%">สตรี</th>';
$html           .= '<th style="text-align:center;" width="3.5%">บุรุษ</th>';
$html           .= '<th style="text-align:center;" width="3.5%">สตรี</th>';
$html           .= '<th style="text-align:center;" width="3.5%">บุรุษ</th>';
$html           .= '<th style="text-align:center;" width="3.5%">สตรี</th>';
$html           .= '<th style="text-align:center;" width="3.5%">บุรุษ</th>';
$html           .= '<th style="text-align:center;" width="3.5%">สตรี</th>';
$html           .= '<th style="text-align:center;" width="3.5%">บุรุษ</th>';
$html           .= '<th style="text-align:center;" width="3.5%">สตรี</th>';
$html           .= '<th style="text-align:center;" width="3.5%">บุรุษ</th>';
$html           .= '<th style="text-align:center;" width="3.5%">สตรี</th>';
$html           .= '<th style="text-align:center;" width="3.5%">บุรุษ</th>';
$html           .= '<th style="text-align:center;" width="3.5%">สตรี</th>';
$html           .= '<th style="text-align:center;" width="3.5%">บุรุษ</th>';
$html           .= '<th style="text-align:center;" width="3.5%">สตรี</th>';
$html           .= '<th style="text-align:center;" width="4%">บุรุษ</th>';
$html           .= '<th style="text-align:center;" width="4%">สตรี</th>';
$html       .= '</tr>';
$html   .= '</thead>';
$html   .= '<tbody>';
$html       .= '<tr>';
$html           .= '<th style="text-align:center;" width="4%">1</th>';
$html           .= '<th style="text-align:left;" width="17%">' . $unit_name['NPRT_NAME'] . '</th>';

$html           .= '<th style="text-align:center;" width="3.5%">' . $thcMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $thcWomen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $thmMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $thmWomen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $tcMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $tcWomen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $tmMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $tmWomen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $jcMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $jcWomen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $jmMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $jmWomen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $bcMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $bcWomen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $bmMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $bmWomen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $rtcMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $rtcWomen . '</th>';

$html           .= '<th style="text-align:center;" width="4%">' . $countMen . '</th>';
$html           .= '<th style="text-align:center;" width="4%">' . $countWomen . '</th>';
$html           .= '<th style="text-align:center;" width="8%"></th>';
$html       .= '</tr>';
$html       .= '<tr>';
$html           .= '<th style="text-align:center;" width="4%"></th>';
$html           .= '<th style="text-align:center;" width="17%">รวม</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $thcMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $thcWomen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $thmMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $thmWomen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $tcMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $tcWomen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $tmMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $tmWomen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $jcMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $jcWomen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $jmMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $jmWomen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $bcMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $bcWomen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $bmMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $bmWomen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $rtcMen . '</th>';
$html           .= '<th style="text-align:center;" width="3.5%">' . $rtcWomen . '</th>';

$html           .= '<th style="text-align:center;" width="4%">' . $countMen . '</th>';
$html           .= '<th style="text-align:center;" width="4%">' . $countWomen . '</th>';
$html           .= '<th style="text-align:center;" width="8%"></th>';
$html       .= '</tr>';
$html   .= '</tbody>';
$html .= '</table>';

// echo $html;
$pdf->writeHTML($html, true, 0, true, 0);
$pdf->writeHTMLCell(95, 0, 200, '', 'รับรองถูกต้อง', 0, 1, 0, true, 'C', true);
$pdf->writeHTMLCell(95, 0, 200, '', "(ลงชื่อ) {$p1_rank}", 0, 1, 0, true, 'L', true);
$pdf->writeHTMLCell(95, 0, 200, '', "( {$p1_name} )", 0, 1, 0, true, 'C', true);
$pdf->writeHTMLCell(95, 0, 200, '', "ตำแหน่ง {$p1_position}", 0, 1, 0, true, 'L', true);
$pdf->Output('A.pdf', 'I');
