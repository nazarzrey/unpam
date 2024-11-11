
<?php
$menu="scandisk";
include "indexe.php";
echo $name = ucwords("SCAN DISK");
include("grafik.php");
echo "<br/>";
if(isset($_GET["nilai"])){
  $mulai = $_GET["mulai"]; //15,70,10,79,34,16,92,11,51,25
  $nilai = str_replace(" ","",$_GET["nilai"]);  //35
  if(empty($mulai) || empty($nilai)){
    die("inputan harus di isi");
  }
  $metode = $_GET["metode"];
  $asli  = explode(",",$nilai);  
  
  $string = $nilai;
  $array = array_map('intval', explode(",", $string));
  $angkas = $array;
  $head = $mulai;
  $limit = 0;
  sort($angkas);
  $left = array_filter($angkas, fn($req) => $req < $head);
  $right = array_filter($angkas, fn($req) => $req >= $head);
  $left = array_reverse($left);
  $totalgerak = 0;
  $geraks = [];
  $hasilnya = [];
  $kepala = $head;
  $last =  count($angkas);
  foreach (array_merge($left, [$limit], $right) as  $key  => $angka) {
      $gerak = abs($kepala - $angka);
      if($key<>$last){
        $plus = "+";
      }else{      
        $plus = "";
      }
      $geraks[] = "($kepala - $angka)$plus";
      $hasilnya[] = $gerak.$plus;
      $totalgerak += $gerak;
      $kepala = $angka;
      echo $key;
  }
  echo "Langkah Perhitungan SCAN:<br>";
  echo implode( $geraks);
  echo "<br/>";
  echo "<br/>";
  echo implode( $hasilnya);
  echo "<br><br>Total Pergerakan Head: $totalgerak";
}
?>
