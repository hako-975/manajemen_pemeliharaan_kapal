<?php
    include 'koneksi.php';
    if (isset($_SESSION['id_user'])) {
        echo "<script>window.location='index.php'</script> ";
        exit;
    }

    if (isset($_POST['btnLogin'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query_login = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
        if ($data_user = mysqli_fetch_assoc($query_login)) {
            if (password_verify($password, $data_user['password'])) {
                $_SESSION['id_user'] = $data_user['id_user'];
                header("Location: index.php");
                exit;
            } else {
                echo "
                    <script>
                        alert('gagal username atau password salah!')
                        window.history.back()
                    </script>
                ";
                exit;
            }
        } else {
            echo "
                <script>
                    alert('gagal username atau password salah!')
                    window.history.back()
                </script>
            ";
            exit;
        }
    }
?>

<html>
<head>
    <title>Manajemen Pelayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="foto/logo.png">
    <link rel="stylesheet" href="style.css">
</head>

<body class="login" style="background-image: url('foto/background.jpg');">
    <div class="container" style="background-color: #24201f;">
        <form method="post">
            <div style="display: flex; justify-content: center; align-items: center;">
                <img src="foto/logo.png" width="300">
            </div>

            <h5>Manajemen Operasional Pemeliharaan Kapal Kargo</h5>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="input" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="input" required>
            </div>
            <button type="submit" class="btn" name="btnLogin">Login</button>
        </form>
    </div>
</body>

</html>