<?php 
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_kondisi = $_GET['id_kondisi'];

    $data_kondisi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kondisi WHERE id_kondisi = '$id_kondisi'"));
    $nama = $data_kondisi['nama'];

    $delete_kondisi = mysqli_query($conn, "DELETE FROM kondisi WHERE id_kondisi = '$id_kondisi'");

	if ($delete_kondisi) {
	    echo "
	        <script>
	            alert('Kondisi " . $nama . " berhasil dihapus!');
	            window.location.href = 'kondisi.php';
	        </script>
	    ";
	    exit;
	} else {
	    echo "
	        <script>
	            alert('Kondisi " . $nama . " gagal dihapus!');
	            window.location.href = 'kondisi.php';
	        </script>
	    ";
	    exit;
	}
 ?>