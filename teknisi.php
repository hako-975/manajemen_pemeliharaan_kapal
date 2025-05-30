<?php
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_user = $_SESSION['id_user'];
    $dataUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

    $teknisi = mysqli_query($conn, "SELECT * FROM teknisi INNER JOIN jenis_perawatan ON teknisi.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan ORDER BY nama ASC");

    if (isset($_POST['btnCari'])) {
        $cari = $_POST['cari'];
        $teknisi = mysqli_query($conn, "SELECT * FROM teknisi INNER JOIN jenis_perawatan ON teknisi.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan WHERE teknisi LIKE '%$cari%' OR nama LIKE '%$cari%' OR jabatan LIKE '%$cari%'  ORDER BY nama ASC");
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="foto/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teknisi - Pelaporan Kapal Kargo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
  <?php include 'top-side-bar.php'; ?>
    <div class="main">
    <h1>Teknisi</h1>
        <a href="tambah_teknisi.php" class="btn">Tambah teknisi</a>
        <br>
        <br>
        <form method="post" style="display: flex; flex-direction: row; width: 50%;">
            <input type="text" id="cari" name="cari" class="input" required>
            <button type="submit" name="btnCari" class="btn">Cari</button>
            <a href="teknisi.php" class="btn" style="margin-left: 10px;">Reset</a>
        </form>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Teknisi</th>
                    <th>Nama Lengkap</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($teknisi as $data_teknisi) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $data_teknisi['jenis_perawatan']; ?></td>
                        <td><?= $data_teknisi['nama']; ?></td>
                        <td><?= $data_teknisi['jabatan']; ?></td>
                        <td>
                            <a href="ubah_teknisi.php?id_teknisi=<?= $data_teknisi['id_teknisi']; ?>" class="btn margin-5px">Ubah</a>
                            <a onclick="return confirm('Apakah Anda yakin ingin menghapus teknisi <?= $data_teknisi['nama']; ?>?')" href="hapus_teknisi.php?id_teknisi=<?= $data_teknisi['id_teknisi']; ?>" class="btn margin-5px bg-red">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
  </body>
</html>