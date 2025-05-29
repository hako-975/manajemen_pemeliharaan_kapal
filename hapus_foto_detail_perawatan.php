<?php 
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_detail_perawatan = $_GET['id_detail_perawatan'];
    $id_perawatan = $_GET['id_perawatan'];

    $delete_foto_detail_perawatan = mysqli_query($conn, "UPDATE detail_perawatan SET foto_kondisi = NULL WHERE id_detail_perawatan = '$id_detail_perawatan'");

	if ($delete_foto_detail_perawatan) {
	    echo "
	        <script>
	            alert('Foto Kondisi berhasil dihapus!');
	            window.location.href = 'detail_perawatan.php?id_perawatan=$id_perawatan';
	        </script>
	    ";
	    exit;
	} else {
	    echo "
	        <script>
	            alert('Foto Kondisi berhasil dihapus!');
	            window.location.href = 'detail_perawatan.php?id_perawatan=$id_perawatan';
	        </script>
	    ";
	    exit;
	}
 ?>