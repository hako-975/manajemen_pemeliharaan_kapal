<?php
require 'koneksi.php';

$id_perawatan = $_POST['id_perawatan'];
$id = $_POST['id_detail_perawatan'];
$field = $_POST['field'];
$value = $_POST['value'];

if ($value == 'Belum') {
    $tanggal_sekarang = NULL;
} else {
    $tanggal_sekarang = date('Y-m-d H:i:s');
}
$query = mysqli_query($conn, "UPDATE detail_perawatan SET $field = '$value', tanggal_cek_kondisi = '$tanggal_sekarang' WHERE id_detail_perawatan = '$id'");

if ($query) {
    echo json_encode(['success' => true, 'redirect' => $id_perawatan ? 'detail_perawatan.php?id_perawatan=' . $id_perawatan : '']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal update', 'redirect' => $id_perawatan ? 'detail_perawatan.php?id_perawatan=' . $id_perawatan : '']);
}
?>