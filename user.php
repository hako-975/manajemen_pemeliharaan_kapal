<?php
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_user = $_SESSION['id_user'];
    $dataUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

    $user = mysqli_query($conn, "SELECT * FROM user ORDER BY role ASC, nama_lengkap ASC");

    if (isset($_POST['btnCari'])) {
        $cari = $_POST['cari'];
        $user = mysqli_query($conn, "SELECT * FROM user WHERE user LIKE '%$cari%' OR nama_lengkap LIKE '%$cari%' OR role LIKE '%$cari%' ORDER BY role ASC, nama_lengkap ASC");
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="foto/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User - Pelaporan Kapal Kargo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
  <?php include 'top-side-bar.php'; ?>
    <div class="main">
    <h1>User</h1>
        <a href="tambah_user.php" class="btn">Tambah User</a>
        <br>
        <br>
        <form method="post" style="display: flex; flex-direction: row; width: 50%;">
            <input type="text" id="cari" name="cari" class="input" required>
            <button type="submit" name="btnCari" class="btn">Cari</button>
            <a href="user.php" class="btn" style="margin-left: 10px;">Reset</a>
        </form>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($user as $data_user) : ?>
                    <tr>
                        <td><?= $i++; ?>.</td>
                        <td><?= $data_user['nama_lengkap']; ?></td>
                        <td><?= $data_user['username']; ?></td>
                        <td><?= $data_user['role']; ?></td>
                        <td>
                            <a href="ubah_user.php?id_user=<?= $data_user['id_user']; ?>" class="btn margin-5px">Ubah</a>
                            <?php if ($data_user['role'] != 'Administrator'): ?>
                                <a onclick="return confirm('Apakah Anda yakin ingin menghapus user <?= $data_user['nama_lengkap']; ?>?')" href="hapus_user.php?id_user=<?= $data_user['id_user']; ?>" class="btn margin-5px bg-red">Hapus</a>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
  </body>
</html>