<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Bukuku</title>
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh; background-color: #f8f9fa;">

    <div class="text-center">
        <button id="clearDataButton" class="btn btn-primary">Hapus Data</button>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function () {
            // Menggunakan jQuery untuk menangani klik tombol
            $('#clearDataButton').click(function () {
                // Menggunakan AJAX untuk mengakses endpoint clear-stored-data
                $.ajax({
                    type: 'GET',
                    url: '/clearStoredData',
                    success: function (response) {
                        // Tampilkan pesan setelah berhasil
                        alert(response);
                    },
                    error: function (error) {
                        // Tampilkan pesan kesalahan jika ada
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
</body>
</html>
