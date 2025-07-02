<?php
header('Content-Type: application/json');
require 'koneksi.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Data tidak valid', 'redirect' => '']);
    exit;
}

$id = intval($data['id'] ?? 0);
$field = $data['field'] ?? '';
$value = $data['value'] ?? '';
$id_perawatan = intval($data['id_perawatan'] ?? 0);

// Cegah field tak sah
$allowed_fields = ['catatan_kondisi', 'nama_kru'];
if (!in_array($field, $allowed_fields) || $id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Data tidak sah', 'redirect' => '']);
    exit;
}

$value_safe = mysqli_real_escape_string($conn, $value);
$query = "UPDATE detail_perawatan SET `$field` = '$value_safe' WHERE id_detail_perawatan = $id";
$result = mysqli_query($conn, $query);

$tanggal_sekarang = date('Y-m-d H:i:s');
$query = mysqli_query($conn, "UPDATE detail_perawatan SET tanggal_cek_kondisi = '$tanggal_sekarang' WHERE id_detail_perawatan = '$id'");


if ($result) {
    echo json_encode([
        'success' => true,
        'message' => 'Data berhasil diperbarui!',
        'redirect' => $id_perawatan ? 'detail_perawatan.php?id_perawatan=' . $id_perawatan : ''
    ]);
} else {
    http_response_code(500); // Server error
    echo json_encode([
        'success' => false,
        'message' => 'Gagal update database: ' . mysqli_error($conn),
        'redirect' => $id_perawatan ? 'detail_perawatan.php?id_perawatan=' . $id_perawatan : ''
    ]);
}
exit;
