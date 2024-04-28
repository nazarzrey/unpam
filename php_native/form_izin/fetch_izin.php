<?php
require_once 'config.php';

$output = '';
$keyword = $_GET['keyword'];

$sql = "SELECT * FROM izin";
if ($keyword != '') {
    $sql .= " WHERE nama LIKE '%$keyword%'";
}
$sql .= " ORDER BY updrec_date DESC"; // Mengurutkan berdasarkan tanggal pembaruan

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $output .= '<div class="card mb-3">';
        $output .= '<div class="card-body row">';
        
        // Kolom Kiri untuk Foto
        $output .= '<div class="col-md-6">';
        $output .= '<img src="uploads/thumbnails/thumb_' . $row['foto'] . '" class="img-fluid float-left mr-3" alt="Foto Izin">';
        $output .= '</div>';
        
        // Kolom Kanan untuk Data Detail dan Exif Data
        $output .= '<div class="col-md-6">';
        // Menampilkan Data Detail
        $output .= '<h5 class="card-title">' . $row['nama'] . '</h5>';
        $output .= '<p class="card-text">Tanggal: ' . $row['tanggal'] . '</p>';
        $output .= '<p class="card-text">Alasan: ' . $row['alasan'] . '</p>';
        // Menampilkan Exif Data
        if ($row['exif_data'] !== null) {
            $exifData = json_decode($row['exif_data'],true); // Decode JSON ke array

            if ($exifData !== null) {
                $output .= '<h6>Exif Data:</h6>';
                if (isset($exifData['DateTimeOriginal'])) {
                    $output .= '<p>Tanggal Foto: ' . $exifData['DateTimeOriginal'] . '</p>';
                }
                // Tambahkan data Exif lainnya yang diinginkan di sini
            } else {
                $output .= '<p>Tidak dapat memproses Exif Data.</p>';
            }
        } else {
            $output .= '<p>Tidak ada Exif Data.</p>';
        }
        $output .= '</div>';
        
        $output .= '</div></div>';
    }
} else {
    $output .= '<p>Tidak ada izin yang ditemukan.</p>';
}

echo $output;

$conn->close();
?>
