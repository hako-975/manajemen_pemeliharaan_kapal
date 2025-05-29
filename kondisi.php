<?php
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_user = $_SESSION['id_user'];
    $data_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

    $kondisi = mysqli_query($conn, "SELECT * FROM kondisi INNER JOIN jenis_perawatan ON kondisi.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan");

    if (isset($_POST['btnCari'])) {
        $cari = $_POST['cari'];
        $kondisi = mysqli_query($conn, "SELECT * FROM kondisi INNER JOIN jenis_perawatan ON kondisi.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan WHERE kondisi LIKE '%$cari%' OR kondisi LIKE '%$cari%' OR jenis_perawatan");
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="foto/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kondisi - Pelaporan Kapal Kargo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
  <?php include 'top-side-bar.php'; ?>
    <div class="main">
    <h1>Kondisi</h1>
        <a href="tambah_kondisi.php" class="btn">Tambah kondisi</a>
        <br>
        <br>
        <form method="post" style="display: flex; flex-direction: row; width: 50%;">
            <input type="text" id="cari" name="cari" class="input" required>
            <button type="submit" name="btnCari" class="btn">Cari</button>
            <a href="kondisi.php" class="btn" style="margin-left: 10px;">Reset</a>
        </form>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kondisi</th>
                    <th>Jenis Perawatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($kondisi as $data_kondisi) : ?>
                    <tr>
                        <td><?= $i++; ?>.</td>
                        <td><?= $data_kondisi['kondisi']; ?></td>
                        <td><?= $data_kondisi['jenis_perawatan']; ?></td>
                        <td>
                            <a href="ubah_kondisi.php?id_kondisi=<?= $data_kondisi['id_kondisi']; ?>" class="btn margin-5px">Ubah</a>
                            <a onclick="return confirm('Apakah Anda yakin ingin menghapus kondisi <?= $data_kondisi['kondisi']; ?>?')" href="hapus_kondisi.php?id_kondisi=<?= $data_kondisi['id_kondisi']; ?>" class="btn margin-5px bg-red">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
  </body>
</html>