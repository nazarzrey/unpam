<?php
    if(isset($this->uri->segments[1])){
        $redirect = "/".$this->uri->segments[1];
    }else{
        $redirect = "";
    };
		
?>
<style>
    .mn,.nm,.su{text-decoration:none;font-size:14px;padding:5px 10px; background:tomato;color:#fff}
    .nm{float:right;background:green}
	.su{background:blue;}
</style>
<div style="position:relative">    
  <a class="mn" href="<?= base_url("dashboard")?>">Absensi</a>
  <?php  
	if($this->session->userdata('keter')!=""){
		if ($this->session->userdata('keter')=="susulan"){
			echo '<a class="su" href="'.base_url("grup").'">Grup Susulan</a>';
		}else{			
			echo '<a class="mn" href="'.base_url("grup").'">Grup Absen</a>';
		}
	}
  ?>
  <a class="mn" href="<?= base_url("login/logout". $redirect)?>">Logout</a>
</div>