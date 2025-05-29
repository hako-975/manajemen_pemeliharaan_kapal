<html>

<head>
    <link rel="icon" href="foto/logo.png">
    <title>Tambah Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'top-side-bar.php'; ?> 
    <div class="main">
        <h1>Tambah Siswa</h1>
        <form method="post" class="form-admin">
            <div class="form-group">
                <label for="teknisi">Kondisi</label>
                <input type="text" id="teknisi" name="teknisi" class="input" required>
            </div>
            <div class="form-group">
                <label for="nama">Hasil</label>
                <input type="text" id="nama" name="nama" class="input" required>
            </div>
            <div class="form-group">
                <label for="jabatan">Catatan</label>
                <input type="text" id="jabatan" name="jabatan" class="input" required>
            </div>
            <button type="submit" class="btn" name="btnSimpan">Simpan</button>
        </form>
    </div>
</body>

</html>