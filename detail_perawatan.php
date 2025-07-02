<?php
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_perawatan = $_GET['id_perawatan'];
    $data_detail_perawatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM detail_perawatan INNER JOIN perawatan ON detail_perawatan.id_perawatan = perawatan.id_perawatan INNER JOIN kondisi ON detail_perawatan.id_kondisi = kondisi.id_kondisi INNER JOIN jenis_perawatan ON perawatan.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan WHERE detail_perawatan.id_perawatan = '$id_perawatan'"));
    $detail_perawatan = mysqli_query($conn, "SELECT * FROM detail_perawatan INNER JOIN perawatan ON detail_perawatan.id_perawatan = perawatan.id_perawatan INNER JOIN kondisi ON detail_perawatan.id_kondisi = kondisi.id_kondisi INNER JOIN jenis_perawatan ON perawatan.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan WHERE detail_perawatan.id_perawatan = '$id_perawatan'");

    $id_user = $_SESSION['id_user'];
    $dataUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));
    
    if (isset($_POST['btn_status_revisi'])) {
        if ($_POST['status_revisi'] == 'Sudah Sesuai') {
            $query = "UPDATE perawatan SET status = 'Sudah', catatan_revisi = '' WHERE id_perawatan = '$id_perawatan'";
            $ubah_perawatan = mysqli_query($conn, $query);
            if ($ubah_perawatan) {
                echo "
                    <script>
                        alert('Status Perawatan Kapal berhasil diubah!');
                        window.location.href='perawatan.php';
                    </script>
                ";
            } else {
                echo "
                    <script>
                        alert('Perawatan Kapal gagal diubah: " . mysqli_error($conn) . "');
                        window.history.back();
                    </script>
                ";
            }
        } else {
            $catatan_revisi = $_POST['catatan_revisi'];
            $query = "UPDATE perawatan SET status = 'Perlu Direvisi', catatan_revisi = '$catatan_revisi' WHERE id_perawatan = '$id_perawatan'";
            $ubah_perawatan = mysqli_query($conn, $query);
            if ($ubah_perawatan) {
                echo "
                    <script>
                        alert('Status Perawatan Kapal berhasil diubah!');
                        window.location.href='perawatan.php';
                    </script>
                ";
            } else {
                echo "
                    <script>
                        alert('Perawatan Kapal gagal diubah: " . mysqli_error($conn) . "');
                        window.history.back();
                    </script>
                ";
            }
        }
    }  
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="foto/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Perawatan Kapal - <?= $data_detail_perawatan['jenis_perawatan']; ?> - <?= date('d-m-Y H:i', strtotime($data_detail_perawatan['tanggal_perawatan'])); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>
  <?php include 'top-side-bar.php'; ?>
  <?php 
      if (isset($_SESSION['pesan'])) {
        echo "<script>alert('{$_SESSION['pesan']}');</script>";
        unset($_SESSION['pesan']);
    } ?>
    <div class="main">
        <a href="perawatan.php?id_jenis_perawatan=<?= $data_detail_perawatan['id_jenis_perawatan']; ?>" class="btn">Kembali</a>
        <hr>
        <h3>Detail Perawatan Kapal - <?= $data_detail_perawatan['jenis_perawatan']; ?> - <?= date('d-m-Y H:i', strtotime($data_detail_perawatan['tanggal_perawatan'])); ?></h3>
        <h4>Status Perawatan: 
            <?php if ($data_detail_perawatan['status'] == 'Sudah'): ?>
                <span class="p-2 rounded text-white bg-success"><small>Sudah</small></span>
            <?php elseif ($data_detail_perawatan['status'] == 'Perlu Direvisi'): ?>
                <span class="p-2 rounded text-white bg-warning"><small>Perlu Direvisi</small></span>
            <?php elseif ($data_detail_perawatan['status'] == 'Belum Dibaca'): ?>
                <span class="p-2 rounded text-white bg-danger"><small>Belum Dibaca</small></span>
            <?php endif ?>
            
        </h4>
        <?php if ($dataUser['role'] != 'Administrator'): ?>
            <h6>Klik dua kali kolom untuk mengedit</h6>
        <?php endif ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kondisi</th>
                    <th>Catatan Kondisi</th>
                    <th>Foto Kondisi</th>
                    <th>Tanggal Cek Kondisi</th>
                    <th>Tanda Tangan</th>
                    <th>Nama Kru</th>
                </tr>
            </thead>
            <?php if ($dataUser['role'] != 'Administrator'): ?>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($detail_perawatan as $data_detail_perawatan) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $data_detail_perawatan['kondisi']; ?></td>
                            <td class="editable"
                                data-id="<?= $data_detail_perawatan['id_detail_perawatan']; ?>"
                                data-field="catatan_kondisi"
                                data-id-perawatan="<?= $data_detail_perawatan['id_perawatan']; ?>">
                                <?= nl2br(htmlspecialchars($data_detail_perawatan['catatan_kondisi'])); ?>
                            </td>
                            <td style="position: relative; width: 100px;">
                                <?php if ($data_detail_perawatan['foto_kondisi'] == NULL): ?>
                                    <form class="uploadForm" enctype="multipart/form-data">
                                        <input type="hidden" name="id_perawatan" value="<?= $id_perawatan; ?>">
                                        <input type="hidden" name="id_detail_perawatan" value="<?= $data_detail_perawatan['id_detail_perawatan']; ?>">
                                        <input type="file" name="foto_kondisi" class="fotoInput" required>
                                    </form>
                                <?php else: ?>
                                    <a href="foto/detail_perawatan/<?= $data_detail_perawatan['foto_kondisi']; ?>" target="_blank">
                                        <img width="100" src="foto/detail_perawatan/<?= $data_detail_perawatan['foto_kondisi']; ?>" alt="<?= $data_detail_perawatan['foto_kondisi']; ?>" style="display: block; padding-left: 25px;">
                                    </a>
                                    <a onclick="return confirm('Apakah Anda yakin ingin menghapus foto kondisi <?= $data_detail_perawatan['kondisi']; ?>')" href="hapus_foto_detail_perawatan.php?id_detail_perawatan=<?= $data_detail_perawatan['id_detail_perawatan']; ?>&id_perawatan=<?= $id_perawatan; ?>" class="btn bg-danger" 
                                       style="
                                           position: absolute;
                                           top: 0;
                                           left: 2px;
                                           padding: 2px 6px;
                                           font-size: 12px;
                                           line-height: 1;
                                           text-decoration: none;
                                           color: white;
                                       "
                                       data-id="<?= $data_detail_perawatan['id_detail_perawatan']; ?>">
                                        &times;
                                    </a>
                                <?php endif ?>
                            </td>
                            <td>
                            <?php if ($data_detail_perawatan['tanggal_cek_kondisi'] == NULL || $data_detail_perawatan['tanggal_cek_kondisi'] == '0000-00-00 00:00:00'): ?>
                                Lengkapi data untuk mengisi tanggal
                            <?php else: ?>
                                <?= $data_detail_perawatan['tanggal_cek_kondisi']; ?>
                            <?php endif ?></td>
                            <td class="tanda-tangan-cell"
                                style="position: relative; width: 100px;"
                                data-id="<?= $data_detail_perawatan['id_detail_perawatan']; ?>"
                                data-id-perawatan="<?= $data_detail_perawatan['id_perawatan']; ?>">
                                <?php if ($data_detail_perawatan['tanda_tangan']): ?>
                                    <a style="padding-left: 25px" href="foto/tanda_tangan/<?= $data_detail_perawatan['tanda_tangan']; ?>" target="_blank">
                                        <img src="foto/tanda_tangan/<?= $data_detail_perawatan['tanda_tangan']; ?>" width="100">
                                    </a>
                                    <a onclick="return confirm('Apakah Anda yakin ingin menghapus tanda tangan <?= htmlspecialchars(addslashes($data_detail_perawatan['kondisi'])); ?>')"
                                       href="hapus_tanda_tangan_detail_perawatan.php?id_detail_perawatan=<?= $data_detail_perawatan['id_detail_perawatan']; ?>&id_perawatan=<?= $id_perawatan; ?>" class="btn bg-danger"
                                       style="
                                           position: absolute;
                                           top: 0;
                                           left: 2px;
                                           padding: 2px 6px;
                                           font-size: 12px;
                                           line-height: 1;
                                           text-decoration: none;
                                           color: white;
                                       "
                                       data-id="<?= $data_detail_perawatan['id_detail_perawatan']; ?>">
                                        &times;
                                    </a>
                                <?php else: ?>
                                    Belum ada
                                <?php endif; ?>
                            </td>
                            <td class="editable-nama-kru"
                                data-id="<?= $data_detail_perawatan['id_detail_perawatan']; ?>"
                                data-field="nama_kru"
                                data-id-perawatan="<?= $data_detail_perawatan['id_perawatan']; ?>">
                                <?= nl2br(htmlspecialchars($data_detail_perawatan['nama_kru'])); ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            <?php else: ?>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($detail_perawatan as $data_detail_perawatan) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $data_detail_perawatan['kondisi']; ?></td>
                            <td>
                                <?= nl2br(htmlspecialchars($data_detail_perawatan['catatan_kondisi'])); ?>
                            </td>
                            <td style="position: relative; width: 100px;">
                                <?php if ($data_detail_perawatan['foto_kondisi'] == NULL): ?>
                                    Belum ada foto
                                <?php else: ?>
                                    <a href="foto/detail_perawatan/<?= $data_detail_perawatan['foto_kondisi']; ?>" target="_blank">
                                        <img width="100" src="foto/detail_perawatan/<?= $data_detail_perawatan['foto_kondisi']; ?>" alt="<?= $data_detail_perawatan['foto_kondisi']; ?>" style="display: block; padding-left: 25px;">
                                    </a>
                                <?php endif ?>
                            </td>
                            <td>
                                <?= $data_detail_perawatan['tanggal_cek_kondisi']; ?>
                            </td>
                            <td>
                                <?php if ($data_detail_perawatan['tanda_tangan']): ?>
                                    <a style="padding-left: 25px" href="foto/tanda_tangan/<?= $data_detail_perawatan['tanda_tangan']; ?>" target="_blank">
                                        <img src="foto/tanda_tangan/<?= $data_detail_perawatan['tanda_tangan']; ?>" width="100">
                                    </a>
                                <?php else: ?>
                                    Belum ada
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($data_detail_perawatan['nama_kru']): ?>
                                    <?= $data_detail_perawatan['nama_kru']; ?>
                                <?php else: ?>
                                    Belum ada
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            <?php endif ?>
        </table>

        <!-- Modal Upload Tanda Tangan -->
        <div id="modalTandaTangan" style="display:none; position:fixed; z-index:9999; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6);">
            <div style="margin:5% auto; width:450px; background:#fff; padding:20px; border-radius:10px;">
                <h3>Tanda Tangan Digital</h3>
                <canvas id="signature-pad" width="400" height="200" style="border:1px solid #000;"></canvas><br><br>
                <input type="hidden" id="ttg_id_detail_perawatan">
                <input type="hidden" id="ttg_id_perawatan">
                <button id="clear-signature">Hapus</button>
                <button id="save-signature">Simpan</button>
                <button onclick="$('#modalTandaTangan').hide()">Tutup</button>
                <div id="result-signature"></div>
            </div>
        </div>
        
        <?php if ($dataUser['role'] == 'Administrator'): ?>
            <hr>
            <div class="container-fluid p-3">
                <div class="row">
                    <div class="col">
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label d-block">Status Revisi</label>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_revisi" id="sudah_sesuai" value="Sudah Sesuai">
                                    <label class="form-check-label" for="sudah_sesuai">Sudah Sesuai</label>
                                </div>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_revisi" id="perlu_direvisi" value="Perlu Direvisi">
                                    <label class="form-check-label" for="perlu_direvisi">Perlu Direvisi</label>
                                </div>
                            </div>

                            <div class="mb-3" id="catatan_revisi_group" style="display: none;">
                                <label for="catatan_revisi" class="form-label">Catatan Revisi</label>
                                <textarea class="form-control" name="catatan_revisi" id="catatan_revisi" rows="4" placeholder="Tuliskan catatan revisi di sini..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" name="btn_status_revisi">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>


    <script>
        $(document).ready(function() {
            let canvas = document.getElementById('signature-pad');
            let ctx = canvas.getContext('2d');
            let drawing = false;

            function getCanvasPosition(e) {
                const rect = canvas.getBoundingClientRect();
                return { x: e.clientX - rect.left, y: e.clientY - rect.top };
            }

            $('#signature-pad').on('mousedown', function(e) {
                drawing = true;
                const pos = getCanvasPosition(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            });

            $('#signature-pad').on('mousemove', function(e) {
                if (drawing) {
                    const pos = getCanvasPosition(e);
                    ctx.lineTo(pos.x, pos.y);
                    ctx.strokeStyle = "#000";
                    ctx.lineWidth = 2;
                    ctx.stroke();
                }
            });

            $(document).on('mouseup', function() {
                drawing = false;
            });

            // Clear canvas
            $('#clear-signature').click(function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.beginPath();
            });

            // Open modal on double-click td
            $(document).on('dblclick', '.tanda-tangan-cell', function () {
                const id = $(this).data('id');
                const idPerawatan = $(this).data('id-perawatan');
                $('#ttg_id_detail_perawatan').val(id);
                $('#ttg_id_perawatan').val(idPerawatan);
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                $('#modalTandaTangan').show();
            });

            // Save tanda tangan
            $('#save-signature').click(function () {
                const imageData = canvas.toDataURL('image/png');
                const id_detail = $('#ttg_id_detail_perawatan').val();
                const id_perawatan = $('#ttg_id_perawatan').val();

                $.ajax({
                    url: 'upload_tanda_tangan.php',
                    type: 'POST',
                    data: {
                        image_data: imageData,
                        id_detail_perawatan: id_detail,
                        id_perawatan: id_perawatan
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = response.redirect;
                        } else {
                            $('#result-signature').text(response.message || 'Gagal menyimpan.');
                        }
                    },
                    error: function() {
                        $('#result-signature').text('Terjadi kesalahan saat menyimpan.');
                    }
                });
            });
        });

        $(document).ready(function() {
            $(document).on('change', '.fotoInput', function() {
                var form = $(this).closest('.uploadForm')[0]; // Ambil form terdekat
                var formData = new FormData(form);

                $.ajax({
                    url: 'upload_foto_kondisi.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            }
                        } else {
                            alert('Gagal: ' + response.message);
                        }
                    },
                    error: function() {
                        alert("Upload gagal.");
                    }
                });
            });
        });

        $(document).ready(function() {
            $('.editable').dblclick(function () {
                var $td = $(this);
                if ($td.find('textarea').length > 0) return;

                var originalText = $td.text().trim();
                var id = $td.data('id');
                var field = $td.data('field');
                var id_perawatan = $td.data('id-perawatan');

                var canceled = false; // Untuk deteksi escape

                var $textarea = $('<textarea>').val(originalText).css({
                    width: '100%',
                    height: '80px',
                    resize: 'vertical',
                    fontFamily: 'inherit',
                    fontSize: 'inherit',
                    boxSizing: 'border-box'
                });

                $td.html($textarea);
                $textarea.focus();

                function save() {
                    var newValue = $textarea.val();

                    if (newValue !== originalText) {
                        $.ajax({
                            url: 'update_catatan_kondisi.php',
                            type: 'POST',
                            dataType: 'json',
                            contentType: 'application/json',
                            data: JSON.stringify({
                                id: id,
                                field: field,
                                value: newValue,
                                id_perawatan: id_perawatan
                            }),
                            success: function(response) {
                                if (response.success) {
                                    $td.html(newValue.replace(/\n/g, '<br>'));
                                    alert(response.message);
                                    if (response.redirect) {
                                        window.location.href = response.redirect;
                                    }
                                } else {
                                    alert('Gagal: ' + response.message);
                                    $td.html(originalText.replace(/\n/g, '<br>'));
                                }
                            },
                            error: function() {
                                alert('Terjadi kesalahan saat menghubungi server.');
                                $td.html(originalText.replace(/\n/g, '<br>'));
                            }
                        });
                    } else {
                        $td.html(originalText.replace(/\n/g, '<br>'));
                    }
                }

                $textarea.on('keydown', function (e) {
                    if ((e.key === 'Escape') || e.key === 'Enter' && e.ctrlKey) {
                        save();
                    }
                });

                $textarea.on('blur', function () {
                    if (!canceled) {
                        save();
                    }
                });
            });
        });

        $(document).ready(function() {
            $('.editable-nama-kru').dblclick(function () {
                var $td = $(this);
                if ($td.find('textarea').length > 0) return;

                var originalText = $td.text().trim();
                var id = $td.data('id');
                var field = $td.data('field');
                var id_perawatan = $td.data('id-perawatan');

                var canceled = false; // Untuk deteksi escape

                var $textarea = $('<textarea>').val(originalText).css({
                    width: '100%',
                    height: '80px',
                    resize: 'vertical',
                    fontFamily: 'inherit',
                    fontSize: 'inherit',
                    boxSizing: 'border-box'
                });

                $td.html($textarea);
                $textarea.focus();

                function save() {
                    var newValue = $textarea.val();

                    if (newValue !== originalText) {
                        $.ajax({
                            url: 'update_catatan_kondisi.php',
                            type: 'POST',
                            dataType: 'json',
                            contentType: 'application/json',
                            data: JSON.stringify({
                                id: id,
                                field: field,
                                value: newValue,
                                id_perawatan: id_perawatan
                            }),
                            success: function(response) {
                                if (response.success) {
                                    $td.html(newValue.replace(/\n/g, '<br>'));
                                    alert(response.message);
                                    if (response.redirect) {
                                        window.location.href = response.redirect;
                                    }
                                } else {
                                    alert('Gagal: ' + response.message);
                                    $td.html(originalText.replace(/\n/g, '<br>'));
                                }
                            },
                            error: function() {
                                alert('Terjadi kesalahan saat menghubungi server.');
                                $td.html(originalText.replace(/\n/g, '<br>'));
                            }
                        });
                    } else {
                        $td.html(originalText.replace(/\n/g, '<br>'));
                    }
                }

                $textarea.on('keydown', function (e) {
                    if ((e.key === 'Escape') || e.key === 'Enter' && e.ctrlKey) {
                        save();
                    }
                });

                $textarea.on('blur', function () {
                    if (!canceled) {
                        save();
                    }
                });
            });
        });

        $(document).ready(function () {
            $('input[name="status_revisi"]').change(function () {
                if ($(this).val() === 'Perlu Direvisi') {
                    $('#catatan_revisi_group').slideDown();
                } else {
                    $('#catatan_revisi_group').slideUp();
                }
            });
        });
    </script>
  </body>
</html>