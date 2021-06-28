<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

$headData = [
    'ลำดับ', 'สังกัด', 'หน่วย', 'เลขประจำตัว', 'เลข 13 หลัก', 'ยศ ชื่อ สกุล',
    'สังกัดการแต่งกาย', 'ยศปัจจุบัน', 'ชื่อ', 'สกุล', 'เพศ', 'ว/ด/ป/เกิด', 'เงินเดือน', 'เครื่องราชฯปัจจุบันที่ได้รับ',
    'ตำแหน่งในปีที่ได้เครื่องราช ฯ', 'ปีที่ได้รับ', 'ตำแหน่งปัจจุบันที่เสนอขอเครื่องราชฯ ประจำปี 2564', 'เครื่องราชฯที่เสนอขอปี 2564'
];

$cell = array_map(function ($r, $in) {
    $c[0] = $in + 1;
    $c[1] = $r['UNIT'];
    $c[2] = $r['BIOG_UNITNAME'];
    $c[3] = $r['BIOG_ID'];
    $c[4] = $r['BIOG_IDP'];
    $c[5] = $r['BIOG_NAME'];
    $c[6] = $r['CDEP'];
    $c[7] = $r['RANK'];
    $c[8] = $r['FNAME'];
    $c[9] = $r['LNAME'];
    $c[10] = $r['SEX'];
    $c[11] = $r['BIOG_DMY_BORN'];
    $c[12] = $r['BIOG_SALARY'];
    $c[13] = $r['BIOG_DEC'];
    $c[14] = $r['POSNAME_PRV'];
    $c[15] = $r['BIOG_DECY'];
    $c[16] = $r['BIOG_POSNAME_FULL'];
    $c[17] = $r['BDEC_COIN_NXT'];
    return $c;
}, $persons, array_keys($persons));

$data = array();
array_push($data, $headData);
$AllData = array_merge($data, $cell);
$totalRow = count($AllData);
// var_dump($AllData);

// OLD ***********************************
// $spreadsheet = new Spreadsheet();
// $sheet = $spreadsheet->getActiveSheet();
// $sheet->fromArray($AllData, null);
// $writer = new Xlsx($spreadsheet);
// $writer->save('assets/hello world.xlsx');
// END OLD *******************************

$fileName = 'ข้อมูลบัญชีเครื่องราชฯ.xlsx';
$range = "A1:R{$totalRow}";
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->fromArray($AllData, null);
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
$writer->save('php://output');
