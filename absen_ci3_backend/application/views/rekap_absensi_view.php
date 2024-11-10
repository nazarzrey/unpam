<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi</title>
    <style>
        body {
            font-family: Verdana, sans-serif;
            margin: 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 5px 10px;
            text-align: center !important;
            font-weight: bold;
        }
        thead {
            background: #f1f1f1;
            position: sticky;
            table-layout: fixed;
            top: 0;
            z-index: 1;
        }
        tbody {
            overflow-y: auto;
            width: 100%;
        }
        .empty {
            background-color: #e6fbff;
        }
        .kurang {
            background: #f3e29f;
        }
        .merah {
            background: #ffafa1;
        }
        .sync {
            width: 70px;
            font-size: 10px;
        }
        .perj {
            background: #8ae2be;
            font-size: 14px;
            font-weight: normal;
        } 
        .t1 { width: 300px; }
        .t2 { width: 100px; }
        .tl{text-align:left}
        .checked {
            color: blue;
        }
        .btn,.btn1,.btn2{
            padding:5px;
            border: radius 5px;
            background:green;
            text-decoration:none;
            color:#fff;
            margin:2px;
            border-radius:5px;
        }
        .btn1{background:blue}
        .btn2{background:tomato}
        .susulan{
            color:blue
        }
        .tr:hover{border:solid 2px;background:#e6fbff !important;cursor:pointer}
        .tno{width: 30px;}
        .popup{position: absolute;top:1%;right:1px;background:#fff;border:solid 1px;z-index: 999;
            font-size:12px;padding:10px;background:#e6fbff
        }
		.popupclose{position:absolute;right:0;padding:10px;border:solid 1px;text-align:center;top:-1px;right:-1px;font-weight:bold;cursor:pointer;background:#fff}
        #copypopup{
            position:absolute;top:-1px;right:30px;border:solid 1px;text-align:center;font-weight:bold;cursor:pointer;background:#fff
        }
        #copypopup:hover,
        .popupclose:hover{background:tomato}
        #copypopup img{width: 32px;}
        .data_dtl{
            font-family:'Courier New', Courier, monospace;
        }
        .data_dtl a{text-decoration: none;color:blue}
        .data_dtl a:hover{color:red}
        td{text-align: left;}
        .konten td{text-align: center;}
        .kontn .aleft{text-align: left !important;}
        .kontn .acenter{text-align:center !important}
        .color1{background: #fdd3d3;}
        .color2{background: blue;color:#fff}
        .color3{background: #e6fbff !important;border: none;}
        .colorp{background: pink !important;border: none;}
    </style>
</head>
<body>
    <?php 
    // dbg($this->session->userdata);
        if($this->session->userdata("tipe")=="admin"){
            require_once(APPPATH.'views/menu_adm.php');
        }else{
            die("<h1>Anda bukan Admin</h1>");
        }
    ?>
    <div style=" justify-content: space-between;text-align:center !important">
        <h2 style="text-align:center !important;">Rekap Absensi - Minggu ke : <?php echo $week." (".getLastDateOfCurrentWeek($week,1,0)["date"].date("-Y").")"; ?></h2>
    </div>
    <div style="float:left">
    <a class='btn' href="<?= base_url('grup/'. (($week - 1)>=8?($week - 1):"#")); ?>">Prev</a>
    <a class='btn1' href="<?= base_url('grup/'. (($week + 1)<=date("W")-1?($week + 1):"#")); ?>">Next</a>
    <a class='btn2' href="#">Tunggakan</a>
    </div>
    <div style="float:right">
        <input type="checkbox" id="toggleCheckbox">
        <label for="toggleCheckbox">Munculkan Angka</label>
    </div>
    <?php 
    // dbg($matkul_data);
    // dbg($matkul_aktif);
    
    $matkul_aktif = ["matkul_aktif" => $matkul_aktif[0]["matkul_aktif"]];
    $matkul_aktif_array = explode(",", $matkul_aktif["matkul_aktif"]);;
    
            // if (in_array($cari_matkul, $matkul_aktif_array)) { 
            // dbg($matkul_aktif_link);
    ?>
    <table border="1">
        <thead>
            <tr>
                <th class='tno' rowspan='3'>No</th>
                <?php 
                for($xy=0;$xy<=2;$xy++){
                        if($xy==0){
                            echo "<th class='t1'>Sync</th>";
                        }elseif($xy==1){
                            echo "<th class='t1'>Minimal Absen</th>";
                        }else{
                            echo "<th class='t1'>Nama</th>";
                        }
                    $fdsk = "";
                    foreach ($matkul_aktif_link as $keyxy => $matkul){
                        $id_matkul =  $matkul["id_matkul"];
                        if($fdsk!=$id_matkul){
                                echo "<th class='empty'>&nbsp;</th>";
                        }
                        if(in_array($id_matkul, $matkul_aktif_array)) { 
                            if($xy==0){
                                echo "<th class='sync t2'>".$matkul['sync']."</th>";
                            }elseif($xy==1){
                                echo "<th class='t2'>".$matkul['min_absen']."</th>";
                            }else{
                                echo "<th class='t2'>".substr(empty($matkul['matkul_singkat'])?"":$matkul['matkul_singkat']."<br/>".$matkul['fordis'],0,20)."</th>";
                            }
                        }
                        $fdsk=$id_matkul;
                    }
                    echo "</tr>";
                } ?>
        </thead>
        <tbody>

            <?php 
            //dbg($rekap_absensi);
            $z = 1;
            $mangkir = array();
            $nm = "";
			$hadir = 0;
            foreach ($rekap_absensi as $rekap): ?>
                <tr class='tr'>
                    <?php
                    if($rekap["keter"]!=""){ 
                        $susul = "- ".Uw($rekap["keter"]);
                        $csus = "susulan";
                    }else{
                        $susul = "";
                        $csus = "";
                    }
                    // dbg($rekap);
                    ?>
                    <td class=''><?= $z ?></td>
                    <td class='t1 tl <?= $csus ?>'><?php echo Uw($rekap['nama'])." ".$susul; ?></td>
                    <?php
                    $mangkir_dtl = "";         
                    $fdsk = "";     
                    $mangkir_count = 0;  
                    foreach ($matkul_aktif_link as $keyxy => $matkul){
                        $id_matkul      =  $matkul["id_matkul"];
                        $id_matkul_abs  =  $matkul["id_matkul_abs"];
                        $min_absen      =  $matkul["min_absen"];
                        $id_absen_count = $rekap[$id_matkul];
                        if($fdsk!=$id_matkul){
                                echo "<th class='empty'>&nbsp;</th>";
                        }
                        if(is_array($id_absen_count)){
                            // dbg($id_absen_count);
                            if(isset($id_absen_count[$id_matkul_abs])){
                                $absen_count = $id_absen_count[$id_matkul_abs];
                                if ((int)$absen_count == "0") {
                                    $class = "merah";
                                } elseif ($absen_count < $min_absen) {
                                    $mangkir_dtl .= $matkul['matkul_singkat'].":".($min_absen - $absen_count).",";
                                    $class = "kurang";
                                } else {
                                    $class = "checked";
                                }
                                echo "<td class='t2 $class'>" . $absen_count . "</td>";
                                // echo "<th class='t2'>".$absen_count."</th>";
                            }else{           
                                $mangkir_dtl .= $matkul['matkul_singkat'].",";
                                echo "<th class='t2 merah'>0</th>";
                            }
                        }else{
                            $absen_count = $id_absen_count;
                            if ((int)$absen_count == "0") {
                                $class = "merah";
                            } elseif ($absen_count < $min_absen) {
                                $class = "kurang";
                            } else {
                                $class = "checked";
                            }
                            if($absen_count == 0 || $absen_count < $min_absen){
                                $mangkir_dtl .= $matkul['matkul_singkat'].",";
                            }
                            echo "<td class='t2 $class'>" . $absen_count . "</td>";
                        }
                        $fdsk=$id_matkul;
							$hadir ++;
                    }
                    if($nm!=$rekap["alias"]){
                        if(!empty($mangkir_dtl)){
                            $matkul = rtrim($mangkir_dtl, ',');
                            $mangkir[] = Uw($rekap["alias"])." (". $matkul.")";
                        };
                    }       
                    $nm = $rekap["alias"];             
                    ?>
                </tr>
            <?php $z++; endforeach; ?>
        </tbody>
    </table>
    <div class='popup'>
	<div class='popupclose' id="popupclose">X</div>
        <div id="copypopup" style="display:block">
            <img src="<?= base_url("assets/images/copy.png") ?>" />
        </div>
        <div id="popupcontent" style="display:block">
        <?php 
        /*$hari_sekarang = strtolower(date("D"));
        $hari_dalam_minggu = array("wed", "thu", "fri", "sat", "sun");
        if (in_array($hari_sekarang, $hari_dalam_minggu)) { */
        //echo $hadir;
        // dbg($mangkir);
        if($hadir>50){            
            echo "<b>Absen E-learning yang masih belum lengkap</b>";
            echo "<hr>";
            echo "<br>";
            foreach($mangkir as $key => $value){
                echo $value."<br/>";
            }
            echo "<br>";
            echo "<div class='data_dtl' id='data_dtl'>";
            foreach($matkul_aktif_link as $link){
                echo "*".$link["matkul_singkat"]." (".str_replace("FORUM DISKUSI ","FORDIS ",$link["fordis"]).") _lastsync_ ".$link["sync"]."* "; 
                echo "<br/>";
                echo "<a href='".$link["matkul_url"]."' target='_blank'>".$link["matkul_url"]."</a>";
                echo "<br/>";
            }
            echo "</div>";
        }
        //}
        
        ?>
        </div>
    </div>
    <script>
        var popup = document.getElementById('popupclose');  
        var popupcontent = document.getElementById('popupcontent');  
        var popupcontent2 = document.getElementById('data_dtl');  
        var copycontent = document.getElementById('copypopup');  
        popup.addEventListener('click', function () {
            var displayPopup = false;
            if(popupcontent.style.display=="block"){
                popupcontent.style.display = "none";
                copycontent.style.display = "none";
                displayPopup = true
            }else{            
                popupcontent.style.display = "block";
                copycontent.style.display = "block";
                displayPopup = false
            }
            localStorage.setItem('popupState', displayPopup ? 'none' : 'block');
        })
        copycontent.addEventListener('click', function () {
            const target = popupcontent
            navigator.clipboard.writeText(popupcontent.innerText)
                .then(() => {
                    console.log('URI copied to clipboard successfully!');
                    alert("Sudah di Copy silahkan tambahin gula..  :D")
                })
                .catch(err => {
                    console.error('Failed to copy URI to clipboard:', err);
                });

        })

        document.querySelectorAll('td.checked').forEach(cell => {
            cell.setAttribute('data-original', cell.innerHTML);
            cell.innerHTML = '&#x2713;'; 
            cell.style.color = 'green';
        });
        const toggleCheckbox = document.getElementById('toggleCheckbox');

        const savedState = localStorage.getItem('toggleCheckboxState');
        if (savedState === 'checked') {
            toggleCheckbox.checked = true;
        }

        function updateCells(isChecked) {
            const cells = document.querySelectorAll('td.checked');
            cells.forEach(cell => {
                if (isChecked) {
                    cell.innerHTML = cell.getAttribute('data-original');
                    cell.style.color = '';
                } else {
                    cell.innerHTML = '&#x2713;'; // Checkmark symbol
                    cell.style.color = 'green';
                }
            });
            if (localStorage.getItem('popupState')){
                if(localStorage.getItem('popupState')=="block"){
                    popupcontent.style.display = "block";
                    copycontent.style.display = "block";
                }else{
                    popupcontent.style.display = "none";
                    copycontent.style.display = "none";
                }
            }
        }

        updateCells(toggleCheckbox.checked);
        toggleCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            localStorage.setItem('toggleCheckboxState', isChecked ? 'checked' : 'unchecked');
            updateCells(isChecked);
        });
    </script>
</body>
</html>
