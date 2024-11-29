<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu</title>
  <style>
    body{background:#1F1F1F;color:#C1CCC1;font-size: 16px !important;padding-top: 10px;} a{color:#C1CCC1}
    input,button{padding: 5px;font-size: 16px;}
    td,th{padding:2px;min-width: 80px;border: solid 1px #fff;}
    td{text-align: center;}
    table{border-collapse: collapse;margin-top: 10px;}
    .input{width: 70px !important;}
    .gancart{font-family: 'Courier New', Courier, monospace;}
    a{text-decoration: none;padding: 10px;border: solid 1px ;margin:2px}
    a:hover{background: #fff;color:#000;border: solid 1px tomato;}
    .font-mono{font-family: 'Courier New', Courier, monospace;}
    .aktif{
      background: #fff;color:#000;
    }
    body { font-family: Arial, sans-serif; }
    .input-group { margin: 10px 0; }
    label { display: block; margin: 5px 0; }
    input[type="text"], select { width: 25vw; padding: 8px; margin-bottom: 10px; }
    button { padding: 10px 20px; font-size: 16px; }
    .output { margin-top: 20px; }
    .chart { position: relative; margin-top: 20px;  }
    .line { position: absolute; height: 2px; background-color: #333; }
    .point { position: absolute; width: 8px; height: 8px; background-color: red; border-radius: 50%; }
  </style>
</head>
<body>
  <?php
  if(isset($menu)){ 
    $menu=$menu; 
  }else{ 
    $menu="";
  }
  ?>

  <a href="round_robin.php" <?= aktif("robin",$menu) ?>>Round Robin</a>
  <a href="round_robin.php">FJS</a>
  <a href="round_robin.php">FCFS</a>
  <a href="disk.php"<?= aktif("disk",$menu) ?>>GHANT CHART DISK</a>
  <a href="fcfs.php"<?= aktif("fcfsdisk",$menu) ?>>FCFS DISK</a>
  <a href="scan.php"<?= aktif("scandisk",$menu) ?>>SCAN DISK</a>
  <a href="#" for="hide"><input type="checkbox" class="hide" id="hide"/><label for="hide" class="hidex" style="display:contents;" > HIDE FORM</label></a>
  <br>
  <br>
  <?php
  
	function dbg($sintak)
	{
		#echo "<pre>".print_r($sintak,true)."</pre>";
		echo "<pre style='background:#ffffffc9;color:#000'>" . print_r($sintak, true) . "</pre>";
	}
  function per50($angka) {
    $hasilBagi = ceil($angka / 50);
    return $hasilBagi * 50;
  }
  function inputan($input,$name){
    if(isset($_GET[$name])){
      return $_GET[$name];
    }else{
      return $input;
    }
  }
  function aktif($input,$menu){
    if($menu==$input){
      echo "class='aktif'";
    }
  }
  function nilai($input){
    // echo strlen($input);
    $rumus = $input / 10;
    // ln("");
    if($input>0){
      if($input<10){
        for($x=1;$x<=$input;$x++){
          echo $x;
        }
      }else{
        for($y=1;$y<=$rumus;$y++){
          for($x=1;$x<=9;$x++){
            echo $x;
          }
        }
      }
    }
  }
  function char($char,$len){
     $newchar ="";
    if($char==""){
      $char = "&nbsp;";
    }
    for($x=1;$x<=$len;$x++){
      $newchar .= $char;
    }
    return "<span class='font-mono'>".$newchar."</span>";
  }
  function ln($val){
    echo $val."<br/>";
  }
  function fcfsdisk($nilai,$mulai){    
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
    echo "<br/>";
    echo "Langkah Perhitungan FCFS:<br>";
    echo "<br/>";
    echo "Urutan Permitaan ".$nilai;
    echo "<br/>";
    echo "Kepala : ".$mulai;
    echo "<br/>";
    echo "<br/>";
    echo implode($geraks);
    echo "<br/>";
    echo "<br/>";
    echo implode( $hasilnya);
    echo "<br/>";
    echo "<br>Total Pergerakan Head: $totalMovement";
  }
  function scandisk($nilai,$mulai){

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
    }
    echo char("-",110);
    echo "<br/>";
    echo "Langkah Perhitungan SCAN:<br>";
    echo "<br/>";
    echo "Urutan Permitaan ".$nilai;
    echo "<br/>";
    echo "Kepala : ".$mulai;
    echo "<br/>";
    echo "<br/>";
    echo implode( $geraks);
    echo "<br/>";
    echo "<br/>";
    echo implode( $hasilnya);
    echo "<br><br>Total Pergerakan Head: $totalgerak";
  }
  function lookdisk($nilai, $mulai) {
    $string = $nilai;
    $array = array_map('intval', explode(",", $string));
    $angkas = $array;
    $head = $mulai;

    // Pisahkan permintaan menjadi kiri dan kanan dari kepala awal
    sort($angkas);
    $left = array_reverse(array_filter($angkas, fn($req) => $req < $head)); // Permintaan di kiri kepala
    $right = array_filter($angkas, fn($req) => $req >= $head); // Permintaan di kanan kepala

    // Gabungkan urutan: kanan -> kiri
    $sequence = array_merge([$head], $right, $left);

    // Inisialisasi variabel untuk perhitungan
    $totalMovement = 0;
    $steps = [];
    $results = [];
    $graphData = [];

    // Hitung pergerakan untuk setiap langkah
    for ($i = 0; $i < count($sequence) - 1; $i++) {
        $a = $sequence[$i];
        $b = $sequence[$i + 1];
        $movement = abs($a - $b);
        $totalMovement += $movement;
        if($a<$b){
          $steps[] = "($b - $a)";
        }else{
          $steps[] = "($a - $b)";
        }
        $results[] = $movement;
        $graphData[] = $a;
    }

    // Tambahkan titik akhir ke grafik
    $graphData[] = end($sequence);

    // Output textual results
    echo "<div style='color: white; font-family: Arial, sans-serif;'>";
    echo "LOOK Scheduling:<br/><br/>";
    echo "Head Movement Sequence: " . implode(" → ", $sequence) . "<br/><br/>";
    echo "Langkah Perhitungan:<br/>";
    echo implode(" + ", $steps) . "<br/><br/>";

    echo "Hasil Tiap Langkah:<br/>";
    echo implode(" + ", $results) . "<br/><br/>";

    echo "Total Pergerakan Head: $totalMovement<br/><br/>";
    echo "</div>";

    // Output graphical chart
    echo "<svg width='1200' height='500' style='border: 1px solid white; margin-top: 20px;'>";

    // Hitung skala grafik (kelipatan 50)
    $min = min($graphData);
    $max = max($graphData);
    $scale = 1000 / ($max - $min); // Scaling for graphical layout
    $paddingTop = 50; // Padding for header alignment

    foreach ($graphData as $i => $point) {
        $x = ($point - $min) * $scale + 50;
        $y = $paddingTop + ($i * 40); // Adjusted for top-to-bottom effect

        // Draw the point
        echo "<circle cx='$x' cy='$y' r='4' fill='red' />";

        // Add the number above the point (aligned properly)
        echo "<text x='$x' y='" . ($y - 10) . "' fill='white' font-size='12' text-anchor='middle'>$point</text>";

        // Draw the connecting line
        if ($i > 0) {
            $prevX = ($graphData[$i - 1] - $min) * $scale + 50;
            $prevY = $paddingTop + (($i - 1) * 40); // Previous point's Y position
            echo "<line x1='$prevX' y1='$prevY' x2='$x' y2='$y' style='stroke:green;stroke-width:2' />";
        }
    }

    echo "</svg>";
    echo "</div>";
  }
  function lookdiskkiri($nilai, $mulai) {
    $string = $nilai;
    $array = array_map('intval', explode(",", $nilai));
    $angkas = $array;
    $head = $mulai;

    // Pisahkan permintaan menjadi kiri dan kanan dari kepala awal
    sort($angkas);
    $left = array_reverse(array_filter($angkas, fn($req) => $req < $head)); // Permintaan di kiri kepala
    $right = array_filter($angkas, fn($req) => $req >= $head); // Permintaan di kanan kepala

    // Gabungkan urutan: kanan -> kiri
    $sequence = array_merge([$head], $left,$right);

    // Inisialisasi variabel untuk perhitungan
    $totalMovement = 0;
    $steps = [];
    $results = [];
    $graphData = [];

    // Hitung pergerakan untuk setiap langkah
    for ($i = 0; $i < count($sequence) - 1; $i++) {
        $a = $sequence[$i];
        $b = $sequence[$i + 1];
        $movement = abs($a - $b);
        $totalMovement += $movement;
        $steps[] = "($a - $b)";
        $results[] = $movement;
        $graphData[] = $a;
    }

    // Tambahkan titik akhir ke grafik
    $graphData[] = end($sequence);

    // Output textual results
    echo "<div style='color: white; font-family: Arial, sans-serif;'>";
    echo "LOOK Scheduling:<br/>";
    echo "Head Movement Sequence: " . implode(" → ", $sequence) . "<br/><br/>";
    echo "Langkah Perhitungan:<br/>";
    echo implode(" + ", $steps) . "<br/><br/>";

    echo "Hasil Tiap Langkah:<br/>";
    echo implode(" + ", $results) . "<br/><br/>";

    echo "Total Pergerakan Head: $totalMovement<br/><br/>";
    echo "</div>";
    // Output graphical chart
    $min = min($graphData);
    $max = max($graphData);
    // asort($graphData);
    // dbg($graphData);
    
    $scale = 1000 / ($max - $min); // Scaling for graphical layout
    echo "<svg width='1200' height='500' style='border: 1px solid white; margin-top: 20px;'>";
    $paddingTop = 50; // Padding for header alignment
    $xPrev = round(200 - ($mulai - $min) * $scale); // Hitung posisi X dari kanan
    $y = 100; // Baris tetap untuk grafik
    
    $yPrev=50;
    $i=0;
    foreach ($graphData as $point) {
        $xNext = round(200 - ($max)+$point * $scale); // Posisi X berikutnya dari kanan
        $y = $paddingTop + ($i * 40); // Buat zigzag dengan jarak vertikal
        if ($i > 0) {
            echo "<line x1='$xPrev' y1='$yPrev' x2='$xNext' y2='$y' style='stroke:green;stroke-width:2;' />";
        }
        // echo $xPrev." # ".$yPrev." # ".$xNext." # ".$y;
        // echo "<br/>";

        echo "<circle cx='$xNext' cy='$y' r='5' fill='red' />";
        // echo "<br/>";
        echo "<text x='$xNext' y='" . ($y - 10) . "' fill='white' font-size='10' text-anchor='middle'>$point</text>";

        // echo "<br/>";
        // Update koordinat sebelumnya
        $xPrev = $xNext;
        $yPrev = $y;
        $i++;
    }

    echo "</svg>";
    echo "</div>";
}


?>

  <script>
    function toggleForm() {
    var checkbox = document.getElementById("hide");
    var formElement = document.getElementById("form");
    
    // Jika checkbox dicentang, sembunyikan elemen 'form', jika tidak, tampilkan
    if (checkbox.checked) {
        formElement.style.display = "none";
    } else {
        formElement.style.display = "block";
    }
}

// Event listener untuk memanggil toggleForm saat status checkbox berubah
document.addEventListener("DOMContentLoaded", function() {
    var checkbox = document.getElementById("hide");
    checkbox.addEventListener("change", toggleForm);

    // Panggil toggleForm saat halaman dimuat untuk menentukan keadaan awal elemen 'form'
    toggleForm();
});
  </script>