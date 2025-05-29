<!DOCTYPE html>
<html>
<head>
    <title>Tanda Tangan Digital dengan jQuery</title>
    <style>
        #signature-pad {
            border: 1px solid #000;
            width: 400px;
            height: 200px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Tanda Tangan Digital</h2>
    <canvas id="signature-pad" width="400" height="200"></canvas><br>
    <button id="clear">Hapus</button>
    <button id="save">Simpan</button>
    <div id="result"></div>

    <script>
        let canvas = document.getElementById('signature-pad');
        let ctx = canvas.getContext('2d');
        let drawing = false;

        $('#signature-pad').on('mousedown', function(e) {
            drawing = true;
            const pos = getPosition(e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
        });

        $('#signature-pad').on('mousemove', function(e) {
            if (drawing) {
                const pos = getPosition(e);
                ctx.lineTo(pos.x, pos.y);
                ctx.strokeStyle = "#000";
                ctx.lineWidth = 2;
                ctx.stroke();
            }
        });

        $(document).on('mouseup', function() {
            drawing = false;
        });

        $('#clear').click(function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.beginPath();
        });

        $('#save').click(function() {
            let imageData = canvas.toDataURL('image/png');
            $.ajax({
                url: 'simpan.php',
                type: 'POST',
                data: { image_data: imageData },
                success: function(response) {
                    $('#result').html(response);
                },
                error: function() {
                    $('#result').html('Terjadi kesalahan saat menyimpan tanda tangan.');
                }
            });
        });

        function getPosition(e) {
            let rect = canvas.getBoundingClientRect();
            return {
                x: e.clientX - rect.left,
                y: e.clientY - rect.top
            };
        }
    </script>
</body>
</html>
