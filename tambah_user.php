<?php
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_user = $_SESSION['id_user'];
    $dataUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

    $jenis_perawatan = mysqli_query($conn, "SELECT * FROM jenis_perawatan");

    if (isset($_POST['btnSimpan'])) {
        $nama_lengkap = $_POST['nama_lengkap'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $ulangi_password = $_POST['ulangi_password'];
        $role = $_POST['role'];
        
        if ($password != $ulangi_password) {
            echo "
                <script>
                    alert('Password harus sama dengan ulangi password!');
                    window.history.back()
                </script>
            ";
            exit;    
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user VALUES ('', '$nama_lengkap', '$username', '$password_hash', '$role')";
        $tambah_user = mysqli_query($conn, $query);
    
        if ($tambah_user) {
            echo "
                <script>
                    alert('User berhasil ditambahkan!');
                    window.location.href='user.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('User gagal ditambahkan: " . mysqli_error($conn) . "');
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
    <title>Tambah User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'top-side-bar.php'; ?> 
    <div class="main">
        <h1>Tambah User</h1>
        <form method="post" class="form-admin">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" class="input" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="input" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="input" required>
            </div>
            <div class="form-group">
                <label for="ulangi_password">Ulangi Password</label>
                <input type="password" id="ulangi_password" name="ulangi_password" class="input" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-select">
                    <option value="Kru Lambung Kapal">Kru Lambung Kapal</option>
                    <option value="Kru Alat Navigasi Kapal">Kru Alat Navigasi Kapal</option>
                    <option value="Kru Alat Kebakaran dan Keselamatan Kapal">Kru Alat Kebakaran dan Keselamatan Kapal</option>
                </select>
            </div>
            <button type="submit" class="btn" name="btnSimpan">Simpan</button>
        </form>
    </div>
</body>

</html>