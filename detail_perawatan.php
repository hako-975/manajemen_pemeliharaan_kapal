<?php
    include 'koneksi.php';
    if (!isset($_SESSION['id_user'])){
        echo "<script>window.location='login.php'</script>";
    }

    $id_perawatan = $_GET['id_perawatan'];
    $data_detail_perawatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM detail_perawatan INNER JOIN perawatan ON detail_perawatan.id_perawatan = perawatan.id_perawatan INNER JOIN kondisi ON detail_perawatan.id_kondisi = kondisi.id_kondisi INNER JOIN jenis_perawatan ON perawatan.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan WHERE detail_perawatan.id_perawatan = '$id_perawatan'"));
    $detail_perawatan = mysqli_query($conn, "SELECT * FROM detail_perawatan INNER JOIN perawatan ON detail_perawatan.id_perawatan = perawatan.id_perawatan INNER JOIN kondisi ON detail_perawatan.id_kondisi = kondisi.id_kondisi INNER JOIN jenis_perawatan ON perawatan.id_jenis_perawatan = jenis_perawatan.id_jenis_perawatan WHERE detail_perawatan.id_perawatan = '$id_perawatan'");

    $id_user = $_SESSION['id_user'];
    $data_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'"));
    $check_detail_perawatan = mysqli_query($conn, "SELECT * FROM detail_perawatan WHERE id_perawatan = '$id_perawatan' AND status_kondisi = 'Sudah' AND tanda_tangan IS NOT NULL;");
    if ($check_detail_perawatan) {
        mysqli_query($conn, "UPDATE perawatan SET status = 'Sudah'");
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
        <h1>Detail Perawatan Kapal - <?= $data_detail_perawatan['jenis_perawatan']; ?> - <?= date('d-m-Y H:i', strtotime($data_detail_perawatan['tanggal_perawatan'])); ?></h1>
        <h6>Klik dua kali kolom untuk mengedit</h6>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kondisi</th>
                    <th>Catatan Kondisi</th>
                    <th>Foto Kondisi</th>
                    <th>Status Kondisi</th>
                    <th>Tanggal Cek Kondisi</th>
                    <th>Tanda Tangan</th>
                </tr>
            </thead>
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
                        <td class="editable-select"
                            data-id="<?= $data_detail_perawatan['id_detail_perawatan']; ?>"
                            data-field="status_kondisi"
                            data-id-perawatan="<?= $data_detail_perawatan['id_perawatan']; ?>">
                            <?php if ($data_detail_perawatan['status_kondisi'] == 'Belum'): ?>
                                <p class="btn bg-danger"><?= htmlspecialchars($data_detail_perawatan['status_kondisi']); ?></p>
                            <?php else: ?>
                                <p class="btn bg-success"><?= htmlspecialchars($data_detail_perawatan['status_kondisi']); ?></p>
                            <?php endif ?>
                        </td>
                        <td>
                        <?php if ($data_detail_perawatan['tanggal_cek_kondisi'] == NULL || $data_detail_perawatan['tanggal_cek_kondisi'] == '0000-00-00 00:00:00'): ?>
                            Ubah Status untuk mengisi tanggal
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

                    </tr>
                <?php endforeach ?>
            </tbody>
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
            // Untuk catatan_kondisi tetap pakai kode lama (jika ada)

            // Event double click untuk kolom status_kondisi
            $(document).on('dblclick', '.editable-select', function () {
                var td = $(this);
                var currentValue = td.text().trim();
                var id = td.data('id');
                var field = td.data('field');
                var id_perawatan = td.data('id-perawatan');

                var selectHtml = `
                    <select class="status-select form-select">
                        <option value="Belum" ${currentValue === 'Belum' ? 'selected' : ''}>Belum</option>
                        <option value="Sudah" ${currentValue === 'Sudah' ? 'selected' : ''}>Sudah</option>
                    </select>
                `;

                td.html(selectHtml);
                td.find('select').focus();
            });

            // Saat select berubah, kirim ke server
            $(document).on('change', '.status-select', function () {
                var select = $(this);
                var td = select.closest('td');
                var newValue = select.val();
                var id = td.data('id');
                var field = td.data('field');
                var id_perawatan = td.data('id-perawatan');

                $.ajax({
                    url: 'update_status_kondisi.php',
                    method: 'POST',
                    data: {
                        id_detail_perawatan: id,
                        field: field,
                        value: newValue,
                        id_perawatan: id_perawatan
                    },
                    success: function (res) {
                        try {
                            var response = JSON.parse(res);
                            if (response.success) {
                                td.html(newValue); // Update tampilan
                                window.location.href = response.redirect;
                            } else {
                                alert(response.message || "Update gagal.");
                                td.html(currentValue);
                            }
                        } catch {
                            alert("Terjadi kesalahan saat memproses respons server.");
                            td.html(currentValue);
                        }
                    },
                    error: function () {
                        alert("Gagal mengirim data ke server.");
                        td.html(currentValue);
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

    </script>
  </body>
</html>