<!DOCTYPE html>
<html>
<head>
    <title>Sistem Pakar Diagnosa Kerusakan Jaringan Internet</title>
</head>
<body>

<h2>Sistem Pakar Diagnosa Kerusakan Jaringan Internet</h2>

<?php
// Daftar Gejala
$gejala = [
    'G01' => 'Koneksi internet di OPD mati total',
    'G02' => 'Tidak bisa melakukan ping ke router distribusi Diskominfotik',
    'G03' => 'Lampu indikator loss pada modem Menyala',
    'G04' => 'Redaman Kabel Tinggi',
    'G05' => 'Lampu indikator power pada modem tidak menyala',
    'G06' => 'Tidak bisa melakukan ping ke router OPD',
    'G07' => 'Lampu indikator power pada router tidak menyala/menyala tidak normal',
    'G08' => 'Lampu indikator power pada switch tidak menyala/menyala tidak normal',
    'G09' => 'Komputer User tidak mendapatkan akses internet',
    'G10' => 'Lampu indikator power pada hub tidak menyala/menyala tidak normal',
    'G11' => 'Tidak mendapatkan akses internet ketika menggunakan perangkat access point',
    'G12' => 'SSID access point tidak terbaca oleh perangkat',
    'G13' => 'Lampu indikator power pada access point tidak menyala',
    'G14' => 'Perangkat access point tidak merespon',
    'G15' => 'Lampu Lampu Indikator port LAN di HUB ke Komputer tidak menyala',
    'G16' => 'Lampu indikator LAN card pada komputer tidak menyala',
    'G17' => 'Status pada network Connection adalah cable unplug',
    'G18' => 'Kabel LAN tidak terpasang dengan baik/rusak',
    'G19' => 'Lampu indikator port LAN pada router yang tehubung ke switch tidak menyala',
    'G20' => 'Lampu indikator port LAN pada switch yang tehubung ke router tidak menyala',
    'G21' => 'Tidak bisa melakukan ping ke router distribusi',
    'G22' => 'Lampu indikator port LAN pada router yang tehubung ke modem tidak menyala',
    'G23' => 'Lampu indikator port LAN pada modem yang tehubung ke router tidak menyala',
    'G24' => 'Status SSID pada Koneksi Access Point No internet/limited access',
    'G25' => 'Lampu indikator LAN pada perangkat access point tidak menyala',
    'G26' => 'Lampu indikator port LAN pada Switch yang tehubung ke Access Point tidak menyala',
    'G27' => 'Lampu indikator LAN card pada komputer tidak menyala',
    'G28' => 'Kondisi kabel LAN dari HUB ke komputer berfungsi dengan baik',
    'G29' => 'Koneksi Internet di OPD tidak stabil dan sangat lambat, Ping time/latency cenderung tinggi, trafik lambat',
    'G30' => 'Loading page lambat saat browsing',
    'G31' => 'Ping ke router OPD putus-putus',
    'G32' => 'Ping ke router Distribusi putus-putus',
    'G33' => 'Tidak bisa melakukan ping ke google atau 8.8.8.8 -t',
    'G34' => 'Perangkat tidak mendapatkan alokasi IP dinamis (DHCP) dari router OPD',
    'G35' => 'Perangkat dapat terhubung ke internet setelah dipasang IP statis'
];

// Relasi Gangguan
$relasiGangguan = [
    'PG01' => ['G01', 'G02', 'G03', 'G04'],
    'PG02' => ['G01', 'G02'],
    'PG03' => ['G01', 'G02', 'G04'],
    'PG04' => ['G01', 'G02', 'G18', 'G22', 'G23'],
    'PG05' => ['G01', 'G06', 'G08'],
    'PG06' => ['G01', 'G06', 'G18', 'G19', 'G20'],
    'PG07' => ['G01', 'G06', 'G08'],
    'PG08' => ['G01', 'G06'],
    'PG09' => ['G21', 'G29', 'G30', 'G31'],
    'PG10' => ['G11', 'G18', 'G24', 'G25', 'G26'],
    'PG11' => ['G11', 'G12', 'G13'],
    'PG12' => ['G11', 'G14'],
    'PG13' => ['G29', 'G34', 'G35'],
    'PG14' => ['G06', 'G09', 'G10']
];

// Nama Gangguan
$namaGangguan = [
    'PG01' => 'Kabel Fiber Optic Rusak/Bermasalah',
    'PG02' => 'Router Distribusi Mati/Bermasalah',
    'PG03' => 'Modem Mati/Rusak',
    'PG04' => 'Kabel LAN dari Modem ke Router Tidak Tersambung/Bermasalah',
    'PG05' => 'Router Mati/Rusak',
    'PG06' => 'Kabel LAN Dari Router ke Switch Tidak Tersambung/Bermasalah',
    'PG07' => 'Switch Mati/Rusak',
    'PG08' => 'Perangkat Modem, Router dan Switch Hang',
    'PG09' => 'Looping',
    'PG10' => 'Kabel LAN dari Switch ke Access Point Tidak Tersambung/Bermasalah',
    'PG11' => 'Perangkat Access Point Rusak/Mati',
    'PG12' => 'Perangkat Access Point Hang',
    'PG13' => 'Collision',
    'PG14' => 'HUB Mati/Rusak'
];
?>

<!-- Tampilkan tabel gejala -->
<h3>Daftar Gejala</h3>
<table border="1">
    <tr>
        <th>Kode Gejala</th>
        <th>Nama Gejala</th>
    </tr>
    <?php foreach ($gejala as $kode => $nama): ?>
    <tr>
        <td><?php echo $kode; ?></td>
        <td><?php echo $nama; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<!-- Form input gejala -->
<h3>Masukkan Kode Gejala</h3>
<form method="POST">
    <input type="text" name="gejala" placeholder="Masukkan kode gejala (mis. G01)">
    <input type="submit" value="Diagnosa">
</form>

<?php
// Proses diagnosa jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gejalaInput = $_POST['gejala'];
    $diagnosa = [];

    // Validasi input
    if (!isset($gejala[$gejalaInput])) {
        echo "<p>Kode gejala tidak valid. Silakan coba lagi.</p>";
    } else {
        // Cari gangguan yang sesuai dengan gejala
        foreach ($relasiGangguan as $kodeGangguan => $listGejala) {
            if (in_array($gejalaInput, $listGejala)) {
                $diagnosa[] = $namaGangguan[$kodeGangguan];
            }
        }

        // Tampilkan hasil diagnosa
        if (count($diagnosa) > 0) {
            echo "<h3>Hasil Diagnosa</h3>";
            echo "<ul>";
            foreach ($diagnosa as $hasil) {
                echo "<li>$hasil</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Tidak ada gangguan yang sesuai dengan gejala yang dimasukkan.</p>";
        }
    }
}
?>

</body>
</html>
