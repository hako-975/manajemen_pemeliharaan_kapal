<?php
require 'vendor/autoload.php';
include 'koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Ambil filter
$bulan = $_GET['bulan'] ?? '';
$status = $_GET['status'] ?? '';
$jenis_perawatan = $_GET['jenis_perawatan'] ?? '';

// Query utama
$query = "SELECT * FROM perawatan 
          INNER JOIN kapal ON perawatan.id_kapal = kapal.id_kapal 
          INNER JOIN teknisi ON perawatan.id_teknisi = teknisi.id_teknisi 
          INNER JOIN jenis_perawatan ON perawatan.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan 
          WHERE 1=1";

if ($bulan !== '') {
    $query .= " AND MONTH(tanggal_perawatan) = '$bulan'";
}
if ($status !== '') {
    $query .= " AND perawatan.status = '$status'";
}
if ($jenis_perawatan !== '') {
    $query .= " AND perawatan.id_jenis_perawatan = '$jenis_perawatan'";
}
$query .= " ORDER BY tanggal_perawatan ASC";

$perawatan = mysqli_query($conn, $query);

// Inisialisasi Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$rowIndex = 1;
$sheet->setCellValue("A$rowIndex", "Laporan Perawatan Kapal");
$sheet->mergeCells("A$rowIndex:F$rowIndex");
$sheet->getStyle("A$rowIndex")->getFont()->setBold(true)->setSize(16);
$rowIndex += 2;

// Set lebar kolom yang pas
$sheet->getColumnDimension('A')->setWidth(5);
$sheet->getColumnDimension('B')->setWidth(20);
$sheet->getColumnDimension('C')->setWidth(25);
$sheet->getColumnDimension('D')->setWidth(25);
$sheet->getColumnDimension('E')->setWidth(18); // kolom foto
$sheet->getColumnDimension('F')->setWidth(18); // kolom tanda tangan

// Header tabel
$headers = ['No', 'Tanggal Perawatan', 'Jenis Perawatan', 'Nama Kapal', 'Nama Teknisi', 'Status'];
$sheet->fromArray($headers, null, "A$rowIndex");
$sheet->getStyle("A$rowIndex:F$rowIndex")->getFont()->setBold(true);
$sheet->getStyle("A$rowIndex:F$rowIndex")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
$rowIndex++;

$i = 1;
foreach ($perawatan as $data) {
    $sheet->setCellValue("A$rowIndex", $i++ . '.');
    $sheet->setCellValue("B$rowIndex", date('d-m-Y H:i', strtotime($data['tanggal_perawatan'])));
    $sheet->setCellValue("C$rowIndex", $data['jenis_perawatan']);
    $sheet->setCellValue("D$rowIndex", $data['nama_kapal']);
    $sheet->setCellValue("E$rowIndex", $data['nama']);

    // Warnai status
    $sheet->setCellValue("F$rowIndex", $data['status']);
    $color = $data['status'] === 'Sudah' ? '90EE90' : 'FFA07A'; // lightgreen / salmon
    $sheet->getStyle("F$rowIndex")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($color);

    // Border baris utama
    $sheet->getStyle("A$rowIndex:F$rowIndex")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    $rowIndex++;

    // Sub header detail
    $sheet->setCellValue("A$rowIndex", "Detail Perawatan:");
    $sheet->getStyle("A$rowIndex")->getFont()->setBold(true);
    $sheet->getStyle("A$rowIndex:F$rowIndex")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->mergeCells("A$rowIndex:F$rowIndex");
    $rowIndex++;

    $detailHeaders = ['Kode', 'Tanggal Cek', 'Catatan', 'Status', 'Foto', 'Tanda Tangan'];
    $sheet->fromArray($detailHeaders, null, "A$rowIndex");
    $sheet->getStyle("A$rowIndex:F$rowIndex")->getFont()->setBold(true);
    $sheet->getStyle("A$rowIndex:F$rowIndex")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $rowIndex++;

    $abjad = range('a', 'z');
    $j = 0;
    $id_perawatan = $data['id_perawatan'];
    $details = mysqli_query($conn, "SELECT * FROM detail_perawatan 
        INNER JOIN kondisi ON detail_perawatan.id_kondisi = kondisi.id_kondisi 
        WHERE id_perawatan = '$id_perawatan'");

    foreach ($details as $d) {
        $sheet->setCellValue("A$rowIndex", $abjad[$j++] . '.');
        $sheet->setCellValue("B$rowIndex", $d['tanggal_cek_kondisi'] === '0000-00-00 00:00:00' ? 'Belum dicek' : $d['tanggal_cek_kondisi']);
        $sheet->setCellValue("C$rowIndex", $d['catatan_kondisi']);
        $sheet->setCellValue("D$rowIndex", $d['status_kondisi']);

        // Set tinggi baris supaya cukup untuk gambar
        $sheet->getRowDimension($rowIndex)->setRowHeight(70);

        // Gambar Foto Kondisi
        if (!empty($d['foto_kondisi']) && file_exists("foto/detail_perawatan/" . $d['foto_kondisi'])) {
            $drawing = new Drawing();
            $drawing->setPath("foto/detail_perawatan/" . $d['foto_kondisi']);
            $drawing->setCoordinates("E$rowIndex");
            $drawing->setHeight(60);
            $drawing->setOffsetX(10);
            $drawing->setOffsetY(5);
            $drawing->setWorksheet($sheet);
        } else {
            $sheet->setCellValue("E$rowIndex", "Belum ada");
            $sheet->getStyle("E$rowIndex")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        // Gambar Tanda Tangan
        if (!empty($d['tanda_tangan']) && file_exists("foto/tanda_tangan/" . $d['tanda_tangan'])) {
            $drawing2 = new Drawing();
            $drawing2->setPath("foto/tanda_tangan/" . $d['tanda_tangan']);
            $drawing2->setCoordinates("F$rowIndex");
            $drawing2->setHeight(60);
            $drawing2->setOffsetX(10);
            $drawing2->setOffsetY(5);
            $drawing2->setWorksheet($sheet);
        } else {
            $sheet->setCellValue("F$rowIndex", "Belum ada");
            $sheet->getStyle("F$rowIndex")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        // Border tiap kolom
        $sheet->getStyle("A$rowIndex:F$rowIndex")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $rowIndex++;
    }

    $rowIndex++; // Jeda antar perawatan
}

// Auto size kolom lain (kecuali E dan F sudah kita set)
foreach (['A','B','C','D'] as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Outputkan file Excel
$filename = 'Laporan_Perawatan_Kapal_' . date('YmdHis') . '.xlsx';
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"$filename\"");
header("Cache-Control: max-age=0");

$writer = new Xlsx($spreadsheet);
$writer->save("php://output");
exit;
