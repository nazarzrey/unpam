
<div class="container" id="form">
    <form method="get" action="">
      <div class="input-group">
          <label for="requests">Masukkan permintaan (pisahkan dengan koma):</label>
          <input type="text" id="requests" name="nilai" placeholder="Contoh: 15,70,10,79,34,16,92,11,51,25" autocomplete="off" value="<?= inputan(isset($_GET["nilai"])?$_GET["nilai"]:"","nilai") ?>">
      </div>
      <div class="input-group">
          <label for="head">Masukkan posisi kepala awal:</label>
          <input type="text" id="head" name="mulai" placeholder="Contoh: 35" autocomplete="off" value="<?= inputan(isset($_GET["mulai"])?$_GET["mulai"]:"","mulai") ?>">
      </div>
      <?php
    //   dbg($menu);
      if($menu=="disk"){
      ?>
      <div class="input-group">
          <label for="method">Pilih metode:</label>
          <select id="method" style="width: 21vw;" name="metode">
            <?php
            if (isset($_GET["metode"])) {
                // Mengambil nilai metode dari query string
                $selected_metode = $_GET["metode"];
            } else {
                // Jika tidak ada nilai metode di query string, atur nilai default
                $selected_metode = "";
            }
            ?>
            <option value="FCFS" <?php if ($selected_metode == "FCFS") echo 'selected'; ?>>FCFS</option>
            <option value="SCAN" <?php if ($selected_metode == "SCAN") echo 'selected'; ?>>SCAN</option>
            <option value="LOOK" <?php if ($selected_metode == "LOOK") echo 'selected'; ?>>LOOK</option>
            <option value="LOOKIRI" <?php if ($selected_metode == "LOOKIRI") echo 'selected'; ?>>LOOKIRI</option>
        </select>

      <button onclick="simulate()">Submit</button>
      </div>
      <?php }else{ ?>
      <button onclick="simulate()">Submit</button>
      <?php } ?>
      <div class="output">
          <h2>Output</h2>
          <p id="sequence"></p>
          <p id="totalMovement"></p>
          <div class="chart" id="chart"></div>
      </div>
    </form>
</div>