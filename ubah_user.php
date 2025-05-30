<?php
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_user = $_SESSION['id_user'];
    $dataUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

    $id_user = $_GET['id_user'];
    $data_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

    if (isset($_POST['btnSimpan'])) {
        $username = $_POST['username'];
        $nama_lengkap = $_POST['nama_lengkap'];
    
        $query = "UPDATE user SET username = '$username', nama_lengkap = '$nama_lengkap' WHERE id_user = '$id_user'";
        $ubah_user = mysqli_query($conn, $query);
    
        if ($ubah_user) {
            echo "
                <script>
                    alert('User berhasil diubah!');
                    window.location.href='user.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('User gagal diubah: " . mysqli_error($conn) . "');
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
    <title>Ubah User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'top-side-bar.php'; ?> 
    <div class="main">
        <h1>Ubah User</h1>
        <form method="post" class="form-admin">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" class="input" value="<?= $data_user['nama_lengkap']; ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="input" value="<?= $data_user['username']; ?>" required>
            </div>
            <button type="submit" class="btn" name="btnSimpan">Simpan</button>
        </form>
    </div>
</body>

</html>