<?php
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_user = $_SESSION['id_user'];
    $dataUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

    $jenis_perawatan = mysqli_query($conn, "SELECT * FROM jenis_perawatan");

    $id_kondisi = $_GET['id_kondisi'];
    $data_kondisi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kondisi INNER JOIN jenis_perawatan ON kondisi.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan WHERE id_kondisi = '$id_kondisi'"));

    if (isset($_POST['btnSimpan'])) {
        $kondisi = $_POST['kondisi'];
        $id_jenis_perawatan = $_POST['id_jenis_perawatan'];
        if ($id_jenis_perawatan == '0') {
            echo "
                <script>
                    alert('Jenis Perawatan harus dipilih!');
                    window.history.back()
                </script>
            ";
            exit;
        }

        $query = "UPDATE kondisi SET kondisi = '$kondisi', id_jenis_perawatan = '$id_jenis_perawatan' WHERE id_kondisi = '$id_kondisi'";
        $tambah_kondisi = mysqli_query($conn, $query);
    
        if ($tambah_kondisi) {
            echo "
                <script>
                    alert('kondisi Kapal berhasil diubah!');
                    window.location.href='kondisi.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('kondisi Kapal gagal diubah: " . mysqli_error($conn) . "');
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
    <title>Ubah Kondisi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'top-side-bar.php'; ?> 
    <div class="main">
        <h1>Ubah Kondisi</h1>
        <form method="post" class="form-admin">
            <div class="form-group">
                <label for="kondisi">kondisi Kapal</label>
                <textarea id="kondisi" name="kondisi" class="form-control" required><?= $data_kondisi['kondisi']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="id_jenis_perawatan">Jenis Perawatan</label>
                <select name="id_jenis_perawatan" id="id_jenis_perawatan" required class="form-select">
                    <option value="<?= $data_kondisi['id_jenis_perawatan']; ?>"><?= $data_kondisi['jenis_perawatan']; ?></option>
                    <?php foreach ($jenis_perawatan as $data_jenis_perawatan): ?>
                        <?php if ($data_kondisi['id_jenis_perawatan'] != $data_jenis_perawatan['id_jenis_perawatan']): ?>
                            <option value="<?= $data_jenis_perawatan['id_jenis_perawatan']; ?>"><?= $data_jenis_perawatan['jenis_perawatan']; ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
            <button type="submit" class="btn" name="btnSimpan">Simpan</button>
        </form>
    </div>
</body>

</html>