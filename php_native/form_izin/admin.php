<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Daftar Izin</h2>
        <div class="row">
            <div class="col-md-6">
                <form id="searchForm">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Cari berdasarkan nama" id="searchInput">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="izinList"></div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            // Menampilkan daftar izin saat halaman dimuat
            fetchIzin();

            // Handle submit form pencarian
            $('#searchForm').submit(function(e){
                e.preventDefault();
                fetchIzin($('#searchInput').val());
            });

            // Fungsi untuk mengambil daftar izin dari server
            function fetchIzin(keyword = ''){
                $.ajax({
                    url: 'fetch_izin.php',
                    type: 'GET',
                    data: {keyword: keyword},
                    success: function(response){
                        $('#izinList').html(response);
                    }
                });
            }
        });
    </script>
</body>
</html>
