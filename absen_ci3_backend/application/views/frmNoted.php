<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #4facfe, #00f2fe);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            border: none;
        }
        .card-header {
          background-color: #343a40; /* Warna gelap elegan */
          color: white;
          text-align: center;
          font-size: 1.5rem;
          font-weight: bold; /* Tambahkan kesan tegas */
          padding: 1.5rem;
          border: none; /* Menghapus garis putih/pemisah */
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Sedikit bayangan untuk efek kedalaman */
      }
      .savebtn{
          background-color: #343a40 !important;
      }
        .form-label {
            font-weight: bold;
            color: #333;
        }
        .btn-primary {
            background: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .form-control:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.8);
            border-color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-list-task"></i> Form Input Tugas
            </div>
            <div class="card-body">
                <form id="taskForm">
                    <div class="mb-4">
                        <label for="taskTitle" class="form-label">Judul Tugas</label>
                        <input type="text" class="form-control" id="taskTitle" placeholder="Masukkan judul tugas">
                    </div>
                    <div class="mb-4">
                        <label for="taskDescription" class="form-label">Deskripsi Tugas</label>
                        <textarea class="form-control" id="taskDescription" rows="5" placeholder="Masukkan deskripsi tugas, contoh: UAS English Sabtu jam 20.00"></textarea>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="startDate" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="startDate">
                        </div>
                        <div class="col-md-6">
                            <label for="endDate" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="endDate">
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg savebtn">Simpan Tugas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('taskForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const title = document.getElementById('taskTitle').value;
            const description = document.getElementById('taskDescription').value;
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            console.log({
                title,
                description,
                startDate,
                endDate
            });
            alert("Tugas masih di lanjuuut!");
        });
    </script>
</body>
</html>
