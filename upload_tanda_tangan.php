<?php
require 'koneksi.php';

header('Content-Type: application/json');

$image_data = $_POST['image_data'] ?? '';
$id_detail = $_POST['id_detail_perawatan'] ?? '';
$id_perawatan = $_POST['id_perawatan'] ?? '';

if (!$image_data || !$id_detail) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}

$folder = 'foto/tanda_tangan/';
if (!is_dir($folder)) mkdir($folder, 0777, true);

$img = str_replace('data:image/png;base64,', '', $image_data);
$img = str_replace(' ', '+', $img);
$filename = 'ttg_' . uniqid() . '.png';
$file_path = $folder . $filename;

if (file_put_contents($file_path, base64_decode($img))) {
    $filename_db = mysqli_real_escape_string($conn, $filename);
    $id_detail = mysqli_real_escape_string($conn, $id_detail);
    $query = "UPDATE detail_perawatan SET tanda_tangan = '$filename_db' WHERE id_detail_perawatan = '$id_detail'";
    if (mysqli_query($conn, $query)) {
        echo json_encode([
            'success' => true,
            'message' => 'Tanda tangan berhasil disimpan!',
            'redirect' => 'detail_perawatan.php?id_perawatan=' . $id_perawatan
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan ke database']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan gambar']);
}