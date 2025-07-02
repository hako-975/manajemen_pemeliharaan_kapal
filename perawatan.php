<?php
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $link = mysqli_query($conn, "SELECT * FROM jenis_perawatan");

    if (!isset($_GET['id_jenis_perawatan'])) {
        $row = mysqli_fetch_assoc($link);
        $id_jenis_perawatan = $row['id_jenis_perawatan'];
        header('Location: perawatan.php?id_jenis_perawatan=' . $id_jenis_perawatan);
        exit;
    } else {
        $id_jenis_perawatan = $_GET['id_jenis_perawatan'];
    }

    $jenis_perawatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM jenis_perawatan WHERE id_jenis_perawatan = '$id_jenis_perawatan'"));

    $id_user = $_SESSION['id_user'];
    $dataUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

    $perawatan = mysqli_query($conn, "SELECT * FROM perawatan INNER JOIN kapal ON perawatan.id_kapal = kapal.id_kapal INNER JOIN kru ON perawatan.id_kru = kru.id_kru INNER JOIN jenis_perawatan ON perawatan.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan WHERE perawatan.id_jenis_perawatan = '$id_jenis_perawatan' ORDER BY tanggal_perawatan ASC");

    if (isset($_POST['btnCari'])) {
        $cari = $_POST['cari'];
        $perawatan = mysqli_query($conn, "SELECT * FROM perawatan WHERE perawatan LIKE '%$cari%' OR nama LIKE '%$cari%' OR jabatan LIKE '%$cari%'  ORDER BY nama ASC");
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="foto/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perawatan Kapal - <?= $jenis_perawatan['jenis_perawatan']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
  <?php include 'top-side-bar.php'; ?>
    <div class="main">
        <h1>Perawatan Kapal - <?= $jenis_perawatan['jenis_perawatan']; ?></h1>
        <?php if ($dataUser['role'] != 'Administrator'): ?>
            <a href="tambah_perawatan.php?id_jenis_perawatan=<?= $id_jenis_perawatan; ?>" class="btn">Tambah perawatan</a>
        <?php endif ?>
        <br>
        <br>
        <form method="post" style="display: flex; flex-direction: row; width: 50%;">
            <input type="text" id="cari" name="cari" class="input" required>
            <button type="submit" name="btnCari" class="btn">Cari</button>
            <a href="perawatan.php" class="btn" style="margin-left: 10px;">Reset</a>
        </form>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal Perawatan</th>
                    <th>Nama Kapal</th>
                    <th>Nama Teknisi</th>
                    <th>Status</th>
                    <th>Catatan Revisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($perawatan as $data_perawatan) : ?>
                    <tr>
                        <td><?= $i++; ?>.</td>
                        <td><?= date('d-m-Y H:i', strtotime($data_perawatan['tanggal_perawatan'])); ?></td>
                        <td><?= $data_perawatan['nama_kapal']; ?></td>
                        <td><?= $data_perawatan['nama']; ?></td>
                        <td>
                            <?php if ($data_perawatan['status'] == 'Sudah'): ?>
                                <span class="p-2 rounded text-white bg-success">Sudah</span>
                            <?php elseif ($data_perawatan['status'] == 'Perlu Direvisi'): ?>
                                <span class="p-2 rounded text-white bg-warning">Perlu Direvisi</span>
                            <?php elseif ($data_perawatan['status'] == 'Belum Dibaca'): ?>
                                <span class="p-2 rounded text-white bg-danger">Belum Dibaca</span>
                            <?php endif ?>
                        </td>
                        <td><?= $data_perawatan['catatan_revisi']; ?></td>
                        <td>
                            <a href="detail_perawatan.php?id_perawatan=<?= $data_perawatan['id_perawatan']; ?>" class="btn bg-primary margin-5px">Detail</a>
                            <!-- <?php if ($dataUser['role'] != 'Administrator'): ?>
                                <a href="ubah_perawatan.php?id_perawatan=<?= $data_perawatan['id_perawatan']; ?>&id_jenis_perawatan=<?= $id_jenis_perawatan; ?>" class="btn margin-5px">Ubah</a>
                            <?php endif ?> -->
                            <a onclick="return confirm('Apakah Anda yakin ingin menghapus perawatan?')" href="hapus_perawatan.php?id_perawatan=<?= $data_perawatan['id_perawatan']; ?>&id_jenis_perawatan=<?= $id_jenis_perawatan; ?>" class="btn margin-5px bg-red">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
  </body>
</html>