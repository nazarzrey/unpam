<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sistem Penilaian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 20px;
        }
        table {
            margin-top: 20px;
        }
        .table-container {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sistem Penilaian Mahasiswa</h2>
        <div class="form-group">
            <label for="mahasiswa">Nama Mahasiswa:</label>
            <input type="text" id="mahasiswa" class="form-control" placeholder="Masukkan nama mahasiswa">
        </div>
        <div class="form-group">
            <label for="matkul">Mata Kuliah:</label>
            <input type="text" id="matkul" class="form-control" placeholder="Masukkan mata kuliah">
        </div>
        <div class="form-group">
            <label for="soal">Soal:</label>
            <select id="soal" class="form-control">
                <?php foreach ($soal as $s): ?>
                    <option value="<?php echo $s->id_soal; ?>"><?php echo $s->matkul; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="nilai">Nilai:</label>
            <input type="number" id="nilai" class="form-control" placeholder="Masukkan nilai">
        </div>
        <button id="submit" class="btn btn-primary">Submit</button>

        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Mata Kuliah</th>
                        <th>Soal</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody id="nilaiTable">
                    <?php foreach ($penilaian as $p): ?>
                    <tr>
                        <td><?php echo $p->nim; ?></td>
                        <td><?php echo $p->nama; ?></td>
                        <td><?php echo $p->matkul; ?></td>
                        <td><?php echo $p->id_fk_soal; ?></td>
                        <td><?php echo $p->nilai; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script>
        $(document).ready(function() {
            let dataMahasiswa = <?php echo json_encode($mahasiswa); ?>;

            $("#mahasiswa").autocomplete({
                source: dataMahasiswa.map(m => m.nama)
            });

            $("#submit").click(function() {
                let mahasiswaNama = $("#mahasiswa").val();
                let matkul = $("#matkul").val();
                let id_fk_soal = $("#soal").val();
                let nilai = $("#nilai").val();
                let mahasiswa = dataMahasiswa.find(m => m.nama === mahasiswaNama);

                if (!mahasiswa) {
                    alert("Mahasiswa tidak ditemukan!");
                    return;
                }

                $.ajax({
                    url: '<?= base_url("penilaian/save_nilai"); ?>',
                    method: 'POST',
                    data: {
                        nim: mahasiswa.nim,
                        matkul: matkul,
                        id_fk_soal: id_fk_soal,
                        nilai: nilai
                    },
                    success: function(response) {
                        updateTable(response);
                    }
                });
            });

            function updateTable(data) {
                $("#nilaiTable").empty();
                data.forEach(row => {
                    let tr = "<tr>";
                    tr += `<td>${row.nim}</td>`;
                    tr += `<td>${row.nama}</td>`;
                    tr += `<td>${row.matkul}</td>`;
                    tr += `<td>${row.id_fk_soal}</td>`;
                    tr += `<td>${row.nilai}</td>`;
                    tr += "</tr>";
                    $("#nilaiTable").append(tr);
                });
            }
        });
    </script>
</body>
</html>
