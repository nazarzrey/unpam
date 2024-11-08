
<div class="container" id="form">
    <form method="get" action="">
      <div class="input-group">
          <label for="requests">Masukkan permintaan (pisahkan dengan koma):</label>
          <input type="text" id="requests" name="nilai" placeholder="Contoh: 15,70,10,79,34,16,92,11,51,25" autocomplete="off" value="<?= inputan("150,70, 100, 179, 34, 160, 92, 111, 51, 125","nilai") ?>">
      </div>
      <div class="input-group">
          <label for="head">Masukkan posisi kepala awal:</label>
          <input type="text" id="head" name="mulai" placeholder="Contoh: 35" autocomplete="off" value="<?= inputan("35","mulai") ?>">
      </div>
      <div class="input-group">
          <label for="method">Pilih metode:</label>
          <select id="method" style="width: 21vw;" name="metode">
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
</div>