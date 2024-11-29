<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penugasan Kelompok</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        ul li{ list-style-type: none}
        ul{margin:0 !important;padding:0 !important}
        .card-header{padding:5px}
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>Penugasan Kelompok</h2>
    <form id="form-tugas">
        <div class="form-group">
            <label for="jumlah_kelompok">Jumlah Kelompok</label>
            <input type="number" class="form-control" id="jumlah_kelompok" name="jumlah_kelompok" value="<?= isset($_GET['jumlah_kelompok']) ? $_GET['jumlah_kelompok'] : '' ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Buat Kelompok</button>
    </form>
    <hr>
    <div id="kelompok-container" class="d-flex flex-wrap"></div>
</div>

<script>
    $(document).ready(function () {
    let mahasiswaData = []; // Data mahasiswa global
    let kelompokData = {}; // Data mahasiswa per kelompok

    // Check if jumlah_kelompok exists in GET
    const urlParams = new URLSearchParams(window.location.search);
    const jumlahKelompok = urlParams.get('jumlah_kelompok');

    // If jumlah_kelompok exists, generate kelompok
    if (jumlahKelompok) {
        generateKelompok(jumlahKelompok);
        loadMahasiswa();
    }

    // Generate kelompok forms
    $('#form-tugas').submit(function (e) {
        e.preventDefault();
        const jumlahKelompok = $('#jumlah_kelompok').val();
        const url = `${window.location.pathname}?jumlah_kelompok=${jumlahKelompok}`;
        window.history.pushState({}, '', url);
        generateKelompok(jumlahKelompok);
        loadMahasiswa();
    });

    function generateKelompok(jumlahKelompok) {
    $('#kelompok-container').empty(); // Kosongkan container
    kelompokData = {}; // Reset data kelompok

    // Hitung kolom grid berdasarkan jumlah kelompok
        let gridCol = 2; // Hitung kolom grid (maksimal 12)
    if(jumlahKelompok<=6){
         gridCol = Math.floor(12 / jumlahKelompok); // Hitung kolom grid (maksimal 12)
    }
    for (let i = 1; i <= jumlahKelompok; i++) {
        $('#kelompok-container').append(`
            <div class="col-${gridCol} mb-3">
                <div class="card">
                    <div class="card-header text-center bg-secondary text-white">
                        Kelompok ${i}
                    </div>
                    <div class="card-body">
                        <div id="kelompok-${i}-list"></div>
                        <button type="button" class="btn btn-sm btn-success save-kelompok mt-2" data-kelompok="${i}">Save Kelompok</button>
                    </div>
                </div>
            </div>
        `);
        kelompokData[i] = []; // Inisialisasi data kosong untuk kelompok
    }
}


    // Load mahasiswa list
    function loadMahasiswa() {
        $.ajax({
            url: '<?= base_url("TugasKelompok/getMahasiswa") ?>',
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                mahasiswaData = data;
                renderAllMahasiswaLists();
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    // Render all mahasiswa lists
    function renderAllMahasiswaLists() {
        for (let i in kelompokData) {
            renderMahasiswaList(i);
        }
    }

    // Render mahasiswa for specific kelompok
    function renderMahasiswaList(kelompok) {
        let html = '<ul>';
        mahasiswaData.forEach(function (m) {
            const isChecked = kelompokData[kelompok].includes(m.id);
            if (!isInAnyKelompok(m.id) || isChecked) {
                html += `
                    <li id="mahasiswa-${kelompok}-${m.id}">
                        <label>
                            <input type="checkbox" class="mahasiswa-checkbox" data-id="${m.id}" data-nama="${m.alias}" data-kelompok="${kelompok}" ${isChecked ? 'checked' : ''}>
                            ${m.alias}
                        </label>
                    </li>`;
            }
        });
        html += '</ul>';
        $(`#kelompok-${kelompok}-list`).html(html);
    }

    // Check if mahasiswa is in any kelompok
    function isInAnyKelompok(mahasiswaId) {
        for (let k in kelompokData) {
            if (kelompokData[k].includes(mahasiswaId)) return true;
        }
        return false;
    }

    // Add or remove mahasiswa from kelompok
    $(document).on('change', '.mahasiswa-checkbox', function () {
        const mahasiswaId = $(this).data('id');
        const kelompok = $(this).data('kelompok');

        if ($(this).is(':checked')) {
            // Add to kelompok
            if (!kelompokData[kelompok].includes(mahasiswaId)) {
                kelompokData[kelompok].push(mahasiswaId);
            }
            hideMahasiswaInOtherGroups(mahasiswaId, kelompok); // Hide in other groups
        } else {
            // Remove from kelompok
            kelompokData[kelompok] = kelompokData[kelompok].filter(id => id !== mahasiswaId);
            showMahasiswaInOtherGroups(mahasiswaId, kelompok); // Show in other groups
        }

        // renderMahasiswaList(kelompok); // Update current kelompok
    });

    // Hide mahasiswa in other groups
    function hideMahasiswaInOtherGroups(mahasiswaId, currentKelompok) {
        for (let k in kelompokData) {
            if (k != currentKelompok) {
                $(`#kelompok-${k}-list #mahasiswa-${k}-${mahasiswaId}`).hide();
            }
        }
    }

    // Show mahasiswa in other groups
    function showMahasiswaInOtherGroups(mahasiswaId, currentKelompok) {
        for (let k in kelompokData) {
            if (k != currentKelompok) {
                $(`#kelompok-${k}-list #mahasiswa-${k}-${mahasiswaId}`).show();
            }
        }
    }

    // Save kelompok
    $(document).on('click', '.save-kelompok', function () {
        const kelompok = $(this).data('kelompok');
        const mahasiswaIds = kelompokData[kelompok];

        $.ajax({
            url: '<?= base_url("TugasKelompok/saveKelompok") ?>',
            type: 'POST',
            data: {
                kelompok: kelompok,
                mahasiswa_ids: mahasiswaIds
            },
            dataType: 'json',
            success: function (response) {
                alert(`Kelompok ${kelompok} berhasil disimpan!`);
            }
        });
    });
});

</script>
</body>
</html>
