<?php 
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_perawatan = $_GET['id_perawatan'];
    $id_jenis_perawatan = $_GET['id_jenis_perawatan'];

    $data_perawatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM perawatan WHERE id_perawatan = '$id_perawatan'"));

    $delete_perawatan = mysqli_query($conn, "DELETE FROM perawatan WHERE id_perawatan = '$id_perawatan'");

	if ($delete_perawatan) {
	    echo "
	        <script>
	            alert('perawatan berhasil dihapus!');
	            window.location.href = 'perawatan.php?id_jenis_perawatan=$id_jenis_perawatan';
	        </script>
	    ";
	    exit;
	} else {
	    echo "
	        <script>
	            alert('perawatan gagal dihapus!');
	            window.location.href = 'perawatan.php?id_jenis_perawatan=$id_jenis_perawatan';
	        </script>
	    ";
	    exit;
	}
 ?>