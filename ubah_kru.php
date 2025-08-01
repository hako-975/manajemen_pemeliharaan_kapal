<?php
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_user = $_SESSION['id_user'];
    $dataUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

    $id_kru = $_GET['id_kru'];
    $data_kru = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kru INNER JOIN jenis_perawatan ON kru.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan INNER JOIN user ON kru.id_user = user.id_user WHERE id_kru = '$id_kru'"));
    $user = mysqli_query($conn, "SELECT * FROM user");

    $jenis_perawatan = mysqli_query($conn, "SELECT * FROM jenis_perawatan");

    if (isset($_POST['btnSimpan'])) {
        $id_jenis_perawatan = $_POST['id_jenis_perawatan'];
        $id_user = $_POST['id_user'];
        $nama_kru = $_POST['nama'];
        $jabatan = $_POST['jabatan'];
    
        $query = "UPDATE kru SET id_user = '$id_user', id_jenis_perawatan = '$id_jenis_perawatan', nama = '$nama_kru', jabatan = '$jabatan' WHERE id_kru = '$id_kru'";
        $ubah_kru = mysqli_query($conn, $query);
    
        if ($ubah_kru) {
            echo "
                <script>
                    alert('kru Kapal berhasil diubah!');
                    window.location.href='kru.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('kru Kapal gagal diubah: " . mysqli_error($conn) . "');
                    window.history.back();
                </script>
            ";
        }
        exit;
    }
    
?>

<html>

<head>
    <link rel="icon" href="foto/logo.png">
    <title>Ubah Teknisi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'top-side-bar.php'; ?> 
    <div class="main">
        <h1>Ubah Teknisi</h1>
        <form method="post" class="form-admin">
            <div class="form-group">
                <label for="id_jenis_perawatan">Jenis Perawatan</label>
                <select name="id_jenis_perawatan" id="id_jenis_perawatan" required class="form-select">
                    <option value="<?= $data_kru['id_jenis_perawatan']; ?>"><?= $data_kru['jenis_perawatan']; ?></option>
                    <?php foreach ($jenis_perawatan as $data_jenis_perawatan): ?>
                        <?php if ($data_jenis_perawatan['id_jenis_perawatan'] != $data_kru['id_jenis_perawatan']): ?>
                            <option value="<?= $data_jenis_perawatan['id_jenis_perawatan']; ?>"><?= $data_jenis_perawatan['jenis_perawatan']; ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="input" value="<?= $data_kru['nama']; ?>" required>
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" class="input" value="<?= $data_kru['jabatan']; ?>" required>
            </div>
            <div class="form-group">
                <label for="id_user">Username</label>
                <select name="id_user" id="id_user" required class="form-select">
                    <option value="<?= $data_kru['id_user']; ?>"><?= $data_kru['username']; ?></option>
                    <?php foreach ($user as $du): ?>
                        <?php if ($data_kru['id_user'] != $du['id_user']): ?>
                            <option value="<?= $du['id_user']; ?>"><?= $du['username']; ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
            <button type="submit" class="btn" name="btnSimpan">Simpan</button>
        </form>
    </div>
</body>

</html>