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
            text-align: center;
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
            color: green;
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
    // dbg($matkul_data[0]);
    // dbg($matkul_aktif[0]);
    // dbg($matkul_aktif_dtl);
    $matkul_aktif = [
        "matkul_aktif" => $matkul_aktif[0]["matkul_aktif"]
    ];

    $matkul_aktif_array = explode(",", $matkul_aktif["matkul_aktif"]);
    // dbg($matkul_aktif_array);
    echo "<table border='1'>";
    echo "<thead><th>Nama</th>";
    $mt = "";
                    td("&nbsp;","z");
    foreach($matkul_aktif_dtl as $m => $kul) {
        $cari_matkul = $kul["id_matkul"];
        $urlmatkul = $kul["matkul_url"];
        $kodematkul = $kul["matkul_singkat"];
        $jdlmatkul = $kul["judul"];
        if($m>0){
            if($mt!=$kodematkul){
                td("&nbsp;","z");
            }
        }
        td($kodematkul." (".trim(str_replace("-FORUM","",trim($jdlmatkul))).")","c" );
        $mt = $kodematkul;
    }
    echo "</thead>";
    echo "<tbody class='konten'>";
    // dbg($mahasiswa_data);
    foreach($mahasiswa_data as $mhs => $siswa){
        $nim = $siswa["nim"];
        $sex = $siswa["gender"];
        $idm = "";
        echo "<tr>";
        echo td($siswa["alias"],$sex);
                    td("&nbsp;","z");
        $mt = "";
        // dbg($matkul_aktif_dtl);
        foreach($matkul_aktif_dtl as $m => $kul) {
            $cari_matkul = $kul["id_matkul"];
            $urlmatkul = $kul["matkul_url"];
            $minabs = $kul["min_absen"];
            $kodematkul = $kul["matkul_singkat"];
            if($m>0){
                if($mt!=$kodematkul){
                    td("&nbsp;","z");
                }
            }
            if (in_array($cari_matkul, $matkul_aktif_array)) {                
                $sql = "select if(count(1)=0,0,IF(COUNT(1)<$minabs,COUNT(1)-$minabs,'9999')) AS sisa from unpam_absensi where left(nim,12)='$nim' and url_matkul='$urlmatkul'";                 
                $res = single_query($this->db->query($sql));
                if($res->sisa==0){
                    td($res->sisa,"cl1");
                }else{
                    if($res->sisa<$minabs){
                        td($res->sisa,"cl2");
                    }else{
                        td(str_replace("9999","✓",$res->sisa),"");
                    }
                }
            }
             $mt = $kodematkul;
        }
        echo "</tr>";
    }
    echo "</table>";
    function td($val,$align){
        if($align=="l"){
            $alg="class='aleft'";
        }elseif($align=="l"){
            $alg="class='acenter'";
        }elseif($align=="cl1"){
            $alg="class='color1'";
        }elseif($align=="cl2"){
            $alg="class='color2'";
        }elseif($align=="z"){
            $alg="class='color3'";
        }elseif($align=="L"){
            $alg="class='colorl'";
        }elseif($align=="P"){
            $alg="class='colorp'";
        }else{
            $alg = "";            
        }
        echo "<td $alg>$val</td>";
    }
    ?>
    <table border="1">
        <thead>
            <tr>
                <th class='tno' rowspan='2'>No</th>
                <th class='t1'>Sync</th>
                <?php foreach ($matkul_data as $matkul): ?>
                    <th class='sync t2'><?php echo $matkul['sync']; ?></th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <th class='t1'>Nama</th>
                <?php foreach ($matkul_data as $matkul): ?>
                    <th class='t2'><?php echo substr(empty($matkul['matkul_singkat'])?"":$matkul['matkul_singkat'], 0, 3); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <div class='popup'>
	<div class='popupclose' id="popupclose">X</div>
        <div id="copypopup" style="display:block">
            <img src="<?= base_url("assets/images/copy.png") ?>" />
        </div>
        <div id="popupcontent">
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
                echo "*".$link["matkul_singkat"]." (".str_replace("FORUM DISKUSI ","FORDIS ",$link["matkul_fordis"]).") _lastsync_ ".$link["sync"]."* "; 
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
