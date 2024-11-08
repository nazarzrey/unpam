<?php
$menu="scandisk";
include "indexe.php";
echo $name = ucwords("DISK");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Disk Scheduling Simulation</title>
</head>
<body>
    <?php
    include("grafik.php");
    echo "<br/>";
    if(isset($_GET["nilai"])){
      $mulai = $_GET["mulai"]; //15,70,10,79,34,16,92,11,51,25
      $nilai = $_GET["nilai"];  //35
      $metode = $_GET["metode"];
      $asli  = explode(",",$nilai);      
      asort($asli);
      $arrayBaru = array_values($asli);
      $ang   = $nilai.",".$mulai;
      $exp = explode(",",$ang);
      asort($exp);
      $max = max($exp);
      $terakhir = per50($max);
      $row = count($asli);
      echo "0";
      $last = 0;
      foreach($exp as $angka){
        $rms = ($angka - $last)-1;
        echo char("-",$rms).$angka;
        $last = $angka;
      }
        if($metode=="FCFS"){
            echo char("-",($terakhir-$last)).$terakhir;
            for($zre=0;$zre<=$row -1 ;$zre++){
                echo "<br/>";
                echo "<br/>";
                echo "<br/>";
                $nilainya = $asli[$zre];
                $tambah = array_search($nilainya,$arrayBaru);
                if($nilainya<$mulai){
                    echo char("",($nilainya+$tambah) ).$nilainya;
                }else{
                    echo char("",($nilainya+$tambah)-1 ).$nilainya;
                }
            }
            echo "<br>";
            echo "<br>";
            fcfsdisk($nilai,$mulai);
        }else{
            $hasilScan = [];
            sort($exp);
            $posisiAwal = array_search($mulai, $exp);            
            for ($i = 0; $i < $posisiAwal; $i++) {
                $hasilScan[] = $exp[$i];
            }
            rsort($hasilScan);
            $last = count($hasilScan);
            foreach ($hasilScan as $key => $angka) {
                $rms = ($last - $key) - 2;
                echo "<br/>";
                echo "<br/>";
                echo char("", $angka+$rms) . $angka;
                echo char("", ($terakhir-$angka)-$rms);
            }
            $last = count($exp);
            for ($i = $posisiAwal+1 ; $i <= $last-1; $i++) {
                $newhasilScan[] = $exp[$i];
            }
            $last = count($hasilScan);
            foreach ($newhasilScan as $key => $angka) {
                $rms = ($last - $key) ;
                $add = ($rms*$key);
                echo "<br/>";
                echo "<br/>";
                echo char("", $angka+$add).$angka;
                echo char("", ($terakhir-$angka)-$add);
            }
                echo "<br/>";
            echo "<br>";
            echo "<br>";
            scandisk($nilai,$mulai);

        }
        echo "<br/>";
        echo "<br/>";        
    }
    echo char("<br/>",5);
    ?>
</body>
</html>
