<?php
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_user = $_SESSION['id_user'];
    $dataUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

    $id_perawatan = $_GET['id_perawatan'];
    $id_jenis_perawatan = $_GET['id_jenis_perawatan'];
    $data_perawatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM perawatan INNER JOIN jenis_perawatan ON perawatan.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan INNER JOIN kapal ON perawatan.id_kapal = kapal.id_kapal INNER JOIN teknisi ON perawatan.id_teknisi = teknisi.id_teknisi WHERE id_perawatan = '$id_perawatan'"));

    $kapal = mysqli_query($conn, "SELECT * FROM kapal ORDER BY nama_kapal ASC");
    $teknisi = mysqli_query($conn, "SELECT * FROM teknisi INNER JOIN jenis_perawatan ON teknisi.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan WHERE teknisi.id_jenis_perawatan = '$id_jenis_perawatan' ORDER BY nama ASC");

    $jenis_perawatan = mysqli_query($conn, "SELECT * FROM jenis_perawatan");

    if (isset($_POST['btnSimpan'])) {
        $id_kapal = $_POST['id_kapal'];
        $id_teknisi = $_POST['id_teknisi'];
    
        $query = "UPDATE perawatan SET id_kapal = '$id_kapal', id_teknisi = '$id_teknisi' WHERE id_perawatan = '$id_perawatan'";
        $ubah_perawatan = mysqli_query($conn, $query);
    
        if ($ubah_perawatan) {
            echo "
                <script>
                    alert('Perawatan Kapal berhasil diubah!');
                    window.location.href='perawatan.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Perawatan Kapal gagal diubah: " . mysqli_error($conn) . "');
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
    <title>Ubah Perawatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'top-side-bar.php'; ?> 
    <div class="main">
        <h1>Ubah Perawatan</h1>
        <form method="post" class="form-admin">
            <div class="form-group">
                <label for="id_kapal">Nama Kapal</label>
                <select name="id_kapal" id="id_kapal" required class="form-select">
                    <option value="<?= $data_perawatan['id_kapal']; ?>"><?= $data_perawatan['nama_kapal']; ?></option>
                    <?php foreach ($kapal as $data_kapal): ?>
                        <?php if ($data_kapal['id_kapal'] != $data_perawatan['id_kapal']): ?>
                            <option value="<?= $data_kapal['id_kapal']; ?>"><?= $data_kapal['nama_kapal']; ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_teknisi">Nama Teknisi</label>
                <select name="id_teknisi" id="id_teknisi" required class="form-select">
                    <option value="<?= $data_perawatan['id_teknisi']; ?>"><?= $data_perawatan['nama']; ?></option>
                    <?php foreach ($teknisi as $data_teknisi): ?>
                        <?php if ($data_teknisi['id_teknisi'] != $data_perawatan['id_teknisi']): ?>
                            <option value="<?= $data_teknisi['id_teknisi']; ?>"><?= $data_teknisi['jenis_perawatan']; ?> - <?= $data_teknisi['nama']; ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
            <button type="submit" class="btn" name="btnSimpan">Simpan</button>
        </form>
    </div>
</body>

</html>