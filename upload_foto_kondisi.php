<?php 
header('Content-Type: application/json');
$response = [];

include 'koneksi.php';
if (!isset($_SESSION['id_user'])){
    echo "<script>window.location='login.php'</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto_kondisi'])) {
    $id_perawatan = $_POST['id_perawatan'];
    $id_detail_perawatan = $_POST['id_detail_perawatan'];

    $file = $_FILES['foto_kondisi'];
    $fileName = $file['name'];
    $fileTmp  = $file['tmp_name'];
    $fileError = $file['error'];

    $uploadDir = "foto/detail_perawatan/";
    $newFileName = uniqid() . "_" . basename($fileName);
    $targetPath = $uploadDir . $newFileName;

    if ($fileError === 0) {
        if (move_uploaded_file($fileTmp, $targetPath)) {
            // Update database
            $query = mysqli_query($conn, "UPDATE detail_perawatan SET foto_kondisi = '$newFileName' WHERE id_detail_perawatan = '$id_detail_perawatan'");

            if ($query) {
                $response = [
                    'success' => true,
                    'message' => 'Foto berhasil diupload dan data diperbarui!',
                    'redirect' => 'detail_perawatan.php?id_perawatan=' . $id_perawatan
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Gagal update database.',
                    'redirect' => 'detail_perawatan.php?id_perawatan=' . $id_perawatan
                ];
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'Gagal menyimpan file.',
                    'redirect' => 'detail_perawatan.php?id_perawatan=' . $id_perawatan
            ];
        }
    } else {
        $response = [
            'success' => false,
            'message' => 'Terjadi error saat upload.',
                    'redirect' => 'detail_perawatan.php?id_perawatan=' . $id_perawatan
        ];
    }

    echo json_encode($response);
    exit;
}