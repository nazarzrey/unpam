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
</style>
<div style="position:relative">    
  <a class="mn" href="<?= base_url("dashboard")?>">Absensi</a>
  <a class="mn" href="<?= base_url("grup")?>">Grup Absen</a>
  <a class="mn" href="<?= base_url("login/logout". $redirect)?>">Logout</a>
</div>