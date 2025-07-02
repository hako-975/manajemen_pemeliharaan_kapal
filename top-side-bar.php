<style>
    .notif-dropdown {
        position: relative;
        display: inline-block;
    }

    .notif-list {
        display: none;
        position: absolute;
        top: 30px;
        right: 0;
        background-color: white;
        min-width: 400px;
        box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
        z-index: 1;
        padding: 10px;
        border-radius: 5px;
        max-height: 300px;
        overflow-y: auto;
    }

    .notif-list a {
        display: block;
        padding: 8px;
        text-decoration: none;
        color: black;
        border-bottom: 1px solid #ddd;
    }

    .notif-list a:hover {
        background-color: #f1f1f1;
    }

    .notif-count {
        position: absolute;
        top: -10px;
        right: -10px;
        background: red;
        color: white;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
    }
</style>

<div class="topbar" style="z-index: 9999;">
    <div class="logo">
        <img src="foto/logo.png" alt="logo kapal">
        <a href="index.php">Kapal Kargo</a>
    </div>
    <nav>
        <ul style="list-style: none; display: flex; gap: 20px;">
            <li class="notif-dropdown">
                <a href="#" id="notif-icon" onclick="toggleDropdown(event)">
                    🔔
                    <span id="notif-count" class="notif-count">0</span>
                </a>
                <div class="notif-list" id="notif-list"></div>
            </li>
            <li><a href="#">Selamat Datang, <?= htmlspecialchars($dataUser['nama_lengkap']); ?></a></li>
        </ul>
    </nav>

</div>
<div class="sidebar" style="overflow-y: auto; padding-bottom: 150px;">
    <ul>
        <li><a href="kapal.php">Kapal</a></li>
        <?php if ($dataUser['role'] == 'Administrator'): ?>
            <li><a href="user.php">User</a></li>
            <li><a href="kru.php">Kru</a></li>
            <li><a href="kondisi.php">Kondisi</a></li>
        <?php endif ?>
        <?php 
            $sidebar_jenis_perawatan = mysqli_query($conn, "SELECT * FROM jenis_perawatan");
         ?>
         <?php if ($dataUser['role'] != 'Administrator'): ?>
             <?php foreach ($sidebar_jenis_perawatan as $data_sidebar_jenis_perawatan): ?>
                <?php
                    if (
                        ($dataUser['role'] == 'Kru Lambung Kapal' && $data_sidebar_jenis_perawatan['id_jenis_perawatan'] == 1) ||
                        ($dataUser['role'] == 'Kru Alat Navigasi Kapal' && $data_sidebar_jenis_perawatan['id_jenis_perawatan'] == 2) ||
                        ($dataUser['role'] == 'Kru Alat Kebakaran dan Keselamatan Kapal' && $data_sidebar_jenis_perawatan['id_jenis_perawatan'] == 3)
                    ):
                ?>
                    <li>
                        <a href="perawatan.php?id_jenis_perawatan=<?= $data_sidebar_jenis_perawatan['id_jenis_perawatan']; ?>">
                            Perawatan <?= $data_sidebar_jenis_perawatan['jenis_perawatan']; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <?php foreach ($sidebar_jenis_perawatan as $data_sidebar_jenis_perawatan): ?>
                <li>
                    <a href="perawatan.php?id_jenis_perawatan=<?= $data_sidebar_jenis_perawatan['id_jenis_perawatan']; ?>">
                        Perawatan <?= $data_sidebar_jenis_perawatan['jenis_perawatan']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php endif ?>

        <?php if ($dataUser['role'] == 'Administrator'): ?>
            <li><a href="laporan.php">Laporan</a></li>
        <?php endif ?>
        
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function loadNotifikasi() {
        $.ajax({
            url: "get_notifikasi.php",
            method: "GET",
            dataType: "json",
            success: function(data) {
                $('#notif-count').text(data.jumlah);

                let list = '';
                if (data.data.length > 0) {
                    data.data.forEach(function(item) {
                        list += `<a href="detail_perawatan.php?id_perawatan=${item.id_perawatan}">
                                    ${item.jenis_perawatan} - ${item.tanggal_perawatan}
                                </a>`;
                    });
                } else {
                    list = '<p style="color: black">Tidak ada notifikasi.</p>';
                }
                $('#notif-list').html(list);
            },
            error: function() {
                console.error("Gagal memuat notifikasi.");
            }
        });
    }

    function toggleDropdown(event) {
        event.preventDefault();
        $('#notif-list').toggle();
    }

    $(document).ready(function() {
        loadNotifikasi();
        setInterval(loadNotifikasi, 30000); // refresh tiap 30 detik
    });

    // Tutup dropdown jika klik di luar
    $(document).click(function(e) {
        if (!$(e.target).closest('#notif-icon, #notif-list').length) {
            $('#notif-list').hide();
        }
    });
</script>
