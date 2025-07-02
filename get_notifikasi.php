<?php
include 'koneksi.php';
header('Content-Type: application/json');
$id_user = $_SESSION['id_user'];
$dataUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));
if ($dataUser['role'] != 'Administrator') {
    $id_role_jenis_perawatan = '0';
    if ($dataUser['role'] == 'Kru Lambung Kapal') {
        $id_role_jenis_perawatan = '1';
    } elseif ($dataUser['role'] == 'Kru Alat Navigasi Kapal') {
        $id_role_jenis_perawatan = '2';
    } elseif ($dataUser['role'] == 'Kru Alat Kebakaran dan Keselamatan Kapal') {
        $id_role_jenis_perawatan = '3';
    }
    
    $query = "SELECT * FROM perawatan INNER JOIN jenis_perawatan ON perawatan.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan WHERE status = 'Perlu Direvisi' AND perawatan.id_jenis_perawatan = '$id_role_jenis_perawatan' ORDER BY id_perawatan DESC LIMIT 10";
} else {
    $query = "SELECT * FROM perawatan INNER JOIN jenis_perawatan ON perawatan.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan WHERE status = 'Perlu Direvisi' ORDER BY id_perawatan DESC LIMIT 10";
}
$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'id_perawatan' => $row['id_perawatan'],
        'jenis_perawatan' => $row['jenis_perawatan'],
        'tanggal_perawatan' => date('d-m-Y H:i', strtotime($row['tanggal_perawatan']))
    ];
}

echo json_encode([
    'jumlah' => count($data),
    'data' => $data
]);

mysqli_close($conn);
?>
