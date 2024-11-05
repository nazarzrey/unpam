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
<style>
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
<div class="container">
    <form method="get" action="">
      <div class="input-group">
          <label for="requests">Masukkan permintaan (pisahkan dengan koma):</label>
          <input type="text" id="requests" name="nilai" placeholder="Contoh: 15,70,10,79,34,16,92,11,51,25" value="<?= inputan("15,70,10,79,34,16,92,11,51,25","nilai") ?>">
      </div>
      <div class="input-group">
          <label for="head">Masukkan posisi kepala awal:</label>
          <input type="text" id="head" name="mulai" placeholder="Contoh: 35" value="<?= inputan("35","mulai") ?>">
      </div>
      <div class="input-group">
          <label for="method">Pilih metode:</label>
          <select id="method" style="width: 21vw;">
              <option value="FCFS">FCFS</option>
              <option value="SCAN">SCAN</option>
          </select>
      <button onclick="simulate()">Submit</button>
      </div>
      <div class="output">
          <h2>Output</h2>
          <p id="sequence"></p>
          <p id="totalMovement"></p>
          <div class="chart" id="chart"></div>
      </div>
    </form>
    <br/>
    <?php
    if(isset($_GET["nilai"])){
      $mulai = $_GET["mulai"];
      $nilai = $_GET["nilai"];
      $asli  = explode(",",$nilai);      
      asort($asli);
      $arrayBaru = array_values($asli);

      $ang   = $nilai.",".$mulai;
      $exp = explode(",",$ang);
      asort($exp);
      // dbg($exp);
      $max = max($exp);
      $terakhir = per50($max);
      $row = count($asli);
      // echo char("-",100)
      echo "0";
      $last = 0;
      foreach($exp as $angka){
        $rms = $angka - $last;
        echo char("-",$rms).$angka;
        // echo $angka;
        $last = $angka;
      }
      echo char("-",($terakhir-$last)).$terakhir;
      ln("");
      echo $last = $terakhir - $mulai;
      echo "<br/>";
      echo char(".",$row);
      echo char(".",$mulai+2)."#.";
      echo char(".",$last);
      echo char(".",$row);
      $terakhir = $terakhir + (2*$row);
      $lenchar  = 0;
      for($zre=0;$zre<=$row -1 ;$zre++){
        ln("");
        ln("");
        $nilainya = $asli[$zre];
        echo char("-",2);
        for($rr=0;$rr<=$terakhir;$rr++){
          if($rr==$nilainya){
            echo $nilainya;
          }else{
            echo char("-",1);
          }
        }
        // // dbg($asli);
        // $nilainya = $asli[$zre];
        // // echo $nilainya = $asli[$zre];
        // $last = $terakhir - $nilainya;
        // echo "<br/>";
        // // echo char(".",$nilainya+1)."0.";
        // echo char(".",$nilainya+1).$nilainya;
        // echo char(".",$last);
        // // echo char(".",$terakhir);
        // echo char(".",$row*2);
        // // echo $zre;
        // echo "<br/>";
      }
    }
    ?>
</div>


<script>
    function simulate() {
        const requestsInput = document.getElementById("requests").value;
        const headInput = parseInt(document.getElementById("head").value);
        const method = document.getElementById("method").value;

        if (!requestsInput || isNaN(headInput)) {
            alert("Masukkan permintaan dan posisi kepala awal yang valid.");
            return;
        }

        let requests = requestsInput.split(",").map(Number).filter(n => !isNaN(n));
        let head = headInput;
        let sequence = [];
        let totalMovement = 0;

        // Sorting for SCAN
        if (method === "SCAN") requests.sort((a, b) => a - b);

        // FCFS Calculation
        if (method === "FCFS") {
            sequence = [head, ...requests];
            for (let i = 1; i < sequence.length; i++) {
                totalMovement += Math.abs(sequence[i] - sequence[i - 1]);
            }
        }
        // SCAN Calculation
        else if (method === "SCAN") {
            sequence.push(head);
            const left = requests.filter(r => r < head).reverse();
            const right = requests.filter(r => r >= head);
            sequence = [...sequence, ...right, ...left];
            for (let i = 1; i < sequence.length; i++) {
                totalMovement += Math.abs(sequence[i] - sequence[i - 1]);
            }
        }

        document.getElementById("sequence").textContent = "Urutan Penjadwalan: " + sequence.join(" → ");
        document.getElementById("totalMovement").textContent = "Total Pergerakan Disk: " + totalMovement;

        drawChart(sequence);
    }

    function drawChart(sequence) {
        const chart = document.getElementById("chart");
        chart.innerHTML = ""; // Clear previous chart

        const min = Math.min(...sequence, 0);
        const max = Math.ceil(Math.max(...sequence) / 50) * 50; // Nearest multiple of 50

        const width = chart.clientWidth;
        const step = width / (max - min);

        // Draw line and points
        sequence.forEach((point, index) => {
            const x = (point - min) * step;

            // Line between points
            if (index > 0) {
                const prevX = (sequence[index - 1] - min) * step;
                const line = document.createElement("div");
                line.className = "line";
                line.style.left = Math.min(prevX, x) + "px";
                line.style.width = Math.abs(x - prevX) + "px";
                chart.appendChild(line);
            }

            // Point for each request
            const pointDiv = document.createElement("div");
            pointDiv.className = "point";
            pointDiv.style.left = x + "px";
            chart.appendChild(pointDiv);
        });
    }
</script>
</body>
</html>
