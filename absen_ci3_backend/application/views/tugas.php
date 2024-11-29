<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kelompok</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4">Manajemen Kelompok</h2>
    <div class="row">
        <!-- Pilihan Semester -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="semester">Semester</label>
                <select id="semester" class="form-control">
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                    <option value="3">Semester 3</option>
                    <option value="4">Semester 4</option>
                </select>
            </div>
        </div>

        <!-- Pilihan Mata Kuliah -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="mata-kuliah">Mata Kuliah</label>
                <select id="mata-kuliah" class="form-control">
                    <option value="">Pilih Mata Kuliah</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Tindakan Buat/Clear Kelompok -->
    <div id="kelompok-actions" class="my-3" style="display: none;">
        <!-- Tombol Buat atau Clear akan muncul secara dinamis -->
    </div>

    <!-- Container untuk Kelompok -->
    <div id="kelompok-container" class="row"></div>

    <!-- Input Judul Materi dan Tanggal Presentasi -->
    <div class="mt-4">
        <h4>Informasi Tambahan</h4>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="judul-materi">Judul Materi</label>
                    <input type="text" id="judul-materi" class="form-control" placeholder="Masukkan judul materi" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tanggal-presentasi">Tanggal Presentasi</label>
                    <input type="date" id="tanggal-presentasi" class="form-control">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript logic will be written separately and integrated with the HTML
</script>
</body>
</html>
