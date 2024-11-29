<?php
// Directory file
$directory = './'; // Ganti dengan path folder Anda

// Ambil nama file dari parameter URL
if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filePath = $directory . DIRECTORY_SEPARATOR . $file;

    // Pastikan file ada
    if (file_exists($filePath)) {
        // Set header untuk download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        echo "File tidak ditemukan.";
    }
} else {
    echo "File tidak ditentukan.";
}
