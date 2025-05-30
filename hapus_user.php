<?php 
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_user = $_GET['id_user'];

    $data_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));
    $nama_lengkap = $data_user['nama_lengkap'];

    $delete_user = mysqli_query($conn, "DELETE FROM user WHERE id_user = '$id_user'");

	if ($delete_user) {
	    echo "
	        <script>
	            alert('User " . $nama_lengkap . " berhasil dihapus!');
	            window.location.href = 'user.php';
	        </script>
	    ";
	    exit;
	} else {
	    echo "
	        <script>
	            alert('User " . $nama_lengkap . " gagal dihapus!');
	            window.location.href = 'user.php';
	        </script>
	    ";
	    exit;
	}
 ?>