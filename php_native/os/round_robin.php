<?php
$menu="robin";
include "indexe.php";
echo $name = ucwords("round robin");
function namanim(){
  $dt = "<div style='font-family:monospace;border:solid 1px;width:300px;padding:10px;margin:10px 0'>";
  $dt .= "Nama &nbsp;: Nazarudin";
  $dt .= "<br/>";
  $dt .= "Nim  &nbsp;&nbsp;: 231011450485 ";
  $dt .= "<br/>";
  $dt .= "Kelas : TPLE004 ";
  $dt .= "</div>";
  return $dt;
}
?>

<form method="get" action="" >
  Proses 
  <input name="proses" value="<?= isset($_GET["proses"])?$_GET["proses"]:"" ?>" type="number" >
  Quantum
  <input name="quantum" value="<?= isset($_GET["quantum"])?$_GET["quantum"]:"" ?>" type="number" >
  <input value="Buat" type="submit">
</form>

<?php
if(isset($_GET["proses"])){
  $pr =   $_GET["proses"];
  $qt =   $_GET["quantum"];
  if($pr!="" and $qt!=""){
    echo "<form method='get' action=''>";
    echo "<table border='1'>";
    echo "<thead><th>Proses</th><th>AT</th><th>BT</th><th>CT</th><th>TAT</th><th>WT</th></thead>";
    echo "<tbody>";      
    echo '<input name="proses" type="number" value="'.$pr.'" style="display:none">';
    echo '<input name="quantum" type="number" value="'.$qt.'" style="display:none">';
    for($x=1;$x<=$pr;$x++){
      $input1 = "<input type='number' value='".input("at".$x)."' class='input' name='at".$x."'>";
      $input2 = "<input type='number' value='".input("bt".$x)."' class='input' name='bt".$x."'>";
      echo "<tr><td>P $x</td><td>$input1</td><td>$input2</td><td></td><td></td><td></td><tr>";
    }

    echo "<tr><td colspan='6' >Urut 1/0 <input name='urutan' type='number' value='".(isset($_GET["urutan"])?$_GET["urutan"]:"0")."' style='width:50px'> <button name='submit' type='submit' value='true'>Proses - $name : Quantum = $qt</button>
    </td></tr>";
    echo "</tbody>";
    echo "</table>";
    echo "<form>";
  }else{
    echo "Proses dan quantum harus di isi";
  }
}
echo namanim()
?>

