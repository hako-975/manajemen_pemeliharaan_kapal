<?php 
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_teknisi = $_GET['id_teknisi'];

    $data_teknisi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM teknisi WHERE id_teknisi = '$id_teknisi'"));
    $nama = $data_teknisi['nama'];

    $delete_teknisi = mysqli_query($conn, "DELETE FROM teknisi WHERE id_teknisi = '$id_teknisi'");

	if ($delete_teknisi) {
	    echo "
	        <script>
	            alert('Teknisi " . $nama . " berhasil dihapus!');
	            window.location.href = 'teknisi.php';
	        </script>
	    ";
	    exit;
	} else {
	    echo "
	        <script>
	            alert('Teknisi " . $nama . " gagal dihapus!');
	            window.location.href = 'teknisi.php';
	        </script>
	    ";
	    exit;
	}
 ?>