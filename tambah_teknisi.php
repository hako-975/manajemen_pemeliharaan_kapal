<?php
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_user = $_SESSION['id_user'];
    $dataUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

    $jenis_perawatan = mysqli_query($conn, "SELECT * FROM jenis_perawatan");

    if (isset($_POST['btnSimpan'])) {
        $nama_teknisi = $_POST['nama'];
        $jabatan = $_POST['jabatan'];
        $id_jenis_perawatan = $_POST['id_jenis_perawatan'];
    
        $query = "INSERT INTO teknisi VALUES ('', '$nama_teknisi', '$jabatan', '$id_jenis_perawatan')";
        $tambah_teknisi = mysqli_query($conn, $query);
    
        if ($tambah_teknisi) {
            echo "
                <script>
                    alert('Teknisi Kapal berhasil ditambahkan!');
                    window.location.href='teknisi.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Teknisi Kapal gagal ditambahkan: " . mysqli_error($conn) . "');
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
    <title>Tambah Teknisi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'top-side-bar.php'; ?> 
    <div class="main">
        <h1>Tambah Teknisi</h1>
        <form method="post" class="form-admin">
            <div class="form-group">
                <label for="id_jenis_perawatan">Jenis Perawatan</label>
                <select name="id_jenis_perawatan" id="id_jenis_perawatan" required class="form-select">
                    <option value="0">--- Jenis Perawatan ---</option>
                    <?php foreach ($jenis_perawatan as $data_jenis_perawatan): ?>
                        <option value="<?= $data_jenis_perawatan['id_jenis_perawatan']; ?>"><?= $data_jenis_perawatan['jenis_perawatan']; ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="input" required>
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" class="input" required>
            </div>
            <button type="submit" class="btn" name="btnSimpan">Simpan</button>
        </form>
    </div>
</body>

</html>