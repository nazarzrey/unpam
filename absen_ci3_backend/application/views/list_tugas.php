<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Daftar Tugas</h2>
    <?php 
    //  dbg($this->session->userdata);
        if($this->session->userdata("tipe")=="super"){
            echo '<a href="'.base_url('note').'" class="btn btn-primary mb-4">Tambah Tugas</a>';
        }
    ?>
        <?php if (!empty($tugas)): ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul Tugas</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Input</th>
                        <th>Tanggal Detline</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // dbg($tugas);
                    
                    foreach ($tugas as $index => $row): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= $row['judul_tugas']; ?></td>
                            <td style="white-space: pre-wrap; word-wrap: break-word;"><?= $row['deskripsi']; ?></td>

                            <td><?= $row['tanggal_mulai']; ?></td>
                            <td><?= $row['tanggal_selesai']; ?></td>
                            <td>
                                <span class="badge bg-<?= $row['status'] == 'selesai' ? 'success' : ($row['status'] == 'deadline_terdekat' ? 'warning' : 'secondary'); ?>">
                                    <?= ucfirst($row['status']); ?>
                                </span>
                            </td>
                            <td>
                              <a href="<?= base_url('note/edit/'.$row['id']); ?>" class="btn btn-sm btn-warning">Edit</a>
                              <a href="<?= base_url('note/delete/'.$row['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus tugas ini?');">Hapus</a>
                          </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">Belum ada tugas yang terdaftar.</div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
