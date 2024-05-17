<body>
        <style>
        tr:hover {
                background-color: #ccc;
            }

            tr:hover td {
                background-color: transparent; /* or #000 */
            }
            td{padding:2px 5px}
            .w1{width:180px;}
            .fl{float:left}
            .post{margin-top:17px}
        </style>
<form name="cekdosen" action="" method="GET">
    <div class="fl w1">
    nama / nim
    </br>
        <input type="text" name="ceknama" value="<?= iset("ceknama") ?>" autocomplete="off">
    </div>
    <div class="fl w1">
    nama dosen
    </br>
        <input type="text" name="cekdosen" value="<?= iset("cekdosen") ?>"  autocomplete="off">
    </div>
    <input type="submit" value="Cek" class="post">
</form>
<?php
    if(isseT($_GET["ceknama"])){
        $nm = $_GET["ceknama"];
        $ds = $_GET["cekdosen"];
        if($nm=="all"){
            $sql = "select * from absen_mahasiswa ";
            $whr = "";
            $sql2 =  " order by nama,matkul_dosen,matkul_fordis";

        }else{       
            $sql = "select * from absen_mahasiswa ";
            $whr = "where";
            $sql2 =  " (nama like '%$nm%' or nim like '%$nm%')";
        }
        $sql3 = "";
        if(!empty($ds)){
            if($whr=="where"){
                $sql3 = " matkul_dosen like '%$ds%' and ";
            }else{
                $sql3 = " matkul_dosen like '%$ds%' ";
            }
        }
        $ssql = $sql.$whr.$sql3.$sql2;
        $hasil = each_query($this->db->query($ssql));
        if(!isset($hasil)){
            echo "Data ga ketemu..!!";
        }else{
            debug("<p>Total Data input : ".count($hasil)."</p>","r");
            echo "<table style='border-collapse:collapse' border='1' width='100%'> ";
            echo "<tr style='font-weight:bold' class='tr'><td>No</td><td>Nama</td><td>Matkul</td><td>Fordis</td><td>Judul Fordis</td><td>Dosen</td><td>Absen</td></tr>";
            // dbg($hasil);
            foreach($hasil as $key => $value){
                $dsn = UW($value->matkul_dosen);                    
                $frd = UW($value->matkul_fordis);
                $frt = UW($value->matkul_fordis_title);
                $nma = $value->nama=="NAZA RUDIN"?"Nazarudin":UW($value->nama);
                $nim = $value->nim;
                $abs = $value->absen;
                echo "<tr><td>".($key+1)."</td><td>".$nma."</td><td>&nbsp;</td><td>".$frd."</td><td>".$frt."</td><td>".$dsn."</td><td>".$abs."</td></tr>";
            }
            echo "</table> ";
        }
    }
    function iset($nama){
        if($nama=="ceknama"){
            if(isset($_GET["ceknama"])){
                return $_GET["ceknama"];
            }else{
                return "";
            }
        }else{
            if(isset($_GET["cekdosen"])){
                return $_GET["cekdosen"];
            }else{    
                return "";
            }
        }
    }
?>
</body>