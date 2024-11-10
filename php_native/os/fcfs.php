
<?php
$menu="fcfsdisk";
include "indexe.php";
echo $name = ucwords("FCFS DISK");
include("grafik.php");
echo "<br/>";
if(isset($_GET["nilai"])){
  $mulai = $_GET["mulai"];
  $nilai = $_GET["nilai"];
  $metode = $_GET["metode"];
  $asli  = explode(",",$nilai);  
}else{
  $mulai = 35;
  $nilai = "150,70, 100, 179, 34, 160, 92, 111, 51, 125";
}
$string = $nilai;
$array = array_map('intval', explode(",", $string));
$angkas = $array;
$head = $mulai;
$totalMovement = 0;
$gerak = [];
$kepala = $head;
$last =  count($angkas);
foreach ($angkas as $key => $angka) {
    $movement = abs($kepala - $angka);
    if($key<>$last -1 ){
      $plus = "+";
    }else{      
      $plus = "";
    }
    $geraks[] = "($kepala - $angka)$plus";
    $hasilnya[] = $movement.$plus;

    $totalMovement += $movement;
    $kepala = $angka;
}
echo "Langkah Perhitungan FCFS:<br>";
echo "<br/>";
echo implode($geraks);
echo "<br/>";
echo implode( $hasilnya);
echo "<br>Total Pergerakan Head: $totalMovement";
?>
