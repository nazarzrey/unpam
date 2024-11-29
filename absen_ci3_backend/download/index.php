<?php
// Directory yang ingin ditampilkan
$directory = './'; // Ganti dengan path folder Anda

// Pastikan direktori ada
if (!is_dir($directory)) {
    die("Direktori tidak ditemukan!");
}

// Ambil daftar file dari direktori
$files = scandir($directory);

// Filter hanya file (bukan folder) dan abaikan file PHP
$files = array_filter($files, function($file) use ($directory) {
    $filePath = $directory . DIRECTORY_SEPARATOR . $file;
    return is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) !== 'php';
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar File</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn,.btnplay {
            display: inline-block;
            padding: 8px 12px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            margin-right: 5px;
        }
        .btnplay {
            background-color: tomato;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Daftar File di Direktori</h1>
    <?php if (empty($files)): ?>
        <p style="text-align: center;">Tidak ada file di direktori ini.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; 
                foreach ($files as $file): 
                    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                    $isMultimedia = in_array(strtolower($fileExtension), ['mp4', 'webm', 'ogg', 'mp3', 'wav']);
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($file) ?></td>
                        <td>
                            <!-- Tombol Download -->
                            <a class="btn" href="download.php?file=<?= urlencode($file) ?>">Download</a>
                            <?php if ($isMultimedia): ?>
                                <!-- Tombol Play -->
                                <a class="btnplay" href="play.php?file=<?= urlencode($file) ?>" target="_blank">Play</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
