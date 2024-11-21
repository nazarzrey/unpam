
    <?php 
    //  dbg($this->session->userdata);
        if($this->session->userdata("tipe")!="super"){
            echo "<h1>Anda bukan Super Admin</h1>";
            die();
        }
    ?>
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
            </div><div class="card-body">
            <form id="taskForm" method="POST" action="<?= isset($tugas) ? base_url('tugas/update/'.$tugas['id']) : base_url('tugas/simpan'); ?>">
                <div class="mb-4">
                    <label for="taskTitle" class="form-label">Judul Tugas</label>
                    <input type="text" class="form-control" id="taskTitle" name="judul_tugas" placeholder="Masukkan judul tugas" value="<?= isset($tugas) ? $tugas['judul_tugas'] : ''; ?>" autocomplete="off">
                </div>
                <div class="mb-4">
                    <label for="taskDescription" class="form-label">Deskripsi Tugas</label>
                    <textarea class="form-control" id="taskDescription" name="deskripsi" rows="5" placeholder="Masukkan deskripsi tugas"><?= isset($tugas) ? $tugas['deskripsi'] : ''; ?></textarea>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="startDate" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="startDate" name="tanggal_mulai" value="<?= isset($tugas) ? $tugas['tanggal_mulai'] : date('Y-m-d'); ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="endDate" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="endDate" name="tanggal_selesai" value="<?= isset($tugas) ? $tugas['tanggal_selesai'] : ''; ?>">
                    </div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg savebtn"><?= isset($tugas) ? 'Update Tugas' : 'Simpan Tugas'; ?></button>
                </div>
                        <a href="<?= base_url('tugas'); ?>">List Tugas</a>
            </form>
        </div>

            <?php if ($this->session->flashdata('success')): ?>
              <div id="flashMessage" class="alert alert-success">
                  <?= $this->session->flashdata('success'); ?>
              </div>
              <?php $this->session->unset_userdata('success'); ?>
            <?php elseif ($this->session->flashdata('error')): ?>
              <div id="flashMessage" class="alert alert-danger">
                  <?= $this->session->flashdata('error'); ?>
              </div>
              <?php $this->session->unset_userdata('error'); ?>
            <?php endif; ?>


            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const flashMessage = document.getElementById("flashMessage");
          if (flashMessage) {
              setTimeout(() => {
                  flashMessage.style.transition = "opacity 0.5s ease";
                  flashMessage.style.opacity = 0;
                  setTimeout(() => flashMessage.remove(), 500); // Hapus elemen setelah animasi
              }, 2000); // 5 detik
          }
      });
        document.addEventListener("DOMContentLoaded", function () {
            const today = new Date();
            const formattedDate = today.toISOString().split("T")[0];
            document.getElementById("startDate").value = formattedDate;
            document.getElementById("startDate").readOnly = true; // Opsional, agar tidak bisa diubah
        });
      // document.getElementById("taskForm").addEventListener("submit", function(e) {
      //     e.preventDefault();

      //     const formData = new FormData(this);
      //     fetch("<?= base_url('tugas/simpan'); ?>", {
      //         method: "POST",
      //         body: formData,
      //     })
      //     .then(response => response.json())
      //     .then(data => {
      //         if (data.status === "success") {
      //             const flashMessage = document.createElement("div");
      //             flashMessage.className = "alert alert-success";
      //             flashMessage.textContent = data.message;
      //             document.body.prepend(flashMessage);

      //             setTimeout(() => flashMessage.remove(), 5000);
      //         } else {
      //             alert("Gagal menyimpan tugas.");
      //         }
      //     })
      //     .catch(err => console.error("Error:", err));
      // });
      document.getElementById("taskForm").addEventListener("submit", function (e) {
          e.preventDefault();

          // Ambil nilai dari input
          const title = document.getElementById("taskTitle").value.trim();
          const description = document.getElementById("taskDescription").value.trim();
          const endDate = document.getElementById("endDate").value.trim();

          // Validasi: cek apakah ada input yang kosong
          if (!title) {
              alert("Judul tugas tidak boleh kosong!");
              return;
          }
          if (!description) {
              alert("Deskripsi tugas tidak boleh kosong!");
              return;
          }
          if (!endDate) {
              alert("Tanggal selesai tidak boleh kosong!");
              return;
          }

          // Jika validasi lolos, kirim form
          this.submit();
      });

    </script>
</body>
</html>
