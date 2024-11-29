<?php
    if(isset($this->uri->segments[1])){
        $redirect = "/".$this->uri->segments[1];
    }else{
        $redirect = "";
    };
		
?>
<style>
    .mn,.nm,.su,.note,.note2{text-decoration:none;font-size:14px;padding:5px 10px; background:tomato;color:#fff}
    .nm{float:right;background:green}
    .note{background: blue;}
    .note2{background: black;}
	  .su{background:blue;}
    ul {
      list-style: none; /* Menghilangkan titik (bullet) */
      padding: 0; /* Menghapus padding default */
      margin: 0; /* Menghapus margin default */
      display: flex; /* Membuat item menyamping */
      gap: 10px; /* Jarak antar item */
    }

    ul li a {
      text-decoration: none; /* Menghapus garis bawah */
      font-size: 14px;
      padding: 5px 10px;
      background: #ccf357;
      color: #000;
      display: inline-block; /* Supaya padding terlihat */
    }

    ul li a:hover {
      background: darkred; /* Tambahkan efek hover */
      text-decoration: none;
      color: #fff;
    }
    .new_menu{
      padding-top: 10px;
    }
    a:hover{text-decoration: none;color:#fff}
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
  <?php    
	if($this->session->userdata("tipe")=="super"){    
    echo '<a class="note" href="'.base_url("note").'">Form Note</a> ';
    echo '<a class="note2" href="'.base_url("kelompok").'">Form Kelompok</a>';
	}
  ?>
  <a class="mn" href="<?= base_url("login/logout". $redirect)?>">Logout</a>
  <?php    
	if($this->session->userdata("tipe")=="super"){    
    echo "<div class='new_menu'>";
    require_once(APPPATH.'views/menu.php');
    echo "</div>";
	}
  ?>
</div>