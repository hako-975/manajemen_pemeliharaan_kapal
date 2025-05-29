<?php
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_user = $_SESSION['id_user'];
    $data_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

    $id_teknisi = $_GET['id_teknisi'];
    $data_teknisi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM teknisi INNER JOIN jenis_perawatan ON teknisi.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan WHERE id_teknisi = '$id_teknisi'"));

    $jenis_perawatan = mysqli_query($conn, "SELECT * FROM jenis_perawatan");

    if (isset($_POST['btnSimpan'])) {
        $id_jenis_perawatan = $_POST['id_jenis_perawatan'];
        $nama_teknisi = $_POST['nama'];
        $jabatan = $_POST['jabatan'];
    
        $query = "UPDATE teknisi SET id_jenis_perawatan = '$id_jenis_perawatan', nama = '$nama_teknisi', jabatan = '$jabatan' WHERE id_teknisi = '$id_teknisi'";
        $ubah_teknisi = mysqli_query($conn, $query);
    
        if ($ubah_teknisi) {
            echo "
                <script>
                    alert('teknisi Kapal berhasil diubah!');
                    window.location.href='teknisi.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('teknisi Kapal gagal diubah: " . mysqli_error($conn) . "');
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
                    <option value="<?= $data_teknisi['id_jenis_perawatan']; ?>"><?= $data_teknisi['jenis_perawatan']; ?></option>
                    <?php foreach ($jenis_perawatan as $data_jenis_perawatan): ?>
                        <?php if ($data_jenis_perawatan['id_jenis_perawatan'] != $data_teknisi['id_jenis_perawatan']): ?>
                            <option value="<?= $data_jenis_perawatan['id_jenis_perawatan']; ?>"><?= $data_jenis_perawatan['jenis_perawatan']; ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="input" value="<?= $data_teknisi['nama']; ?>" required>
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" class="input" value="<?= $data_teknisi['jabatan']; ?>" required>
            </div>
            <button type="submit" class="btn" name="btnSimpan">Simpan</button>
        </form>
    </div>
</body>

</html>