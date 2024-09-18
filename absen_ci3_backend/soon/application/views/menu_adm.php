<?php
    if(isset($this->uri->segments[1])){
        $redirect = "/".$this->uri->segments[1];
    }else{
        $redirect = "";
    };
?>
<style>
    .mn,.nm{text-decoration:none;font-size:14px;padding:5px 10px; background:tomato;color:#fff}
    .nm{float:right;background:green}
    a:hover{text-decoration:none;color:#ddd}
</style>
<div style="position:relative">    
  <a class="mn btn-sm" href="<?= base_url("dashboard")?>">Absensi</a>
  <a class="mn btn-sm" href="<?= base_url("grup")?>">Grup Absen</a>
  <a class="mn btn-sm bg-dark" href="#" data-toggle="modal" data-target="#exampleModal">Buka ALL E-Learning</a>
  <a class="mn btn-sm" href="<?= base_url("login/logout". $redirect)?>">Logout</a>
  <a class="nm btn-sm" href="">Welcome <?= $this->session->userdata("nama") ?></a>
</div>


<!-- Modal -->
<div class="modalx fadex" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">frm Buka All E-learning</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        // require(APPPATH . 'controllers/Xhr.php');
        // echo $userData = elData(); // Assuming elData() returns user data
        // if(isset($eldata)){
        //     echo $eldata;
        // }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
   
   document.addEventListener('DOMContentLoaded', function() {
            var resultDiv = document.getElementById('result');

            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'Xhr.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    resultDiv.innerHTML = xhr.responseText;
                } else if (xhr.readyState == 4) {
                    resultDiv.innerHTML = 'Terjadi kesalahan.';
                }
            };

            xhr.send('action=elData');
        });
</script>