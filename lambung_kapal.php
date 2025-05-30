<?php
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_user = $_SESSION['id_user'];
    $dataUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

    $lambung = mysqli_query($conn, "SELECT * FROM laporan_lambung ORDER BY bulan_laporan ASC");

    if (isset($_GET['id_lambung'])) {
        $id_lambung = $_GET['id_lambung'];
        $data_siswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM laporan_lambung WHERE id_lambung = '$id_lambung'"));

    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="foto/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pelaporan Kapal Kargo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
  <?php include 'top-side-bar.php'; ?>
    <div class="main">
    <h1>Draft Laporan</h1>
    <a href="tambah_lambungkapal.php" class="btn"> + Laporan</a>
    <br>
        <br>
        <form method="post" style="display: flex; flex-direction: row; width: 50%;">
            <input type="text" id="cari" name="cari" class="input" required>
            <button type="submit" name="btnCari" class="btn">Cari</button>
            <a href="jadwal.php" class="btn" style="margin-left: 10px;">Reset</a>
        </form>
        <br>
        <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Bulan Pembayaran</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Kondisi</th>
                        <th>Hasil</th>
                        <th>Catatan</th>
                        <th>Upload</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lambung as $data_lambung) : ?>
                        <tr>
                            <td><?= $data_lambung['bulan_laporan']; ?></td>
                            <?php if ($data_lambung['tgl_laporan'] == '0000-00-00 00:00:00') : ?>
                                <td>-</td>
                            <?php else: ?>
                                <td><?= date("d-m-Y, H:i", strtotime($data_lambung['tgl_laporan'])); ?></td>
                            <?php endif ?>
                            <td><?= $data_lambung['kondisi']; ?></td>
                            <?php if ($data_lambung['hasil'] == 'Belum') : ?>
                                <td><span class="bg-status-belum"><?= $data_lambung['hasil']; ?></span></td>
                            <?php else: ?>
                                <td><span class="bg-status-lunas"><?= $data_lambung['hasil']; ?></span></td>
                            <?php endif ?>
                            <td>
                                <?php if ($data_lambung['hasil'] == 'Belum' && $data_lambung['nominal_pembayaran'] == '0') : ?>

                                    <a href="bayar.php?id_pembayaran=<?= $data_lambung['id_pembayaran']; ?>&id_siswa=<?= $id_siswa; ?>" class="btn">Bayar</a>
                                <?php else: ?>
                                    <a href="ubah_bayar.php?id_pembayaran=<?= $data_lambung['id_pembayaran']; ?>&id_siswa=<?= $id_siswa; ?>" class="btn">Ubah</a>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
    </div>
  </body>
</html>