<?php
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_user = $_SESSION['id_user'];
    $data_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

    if (!isset($_GET['id_jenis_perawatan'])) {
        header("Location: perawatan.php");
        exit;
    }

    $id_jenis_perawatan = $_GET['id_jenis_perawatan'];
    $jenis_perawatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM jenis_perawatan WHERE id_jenis_perawatan = '$id_jenis_perawatan'"));


    $kapal = mysqli_query($conn, "SELECT * FROM kapal ORDER BY nama_kapal ASC");
    $teknisi = mysqli_query($conn, "SELECT * FROM teknisi INNER JOIN jenis_perawatan ON teknisi.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan WHERE teknisi.id_jenis_perawatan = '$id_jenis_perawatan' ORDER BY nama ASC");

    if (isset($_POST['btnSimpan'])) {
        $id_kapal = $_POST['id_kapal'];
        $id_teknisi = $_POST['id_teknisi'];
        if ($id_kapal == '0') {
            echo "
                <script>
                    alert('Kapal harus dipilih!');
                    window.history.back()
                </script>
            ";
            exit;
        }

        if ($id_teknisi == '0') {
            echo "
                <script>
                    alert('Teknisi harus dipilih!');
                    window.history.back()
                </script>
            ";
            exit;
        }

        $tanggal_sekarang = date('Y-m-d H:i:s');

        $query = "INSERT INTO perawatan VALUES ('', '$id_kapal', '$id_teknisi', '$id_jenis_perawatan', '$tanggal_sekarang', 'Belum')";
        $tambah_perawatan = mysqli_query($conn, $query);
        if ($tambah_perawatan) {
            $id_perawatan = mysqli_insert_id($conn);

            $kondisi = mysqli_query($conn, "SELECT * FROM kondisi WHERE id_jenis_perawatan = '$id_jenis_perawatan'");
            while ($data_kondisi = mysqli_fetch_assoc($kondisi)) {
                $id_kondisi = $data_kondisi['id_kondisi'];
                mysqli_query($conn, "INSERT INTO detail_perawatan VALUES ('', '$id_perawatan', '$id_kondisi', '', '', 'Belum', NULL, '')");
            }

            // Redirect setelah semua selesai
            header("Location: detail_perawatan.php?id_perawatan=$id_perawatan");
            exit;
        } else {
            echo "
                <script>
                    alert('Perawatan Kapal gagal ditambahkan: " . mysqli_error($conn) . "');
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
    <title>Tambah Perawatan - <?= $jenis_perawatan['jenis_perawatan']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'top-side-bar.php'; ?> 
    <div class="main">
        <h1>Tambah Perawatan - <?= $jenis_perawatan['jenis_perawatan']; ?></h1>
        <form method="post" class="form-admin">
            <div class="form-group">
                <label for="id_kapal">Nama Kapal</label>
                <select name="id_kapal" id="id_kapal" required class="form-select">
                    <option value="0">--- Pilih Kapal ---</option>
                    <?php foreach ($kapal as $data_kapal): ?>
                        <option value="<?= $data_kapal['id_kapal']; ?>"><?= $data_kapal['nama_kapal']; ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_teknisi">Nama Teknisi</label>
                <select name="id_teknisi" id="id_teknisi" required class="form-select">
                    <option value="0">--- Pilih Teknisi ---</option>
                    <?php foreach ($teknisi as $data_teknisi): ?>
                        <option value="<?= $data_teknisi['id_teknisi']; ?>"><?= $data_teknisi['jenis_perawatan']; ?> - <?= $data_teknisi['nama']; ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <button type="submit" class="btn" name="btnSimpan">Simpan</button>
        </form>
    </div>
</body>

</html>