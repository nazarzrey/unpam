<body>
        <style>
        tr:hover {
                background-color: #ccc;
            }

            tr:hover td {
                background-color: transparent; /* or #000 */
            }
            td{padding:2px 5px}
        </style>
<form name="cekdosen" action="" method="GET">
    Input nama / nim
</br>
    <input type="text" name="ceknama">
    <input type="submit" value="test">
</form>
<?php
    if(isseT($_GET["ceknama"])){
        $nm = $_GET["ceknama"];
        if($nm=="all"){
            $sql = "select * from absen_mahasiswa order by nama,matkul_dosen,matkul_fordis";
        }else{            
            $sql = "select * from absen_mahasiswa where nama like '%$nm%' or nim like '%$nm%'";
        }
        $hasil = each_query($this->db->query($sql));
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
?>
</body>