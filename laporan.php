<?php
include 'koneksi.php';
if (!isset($_SESSION['id_user'])){
    echo "<script>window.location='login.php'</script>";
}
$id_user = $_SESSION['id_user'];
$dataUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

// Ambil semua jenis perawatan untuk opsi filter
$jenis_perawatan_opsi = mysqli_query($conn, "SELECT * FROM jenis_perawatan");

$filter_bulan = $_GET['bulan'] ?? '';
$filter_status = $_GET['status'] ?? '';
$filter_jenis = $_GET['jenis_perawatan'] ?? '';

$query = "SELECT * FROM perawatan 
INNER JOIN kapal ON perawatan.id_kapal = kapal.id_kapal 
INNER JOIN teknisi ON perawatan.id_teknisi = teknisi.id_teknisi 
INNER JOIN jenis_perawatan ON perawatan.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan 
WHERE 1=1";

if ($filter_bulan != '') {
    $query .= " AND MONTH(tanggal_perawatan) = '$filter_bulan'";
}
if ($filter_status != '') {
    $query .= " AND status = '$filter_status'";
}
if ($filter_jenis != '') {
    $query .= " AND perawatan.id_jenis_perawatan = '$filter_jenis'";
}

$query .= " ORDER BY tanggal_perawatan ASC";
$perawatan = mysqli_query($conn, $query);

// Fungsi untuk nama bulan Bahasa Indonesia
function namaBulan($bulan) {
    $bulanIndo = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    return $bulanIndo[intval($bulan)];
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <link rel="icon" href="foto/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Perawatan Kapal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
<body>
<?php include 'top-side-bar.php'; ?>
<div class="main">
    <h1>Laporan Perawatan Kapal</h1>
    <form method="get" class="row justify-content-center mb-3">
        <div class="col-md-3">
            <label>Bulan</label>
            <select name="bulan" class="form-select">
                <option value="">Semua</option>
                <?php for ($b=1; $b<=12; $b++): ?>
                    <option value="<?= $b ?>" <?= ($filter_bulan == $b ? 'selected' : '') ?>><?= namaBulan($b) ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="">Semua</option>
                <option value="Sudah" <?= ($filter_status == 'Sudah' ? 'selected' : '') ?>>Sudah</option>
                <option value="Belum" <?= ($filter_status == 'Belum' ? 'selected' : '') ?>>Belum</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Jenis Perawatan</label>
            <select name="jenis_perawatan" class="form-select">
                <option value="">Semua</option>
                <?php while ($jp = mysqli_fetch_assoc($jenis_perawatan_opsi)): ?>
                    <option value="<?= $jp['id_jenis_perawatan'] ?>" <?= ($filter_jenis == $jp['id_jenis_perawatan'] ? 'selected' : '') ?>>
                        <?= $jp['jenis_perawatan'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="laporan.php" class="btn btn-primary ms-3">Reset</a>
        </div>
    </form>

    <!-- Tombol cetak -->
    <div class="mb-3">
        <a href="cetak_pdf.php?bulan=<?= $filter_bulan ?>&status=<?= $filter_status ?>&jenis_perawatan=<?= $filter_jenis ?>" target="_blank" class="btn btn-danger">Cetak PDF</a>
        <a href="cetak_excel.php?bulan=<?= $filter_bulan ?>&status=<?= $filter_status ?>&jenis_perawatan=<?= $filter_jenis ?>" class="btn btn-success">Cetak Excel</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal Perawatan</th>
                <th>Jenis Perawatan</th>
                <th>Nama Kapal</th>
                <th>Nama Teknisi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach ($perawatan as $data_perawatan): ?>
                <?php 
                    $id_perawatan = $data_perawatan['id_perawatan'];
                    $update_detail_perawatan = mysqli_query($conn, "SELECT * FROM detail_perawatan WHERE id_perawatan = '$id_perawatan' AND status_kondisi = 'Sudah' AND tanda_tangan IS NOT NULL");
                    if (mysqli_num_rows($update_detail_perawatan) > 0) {
                        mysqli_query($conn, "UPDATE perawatan SET status = 'Sudah' WHERE id_perawatan = '$id_perawatan'");
                    }
                ?>
                <tr>
                    <td><?= $i++ ?>.</td>
                    <td><?= date('d-m-Y H:i', strtotime($data_perawatan['tanggal_perawatan'])) ?></td>
                    <td><?= $data_perawatan['jenis_perawatan'] ?></td>
                    <td><?= $data_perawatan['nama_kapal'] ?></td>
                    <td><?= $data_perawatan['nama'] ?></td>
                    <td style="background-color: <?= $data_perawatan['status'] == 'Sudah' ? 'lightgreen' : 'salmon' ?>;">
                        <?= $data_perawatan['status'] ?>
                    </td>
                </tr>

                <!-- Detail -->
                <?php 
                    $detail_perawatan = mysqli_query($conn, "SELECT * FROM detail_perawatan 
                    INNER JOIN kondisi ON detail_perawatan.id_kondisi = kondisi.id_kondisi 
                    WHERE id_perawatan = '$id_perawatan'");
                ?>
                <tr><th colspan="6">Detail Cek Perawatan</th></tr>
                <tr>
                    <th>Kode</th>
                    <th>Tanggal Cek Kondisi</th>
                    <th>Catatan Kondisi</th>
                    <th>Foto Kondisi</th>
                    <th>Status Kondisi</th>
                    <th>Tanda Tangan</th>
                </tr>
                <?php 
                    $abjad = range('a', 'z');
                    $j = 0;
                ?>
                <?php foreach ($detail_perawatan as $ddp): ?>
                    <tr>
                        <td><?= $abjad[$j++] ?>.</td>
                        <td><?= ($ddp['tanggal_cek_kondisi'] && $ddp['tanggal_cek_kondisi'] != '0000-00-00 00:00:00') ? $ddp['tanggal_cek_kondisi'] : 'Belum di cek' ?></td>
                        <td><?= $ddp['catatan_kondisi'] ?></td>
                        <td>
                            <?php if ($ddp['foto_kondisi']): ?>
                                <a href="foto/detail_perawatan/<?= $ddp['foto_kondisi'] ?>" target="_blank">
                                    <img src="foto/detail_perawatan/<?= $ddp['foto_kondisi'] ?>" width="100">
                                </a>
                            <?php else: ?>Belum ada<?php endif ?>
                        </td>
                        <td><?= $ddp['status_kondisi'] ?></td>
                        <td>
                            <?php if ($ddp['tanda_tangan']): ?>
                                <a href="foto/tanda_tangan/<?= $ddp['tanda_tangan'] ?>" target="_blank">
                                    <img src="foto/tanda_tangan/<?= $ddp['tanda_tangan'] ?>" width="100">
                                </a>
                            <?php else: ?>Belum ada<?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
</body>
</html>
