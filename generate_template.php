<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Template Import Data Indikator');

// Set headers
$sheet->setCellValue('A3', 'NO_INDIKATOR');
$sheet->setCellValue('B3', 'INDIKATOR_RPJMD');
$sheet->setCellValue('C3', 'TARGET_RPJMD');
$sheet->setCellValue('D3', 'DOKUMEN_DATA');
$sheet->setCellValue('E3', 'CATATAN');
$sheet->setCellValue('F3', 'TARGET_PERPRES');
$sheet->setCellValue('G3', 'TARGET_PERPRES_RINGKAS');
$sheet->setCellValue('H3', 'KEWENANGAN_KAB');
$sheet->setCellValue('I3', 'KEWENANGAN_KOTA');

$sheet->setCellValue('A4', 'NO INDIKATOR TPB (Kode Wajib)');
$sheet->setCellValue('B4', 'INDIKATOR YANG DIRENCANAKAN DALAM RPJMD');
$sheet->setCellValue('C4', 'TARGET YANG HARUS DITETAPKAN DALAM RPJMD');
$sheet->setCellValue('D4', 'DOKUMEN/DATA YANG HARUS DISIAPKAN');
$sheet->setCellValue('E4', 'CATATAN (CAPAIAN & GAP) Format: Capaian [nilai] | GAP [nilai] | Status: SS/SB/BB/NA');
$sheet->setCellValue('F4', 'TARGET (PERPRES 59/2017)');
$sheet->setCellValue('G4', 'TARGET PERPRES 59/2017 RINGKASAN');
$sheet->setCellValue('H4', 'KEWENANGAN KABUPATEN');
$sheet->setCellValue('I4', 'KEWENANGAN KOTA');

$sheet->setCellValue('A5', '▼ MULAI ISI DATA DI BAWAH BARIS INI (hapus baris contoh no.5 dan 6 sebelum upload)');
$sheet->mergeCells('A5:I5');

$writer = new Xlsx($spreadsheet);
$writer->save('public/template_import_indikator.xlsx');
echo "Template generated.\n";
