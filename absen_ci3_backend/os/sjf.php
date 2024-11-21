<?php

// Daftar proses dengan waktu tiba dan burst time masing-masing
$proses = [
    ["nama" => "P1", "waktu_tiba" => 0, "burst_time" => 6],
    ["nama" => "P2", "waktu_tiba" => 1, "burst_time" => 8],
    ["nama" => "P3", "waktu_tiba" => 2, "burst_time" => 7],
    ["nama" => "P4", "waktu_tiba" => 3, "burst_time" => 3],
];

$jumlah_proses = count($proses);
$waktu_selesai = array_fill(0, $jumlah_proses, 0);
$waiting_time = array_fill(0, $jumlah_proses, 0);
$turnaround_time = array_fill(0, $jumlah_proses, 0);
$sudah_selesai = array_fill(0, $jumlah_proses, false);

$waktu = 0;
$sisa_proses = $jumlah_proses;

// Loop sampai semua proses selesai
while ($sisa_proses > 0) {
    $index_terpilih = -1;
    $min_burst_time = PHP_INT_MAX;

    // Pilih proses dengan burst time terkecil yang sudah datang dan belum selesai
    for ($i = 0; $i < $jumlah_proses; $i++) {
        if (!$sudah_selesai[$i] && $proses[$i]["waktu_tiba"] <= $waktu && $proses[$i]["burst_time"] < $min_burst_time) {
            $min_burst_time = $proses[$i]["burst_time"];
            $index_terpilih = $i;
        }
    }

    // Jika ada proses yang bisa dieksekusi
    if ($index_terpilih != -1) {
        $waktu += $proses[$index_terpilih]["burst_time"];
        $waktu_selesai[$index_terpilih] = $waktu;
        $turnaround_time[$index_terpilih] = $waktu - $proses[$index_terpilih]["waktu_tiba"];
        $waiting_time[$index_terpilih] = $turnaround_time[$index_terpilih] - $proses[$index_terpilih]["burst_time"];
        
        $sudah_selesai[$index_terpilih] = true;
        $sisa_proses--;
    } else {
        // Jika tidak ada proses yang bisa dieksekusi, majukan waktu
        $waktu++;
    }
}

// Menampilkan hasil
echo "Proses\tBurst Time\tWaktu Tiba\tWaiting Time\tTurnaround Time\n";
for ($i = 0; $i < $jumlah_proses; $i++) {
    echo $proses[$i]["nama"] . "\t" . $proses[$i]["burst_time"] . "\t\t" . $proses[$i]["waktu_tiba"] . "\t\t" . $waiting_time[$i] . "\t\t" . $turnaround_time[$i] . "\n";
}

// Menghitung rata-rata waiting time dan turnaround time
$total_waiting_time = array_sum($waiting_time);
$total_turnaround_time = array_sum($turnaround_time);
$rata_waiting_time = $total_waiting_time / $jumlah_proses;
$rata_turnaround_time = $total_turnaround_time / $jumlah_proses;

echo "Rata-rata Waiting Time: $rata_waiting_time\n";
echo "Rata-rata Turnaround Time: $rata_turnaround_time\n";
?>
