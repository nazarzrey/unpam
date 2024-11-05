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
  <a href="disk.php"<?= aktif("disk",$menu) ?>>FCFS DISK</a>
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
  ?>