<?php
require 'vendor/autoload.php';
include 'koneksi.php';

use Dompdf\Dompdf;

// Fungsi ubah bulan ke bahasa Indonesia
function nama_bulan($bulan) {
    $arr = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
    return $arr[(int)$bulan - 1];
}

// Fungsi base64 encode gambar untuk embed ke PDF
function base64_image($file) {
    if (!file_exists($file)) return '';
    $type = pathinfo($file, PATHINFO_EXTENSION);
    $data = file_get_contents($file);
    $base64 = base64_encode($data);
    return 'data:image/' . $type . ';base64,' . $base64;
}

$id_user = $_SESSION['id_user'];
$dataUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));

// Ambil filter dari POST (bisa juga ganti ke GET jika ingin)
$bulan_filter = isset($_POST['bulan']) ? $_POST['bulan'] : '';
$status_filter = isset($_POST['status']) ? $_POST['status'] : '';
$jenis_filter = isset($_POST['jenis_perawatan']) ? $_POST['jenis_perawatan'] : '';

// Bangun WHERE query
$where = [];
if ($bulan_filter != '') {
    $where[] = "MONTH(tanggal_perawatan) = " . (int)$bulan_filter;
}
if ($status_filter != '') {
    $where[] = "status = '" . mysqli_real_escape_string($conn, $status_filter) . "'";
}
if ($jenis_filter != '') {
    $where[] = "perawatan.id_jenis_perawatan = " . (int)$jenis_filter;
}

$where_sql = '';
if (count($where) > 0) {
    $where_sql = 'WHERE ' . implode(' AND ', $where);
}

$sql = "SELECT perawatan.*, kapal.nama_kapal, kru.nama, jenis_perawatan.jenis_perawatan 
        FROM perawatan 
        INNER JOIN kapal ON perawatan.id_kapal = kapal.id_kapal 
        INNER JOIN kru ON perawatan.id_kru = kru.id_kru 
        INNER JOIN jenis_perawatan ON perawatan.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan
        $where_sql
        ORDER BY tanggal_perawatan ASC";

$perawatan = mysqli_query($conn, $sql);

$html = '
<h2 style="text-align:center;">Laporan Perawatan Kapal</h2>
<table border="1" cellpadding="5" cellspacing="0" width="100%" style="border-collapse: collapse; font-family: Arial, sans-serif;">
    <thead>
        <tr style="background-color:#eee;">
            <th>No.</th>
            <th>Tanggal Perawatan</th>
            <th>Jenis Perawatan</th>
            <th>Nama Kapal</th>
            <th>Nama Teknisi</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
';

$i = 1;
while ($data_perawatan = mysqli_fetch_assoc($perawatan)) {
    $id_perawatan = $data_perawatan['id_perawatan'];

    // Update status jika detail sudah ada tanda tangan & status 'Sudah'
    $update_detail_perawatan = mysqli_query($conn, "SELECT * FROM detail_perawatan WHERE id_perawatan = '$id_perawatan' AND status_kondisi = 'Sudah' AND tanda_tangan IS NOT NULL");
    if (mysqli_num_rows($update_detail_perawatan) > 0) {
        mysqli_query($conn, "UPDATE perawatan SET status = 'Sudah' WHERE id_perawatan = '$id_perawatan'");
        $data_perawatan['status'] = 'Sudah';
    }

    $warna_status = $data_perawatan['status'] == 'Sudah' ? 'lightgreen' : 'salmon';

    $tanggal = date('d', strtotime($data_perawatan['tanggal_perawatan'])) . ' ' . 
               nama_bulan(date('m', strtotime($data_perawatan['tanggal_perawatan']))) . ' ' . 
               date('Y H:i', strtotime($data_perawatan['tanggal_perawatan']));

    $html .= "<tr>
        <td align='center'>{$i}.</td>
        <td>{$tanggal}</td>
        <td>{$data_perawatan['jenis_perawatan']}</td>
        <td>{$data_perawatan['nama_kapal']}</td>
        <td>{$data_perawatan['nama']}</td>
        <td style='background-color: {$warna_status}; text-align:center;'>{$data_perawatan['status']}</td>
    </tr>";

    $detail_perawatan = mysqli_query($conn, "SELECT detail_perawatan.*, kondisi.kondisi FROM detail_perawatan INNER JOIN kondisi ON detail_perawatan.id_kondisi = kondisi.id_kondisi WHERE id_perawatan = '$id_perawatan'");

    $html .= '<tr><th colspan="6" style="background:#ddd;">Detail Cek Perawatan</th></tr>';
    $html .= '<tr style="background:#eee;">
        <th>Kode</th>
        <th>Tanggal Cek Kondisi</th>
        <th>Catatan Kondisi</th>
        <th>Status Kondisi</th>
        <th>Foto Kondisi</th>
        <th>Tanda Tangan</th>
    </tr>';

    $abjad = range('a', 'z');
    $j = 0;

    while ($ddp = mysqli_fetch_assoc($detail_perawatan)) {
        $tanggal_cek = ($ddp['tanggal_cek_kondisi'] == NULL || $ddp['tanggal_cek_kondisi'] == '0000-00-00 00:00:00') ? 
                        'Belum di cek' : date('d-m-Y H:i', strtotime($ddp['tanggal_cek_kondisi']));

        $foto_path = 'foto/detail_perawatan/' . $ddp['foto_kondisi'];
        $ttd_path = 'foto/tanda_tangan/' . $ddp['tanda_tangan'];

        $img_foto = (!empty($ddp['foto_kondisi']) && file_exists($foto_path)) ? 
            '<img src="' . base64_image($foto_path) . '" style="max-width:100px; max-height:80px; border:1px solid #000;">' : 'Belum ada';

        $img_ttd = (!empty($ddp['tanda_tangan']) && file_exists($ttd_path)) ? 
            '<img src="' . base64_image($ttd_path) . '" style="max-width:100px; max-height:80px; border:1px solid #000;">' : 'Belum ada';

        $html .= '<tr>
            <td align="center">' . $abjad[$j++] . '.</td>
            <td>' . $tanggal_cek . '</td>
            <td>' . htmlspecialchars($ddp['catatan_kondisi']) . '</td>
            <td>' . $ddp['status_kondisi'] . '</td>
            <td align="center">' . $img_foto . '</td>
            <td align="center">' . $img_ttd . '</td>
        </tr>';
    }
    $html .= '<tr><th colspan="6" style="background:#ddd;"></th></tr>';
    $i++;
}

$html .= '</tbody></table>';

// Inisialisasi dan render PDF dengan Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Auto-download PDF
$dompdf->stream("laporan_perawatan_" . date('YmdHis') . ".pdf", ["Attachment" => true]);
exit;
?>