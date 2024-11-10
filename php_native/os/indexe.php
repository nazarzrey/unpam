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
  <a href="disk.php"<?= aktif("disk",$menu) ?>>DISK</a>
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
    echo "<br><br>Total Pergerakan Head: $totalgerak";}
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