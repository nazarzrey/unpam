<?php
// Koneksi ke database
$servername = "localhost:3336";
$username = "root";
$password = "toor";
$dbname = "unpam";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Path folder yang ingin Anda baca
$folderPath = "./";

// Fungsi untuk memeriksa apakah data file sudah ada dalam database
function isFileExists($conn, $filename) {
    $filename = $conn->real_escape_string($filename);
    $sql = "SELECT COUNT(*) AS count FROM file_info WHERE namafile = '$filename'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row["count"] > 0;
}

// Fungsi untuk memasukkan data file ke database jika belum ada
function insertFileData($conn, $filename, $filepath, $ext, $filesize, $tglfile) {
    $filename = $conn->real_escape_string($filename);
    $filepath = $conn->real_escape_string($filepath);
    $ext = $conn->real_escape_string($ext);
    $tglfile = $conn->real_escape_string($tglfile);

    if (!isFileExists($conn, $filename)) {
        $sql = "INSERT INTO file_info (namafile, pathfile, ext, filesize, tglfile) VALUES ('$filename', '$filepath', '$ext', $filesize, '$tglfile')";
        if ($conn->query($sql) === TRUE) {
            echo "Data ".$filename." file berhasil dimasukkan.<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Data ".$filename." sudah ada dalam database.<br/>";
    }
}

// Fungsi untuk membaca folder dan subfolder
function readFolder($conn, $folderPath) {
    if ($handle = opendir($folderPath)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                $filePath = $folderPath . DIRECTORY_SEPARATOR . $entry;
                if (is_dir($filePath)) {
                    // Jika itu adalah folder, baca folder tersebut secara rekursif
                    readFolder($conn, $filePath);
                } else {
                    // Jika itu adalah file, simpan informasi file ke database jika belum ada
                    $fileName = pathinfo($entry, PATHINFO_FILENAME);
                    $fileExt = pathinfo($entry, PATHINFO_EXTENSION);
                    $fileSize = filesize($filePath);
                    $fileModifiedDate = date("Y-m-d H:i:s", filemtime($filePath));
                    insertFileData($conn, $fileName, $filePath, $fileExt, $fileSize, $fileModifiedDate);
                }
            }
        }
        closedir($handle);
    } else {
        echo "Error: Tidak dapat membuka folder.";
    }
}

// Perpanjang batas waktu eksekusi
set_time_limit(0);

// Memanggil fungsi untuk membaca folder utama dan subfolder
readFolder($conn, $folderPath);

$conn->close();
?>
