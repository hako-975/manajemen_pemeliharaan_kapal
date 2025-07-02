<?php 
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_kru = $_GET['id_kru'];

    $data_kru = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kru WHERE id_kru = '$id_kru'"));
    $nama = $data_kru['nama'];

    $delete_kru = mysqli_query($conn, "DELETE FROM kru WHERE id_kru = '$id_kru'");

	if ($delete_kru) {
	    echo "
	        <script>
	            alert('Teknisi " . $nama . " berhasil dihapus!');
	            window.location.href = 'kru.php';
	        </script>
	    ";
	    exit;
	} else {
	    echo "
	        <script>
	            alert('Teknisi " . $nama . " gagal dihapus!');
	            window.location.href = 'kru.php';
	        </script>
	    ";
	    exit;
	}
 ?>