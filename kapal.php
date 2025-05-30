<?php
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_user = $_SESSION['id_user'];
    $dataUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

    $kapal = mysqli_query($conn, "SELECT * FROM kapal ORDER BY nama_kapal ASC");

    if (isset($_POST['btnCari'])) {
        $cari = $_POST['cari'];
        $kapal = mysqli_query($conn, "SELECT * FROM kapal WHERE kapal LIKE '%$cari%' OR nama_kapal ORDER BY nama_kapal ASC");
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="foto/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kapal - Pelaporan Kapal Kargo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
  <?php include 'top-side-bar.php'; ?>
    <div class="main">
    <h1>Kapal</h1>
        <!-- <a href="tambah_kapal.php" class="btn">Tambah Kapal</a> -->
        <br>
        <br>
        <form method="post" style="display: flex; flex-direction: row; width: 50%;">
            <input type="text" id="cari" name="cari" class="input" required>
            <button type="submit" name="btnCari" class="btn">Cari</button>
            <a href="kapal.php" class="btn" style="margin-left: 10px;">Reset</a>
        </form>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Kapal</th>
                    <th>Foto Kapal</th>
                    <!-- <th>Aksi</th> -->
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($kapal as $data_kapal) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $data_kapal['nama_kapal']; ?></td>
                        <td><img src="foto/kapal/<?= $data_kapal['foto_kapal']; ?>" alt="<?= $data_kapal['foto_kapal']; ?>"></td>
                        <!-- <td>
                            <a href="ubah_kapal.php?id_kapal=<?= $data_kapal['id_kapal']; ?>" class="btn margin-5px">Ubah</a>
                            <a onclick="return confirm('Apakah Anda yakin ingin menghapus kapal <?= $data_kapal['nama']; ?>?')" href="hapus_kapal.php?id_kapal=<?= $data_kapal['id_kapal']; ?>" class="btn margin-5px bg-red">Hapus</a>
                        </td> -->
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
  </body>
</html>