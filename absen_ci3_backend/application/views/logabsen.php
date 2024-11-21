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
        </style>
<?php
        
    echo "<table style='border-collapse:collapse' border='1' width='1600px'> ";
    echo "<tr style='font-weight:bold' class='tr'><td>Dosen</td><td>Fordis</td><td>Judul Fordis</td><td>Last upd by</td><td>Total Data</td><td>Url</td><td>Detail</td></tr>";
    // dbg($hasil);
    $urii = base_url("absenlog/");
    foreach($hasilnya as $key => $value){
        $dsn = UW($value->obj_dosen);                    
        $frd = UW($value->obj_fordis);
        $frt = UW($value->obj_fordis_title);
        $abs = $value->total_url_matkul;
        $adm = $value->updrec_by;
        $url = $value->obj_url;
        $dtl = $value->dm_id;
        if($abs==1){
            $cls="class='red'";
        }else{
            $cls="";
        }
        echo "<tr $cls><td>".$dsn."</td><td>".$frd."</td><td>".$frt."</td><td>".$adm."</td><td>".$abs."</td><td><a href='".$url."'>".$url."</a></td><td><a href='".$urii.$dtl."'>Open</a></td></tr>";
    }
    echo "</table> ";
?>
</body>