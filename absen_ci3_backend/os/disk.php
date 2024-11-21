<?php
$menu="disk";
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
      $nilai = str_replace(" ","",$_GET["nilai"]);  //35
      if(empty($mulai) || empty($nilai)){
        die("inputan harus di isi");
      }
      $metode = $_GET["metode"];
      $asli  = explode(",",$nilai);      
      asort($asli);
      $arrayBaru = array_values($asli);
      $ang   = $nilai.",".$mulai;
      
    //   dbg($ang);
      $exp = explode(",",$ang);
      asort($exp);
      $max = max($exp);
      $terakhir = per50($max);
      $row = count($asli);
        if($metode=="FCFS"){
      echo "0";
      $last = 0;
      foreach($exp as $angka){
        $rms = ($angka - $last)-1;
        echo char("-",$rms).$angka;
        $last = $angka;
      }
        echo "<br/>";
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
        }elseif($metode=="SCAN"){
      echo "0";
      $last = 0;
      foreach($exp as $angka){
        $rms = ($angka - $last)-1;
        echo char("-",$rms).$angka;
        $last = $angka;
      }
        echo "<br/>";
            $hasilScan = [];
            sort($exp);
            $posisiAwal = array_search($mulai, $exp);            
            for ($i = 0; $i < $posisiAwal; $i++) {
                $hasilScan[] = $exp[$i];
            }
            rsort($hasilScan);
            $last = count($hasilScan);
            foreach ($hasilScan as $key => $angka) {
                $rms = ($last - $key) - 1;
                echo "<br/>";
                echo "<br/>";
                echo char("", $angka+$rms) . $angka;
                echo char("", ($terakhir-$angka)-$rms);
            }
            $last = count($exp);
            for ($i = $posisiAwal+1 ; $i <= $last-1; $i++) {
                $newhasilScan[] = $exp[$i];
            }
            $last = count($newhasilScan);
            // dbg($last);
            $ceklast=$mulai;
                echo "<br/>";
            // dbg($newhasilScan);
            foreach ($newhasilScan as $key => $angka) {
                $rms = $key+3 ;
                $add = ($rms*$key);
                // dbg($rms);
                $add = ($angka-$ceklast)+$rms;
                // dbg($add);
                // dbg($add);
                echo "<br/>";
                echo "<br/>";
                echo char("", $ceklast+$add).$angka;
                // echo char("", ($terakhir-$angka)-$add);
                $ceklast=$angka;
            }
                echo "<br/>";
            echo "<br>";
            echo "<br>";
            scandisk($nilai,$mulai);

        } elseif ($metode == "LOOK") {
            
            // LOOK logic
            lookdisk($nilai, $mulai);
        }elseif ($metode == "LOOKIRI") {
            
            // LOOK logic
            lookdiskkiri($nilai, $mulai);
        }
        echo "<br/>";
        echo "<br/>";        
    }
    echo char("<br/>",5);
    ?>
</body>
</html>
