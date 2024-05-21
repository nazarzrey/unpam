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
            .red{background:#efc9ae}
            .blk{background:#ccc}
            h4{margin:0;padding:3px}
            body{font-family:tahoma}
        </style>
<?php
    echo "<table style='border-collapse:collapse' border='1' width='100%'> ";
    echo "<tr style='font-weight:bold' class='tr'><td>Nama</td><td>Absen</td><td>Rating</td></tr>";
    // dbg($hasil);
    if(isset($master)){
        echo "<h4>DOSEN : ".$master->matkul_dosen." ( ABSEN  : ".$master->matkul_min_absen." )</h4>";
        echo "<h4>FORDIS : ".$master->matkul_fordis."</h4>";
        echo "<h4>JUDUL FORDIS : ".$master->matkul_fordis_title."</h4>";
        foreach($hasilnya as $key => $value){
            $nam = UW($value->nama);                    
            $abs = UW($value->absen);
            $has = UW($value->hasil);
            if($abs==1){
                $cls="class='red'";
            }elseif($abs==0){
                $cls="class='blk'";
            }else{
                $cls="";
            }
            echo "<tr $cls><td>".$nam."</td><td>".$abs."</td><td>".$has."</td></tr>";
        }
    }
    echo "</table> ";
?>
</body>