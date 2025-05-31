<div class="topbar" style="z-index: 9999;">
    <div class="logo">
        <img src="foto/logo.png" alt="logo kapal">
        <a href="index.php">Kapal Kargo</a>
    </div>
    <nav>
        <ul>
            <li><a href="#">Selamat Datang, <?= $dataUser['nama_lengkap']; ?> </a></li>
        </ul>
    </nav>
</div>
<div class="sidebar">
    <ul>
        <li><a href="kapal.php">Kapal</a></li>
        <?php if ($dataUser['role'] == 'Administrator'): ?>
            <li><a href="user.php">User</a></li>
            <li><a href="teknisi.php">Teknisi</a></li>
            <li><a href="kondisi.php">Kondisi</a></li>
        <?php endif ?>
        <?php 
            $sidebar_jenis_perawatan = mysqli_query($conn, "SELECT * FROM jenis_perawatan");
         ?>
        <?php foreach ($sidebar_jenis_perawatan as $data_sidebar_jenis_perawatan): ?>
            <li><a href="perawatan.php?id_jenis_perawatan=<?= $data_sidebar_jenis_perawatan['id_jenis_perawatan']; ?>">Perawatan <?= $data_sidebar_jenis_perawatan['jenis_perawatan']; ?></a></li>
        <?php endforeach ?>
        <li><a href="laporan.php">Laporan</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>