<?php
if(isset($_GET["submit"])){
  $quantum = $_GET["quantum"];
  $n = $_GET["proses"];
  $arrival_time = [];
  $burst_time = [];
  
  for($i=1; $i<=$n; $i++){
    $arrival_time[$i] = $_GET["at".$i];
    $burst_time[$i] = $_GET["bt".$i];
  }
  
  $remaining_bt = $burst_time;
  $time = 0;
  $complete = 0;
  $ct = array_fill(1, $n, 0); // Completion Time
  $tat = array_fill(1, $n, 0); // Turnaround Time
  $wt = array_fill(1, $n, 0); // Waiting Time
  $gantt_chart = [];

  while ($complete < $n) {
    $done = true;
    
    for ($i = 1; $i <= $n; $i++) {
      if ($remaining_bt[$i] > 0) {
        $done = false;
        
        if ($remaining_bt[$i] > $quantum) {
          $gantt_chart[] = ["P".$i, $time, $time + $quantum]; // Simpan urutan eksekusi proses
          $time += $quantum;
          $remaining_bt[$i] -= $quantum;
        } else {
          $gantt_chart[] = ["P".$i, $time, $time + $remaining_bt[$i]]; // Simpan urutan eksekusi proses
          $time += $remaining_bt[$i];
          $ct[$i] = $time; // Set Completion Time
          $remaining_bt[$i] = 0;
          $complete++;
        }
      }
    }

    if ($done) break; // Jika semua proses selesai, keluar dari loop
  }

  // Hitung TAT dan WT
  $ctnya = $_GET["at1"]>0?$_GET["at1"]:0;
  for ($i = 1; $i <= $n; $i++) {
    $tat[$i] = $ct[$i]+$ctnya - $arrival_time[$i];
    $wt[$i] = $tat[$i] - $burst_time[$i];
  }

  // Tampilkan hasil dalam tabel
  echo "<table border='1'>";
  echo "<thead><th>Proses</th><th>AT</th><th>BT</th><th>CT</th><th>TAT</th><th>WT</th></thead>";
  echo "<tbody>";
  $xtat = $xwt = 0;
  for ($i = 1; $i <= $n; $i++) {
    echo "<tr>
            <td>P$i</td>
            <td>{$arrival_time[$i]}</td>
            <td>{$burst_time[$i]}</td>
            <td>{$ct[$i]}</td>
            <td>{$tat[$i]}</td>
            <td>{$wt[$i]}</td>
          </tr>";
          $xtat = $xtat + $tat[$i];
          $xwt = $xwt + $wt[$i];
    IF($i==$n){
      echo "<tr><td colspan='4'>Total</td><td>$xtat</td><td>$xwt</td></tr>";
      echo "<tr><td colspan='4'>Rata - Rata</td><td>".($xtat/$pr)."</td><td>".($xwt/$pr)."</td></tr>";
    }
  }
  echo "</tbody>";
  echo "</table>";

  // Tampilkan Gantt Chart dalam beberapa baris
}
if(isset($_GET["submit"])){
  if($_GET["urutan"]=="0"){
    $quantum = $_GET["quantum"];
    $n = $_GET["proses"];
    $e = "&nbsp;";
    $arrival_time = [];
    $burst_time = [];
  
    for($i=1; $i<=$n; $i++){
        $arrival_time[$i] = $_GET["at".$i];
        $burst_time[$i] = $_GET["bt".$i];
    }
    // sort($arrival_time);
    $remaining_bt = $burst_time;
    // dbg($arrival_time);
    $time = $_GET["at1"]>0?$_GET["at1"]:0;
    $complete = 0;
    $ct = array_fill(1, $n, 0); // Completion Time
    $gantt_chart = [];
  
    while ($complete < $n) {
        $done = true;
        
        for ($i = 1; $i <= $n; $i++) {
            if ($remaining_bt[$i] > 0) {
                $done = false;
                
                if ($remaining_bt[$i] > $quantum) {
                    $gantt_chart[] = ["P".$i, $time, $time + $quantum, $remaining_bt[$i] - $quantum]; // Simpan urutan eksekusi proses
                    $time += $quantum;
                    $remaining_bt[$i] -= $quantum;
                } else {
                    $gantt_chart[] = ["P".$i, $time, $time + $remaining_bt[$i], 0]; // Simpan urutan eksekusi proses
                    $time += $remaining_bt[$i];
                    $remaining_bt[$i] = 0;
                    $complete++;
                }
            }
        }
  
        if ($done) break; // Jika semua proses selesai, keluar dari loop
    }
  }else{
    $quantum = $_GET["quantum"];
    $n = $_GET["proses"];
    $e = "&nbsp;";
    $arrival_time = [];
    $burst_time = [];
  
    // Mengambil nilai arrival time dan burst time dari input
    for ($i = 1; $i <= $n; $i++) {
        $arrival_time[$i] = $_GET["at" . $i];
        $burst_time[$i] = $_GET["bt" . $i];
    }
  
    // Buat array gabungan untuk menyimpan arrival time, burst time, dan proses
    $process_data = [];
    for ($i = 1; $i <= $n; $i++) {
        $process_data[] = [
            "process" => "P" . $i,
            "arrival_time" => $arrival_time[$i],
            "burst_time" => $burst_time[$i],
        ];
    }
  
    // Urutkan berdasarkan arrival time
    usort($process_data, function ($a, $b) {
        return $a["arrival_time"] <=> $b["arrival_time"];
    });

    // Debug untuk melihat urutan proses yang sudah diurutkan
    // dbg($process_data);
  
    $remaining_bt = array_column($process_data, 'burst_time');
    $time = $process_data[0]['arrival_time'] > 0 ? $process_data[0]['arrival_time'] : 0;
    $complete = 0;
    $ct = array_fill(1, $n, 0); // Completion Time
    $gantt_chart = [];
  
    while ($complete < $n) {
        $done = true;
        
        for ($i = 0; $i < $n; $i++) { // Loop mulai dari 0 karena data sudah diurutkan
            if ($remaining_bt[$i] > 0) {
                $done = false;
                
                if ($remaining_bt[$i] > $quantum) {
                    $gantt_chart[] = [$process_data[$i]["process"], $time, $time + $quantum, $remaining_bt[$i] - $quantum];
                    $time += $quantum;
                    $remaining_bt[$i] -= $quantum;
                } else {
                    $gantt_chart[] = [$process_data[$i]["process"], $time, $time + $remaining_bt[$i], 0];
                    $time += $remaining_bt[$i];
                    $remaining_bt[$i] = 0;
                    $complete++;
                }
            }
        }
  
        if ($done) break; // Jika semua proses selesai, keluar dari loop
    }
  }
  // dbg($gantt_chart);
    // Tampilkan Gantt Chart dalam bentuk garis
    // echo namanim();
    echo "<h3>Gantt Chart:</h3>";
    echo "<div style='font-family: monospace;'>";

    // Baris sisa waktu
    $remaining_time_line = "";
    // dbg($gantt_chart);
    foreach ($gantt_chart as $key => $entry) {
        [$proc, $start, $end, $remaining] = $entry;
        $duration = $end - $start;
        //$remaining_time_line .= str_pad("+" . $remaining, $duration * 2, " ", STR_PAD_BOTH);
        if($proc=="P1"){          
          if($key==0){            
            $ang = 7;
          }else{
            $ang = 13;
          }
        }else{
          $ang = 13;
        };
        $remaining_time_line .= c($e,$ang).$remaining;
    }

    // Baris proses
    $process_line = "";
    foreach ($gantt_chart as $key => $entry) {
        [$proc, $start, $end] = $entry;
        $duration = $end - $start;
        if($proc=="P1"){          
          if($key==0){            
            $ang = 7;
          }else{
            $ang = 12;
          }
        }else{
          $ang = 12;
        };
        $process_line .= c($e,$ang).$proc;
    }

    // Garis pembatas
    $line = "";
    foreach ($gantt_chart as $entry) {
        [$proc, $start, $end] = $entry;
        $duration = $end - $start;
        $duration = $qt;
        $line .= c("-",13) . "+";
    }

    // Timeline
    $timeline = "0";
    foreach ($gantt_chart as $entry) {
        [$proc, $start, $end] = $entry;
        $duration = $end - $start;
        if($end>10){
          $ang = 11;
        }else{
          $ang = 12;
        }
        $timeline .= c($e,$ang).str_pad($end, $duration * 2 + 1, " ", STR_PAD_LEFT);
    }
    
    // Cetak Gantt Chart
    echo $remaining_time_line . "<br>";
    echo "-".$line . "<br>";
    echo $process_line . "<br>";
    // echo $line . "<br>";
    echo $timeline . "<br>";
  
    echo "</div>";
}
// Fungsi untuk input nilai
function input($name){
  if(isset($_GET[$name])){
    $data = $_GET[$name];
  }else{
    $data = "";
  }
  return $data;
}

function c($char,$leng){
  $has = "";
  for($x=1;$x<=$leng;$x++){
     $has .= $char;
  }
  return $has;
}

	// function dbg($sintak)
	// {
	// 	#echo "<pre>".print_r($sintak,true)."</pre>";
	// 	echo "<pre style=''>" . print_r($sintak, true) . "</pre>";
	// }
include "footer.php";
?>
