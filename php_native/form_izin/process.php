<?php
require_once 'config.php';

// Tangkap data dari form
$nama = $_POST['nama'];
$tanggal = $_POST['tanggal'];
$alasan = $_POST['alasan'];
$fotoName = $_FILES['foto']['name'];
$fotoTmpName = $_FILES['foto']['tmp_name'];

// Simpan foto ke folder uploads
$target_dir = "uploads/";
$target_file = $target_dir . basename($fotoName);
move_uploaded_file($fotoTmpName, $target_file);

// Buat thumbnail
$thumb_target_dir = "uploads/thumbnails/";
$thumb_target_file = $thumb_target_dir . "thumb_" . $fotoName;
createThumbnail($target_file, $thumb_target_file, 200);

// Ambil Exif data
$exifData = exif_read_data($target_file);

// Bersihkan data Exif
$cleanExifData = array();
foreach ($exifData as $key => $value) {
    // Hanya mempertahankan nilai yang merupakan string atau angka
    if (is_string($value) || is_numeric($value)) {
        $cleanExifData[$key] = $value;
    }
}

// Simpan data ke database dalam format JSON
$exifJson = json_encode($cleanExifData);

// Simpan data ke database
$sql = "INSERT INTO izin (nama, tanggal, alasan, foto, exif_data) VALUES ('$nama', '$tanggal', '$alasan', '$fotoName', '$exifJson')";
if ($conn->query($sql) === TRUE) {
    echo "Izin berhasil disimpan.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Fungsi untuk membuat thumbnail dari gambar
function createThumbnail($source, $destination, $maxSize) {
    $info = getimagesize($source);
    $width = $info[0];
    $height = $info[1];

    $thumbWidth = $thumbHeight = $maxSize;

    $sourceImage = imagecreatefromjpeg($source);
    $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);

    imagecopyresampled($thumbImage, $sourceImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);

    imagejpeg($thumbImage, $destination);
}
?>
