<?php
// Directory file
$directory = './'; // Ganti dengan path folder Anda

// Ambil nama file dari parameter URL
if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filePath = $directory . DIRECTORY_SEPARATOR . $file;

    // Pastikan file ada
    if (file_exists($filePath)) {
        $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $mimeType = '';

        // Tentukan MIME type berdasarkan ekstensi file
        switch ($fileExtension) {
            case 'mp4': $mimeType = 'video/mp4'; break;
            case 'webm': $mimeType = 'video/webm'; break;
            case 'ogg': $mimeType = 'video/ogg'; break;
            case 'mp3': $mimeType = 'audio/mpeg'; break;
            case 'wav': $mimeType = 'audio/wav'; break;
            default: die("Format file tidak didukung.");
        }

        // Tampilkan player di browser
        header('Content-Type: ' . $mimeType);
        header('Content-Disposition: inline');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        echo "File tidak ditemukan.";
    }
} else {
    echo "File tidak ditentukan.";
}
