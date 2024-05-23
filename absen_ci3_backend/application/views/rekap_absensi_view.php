<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi</title>
    <style>
        .empty {
            background-color: #e6fbff;
        }
        table{border-collapse:collapse}body{font-family:verdana;margin:0}td{font-size:12px;padding:5px 2px;cursor:pointer}th{font-size:14px;padding:5px 0}.tdc{text-align:center}.tdb{background:#f1f1f1}
        .kurang{background:#f3e29f}
        .merah{background:#ffafa1}
        .popup {
            position: absolute; /* Make it absolute for positioning */
            background-color: #fff; /* Set background color */
            border: 1px solid #ccc; /* Add a border */
            padding: 10px; /* Add padding for content */
            display: none; /* Initially hide the popup */
            font-size:14px;
            width:160px
        }
        .tdc:hover{background:tomato}
        .ce{text-align:center}
        .tdc,.tdb{
            <?= $lweek <= 20 ? "width:50px" :"width:40px"; ?>;
            height:20px !important;
        }
        .tr{text-align:right}
        .pert{background:#b1ffcf}
        .judul{padding:10px;font-size:20px}
        .perj{background:#8ae2be;font-size:14px;font-weight:normal}
        .sync{width: 70px;font-size:10px}
        th{text-align:center;padding:10px}
        td{text-align:center;padding:5px 10px}
        tr td:nth-child(2){text-align:left}
    </style>
</head>
<body>
    <h2>Rekap Absensi - Minggu ke <?php echo $week." ".getLastDateOfCurrentWeek($week,1,6)["date"].date("-Y"); ?></h2>
    <table border="1">
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <?php foreach ($matkul_data as $matkul): ?>
                    <th><?php echo substr($matkul['matkul_singkat'], 0, 3); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rekap_absensi as $rekap): ?>
                <tr>
                    <td><?php echo $rekap['nim']; ?></td>
                    <td><?php echo $rekap['nama']; ?></td>
                    <?php
                    foreach ($matkul_data as $matkul) {
                        $id_matkul = $matkul['id_matkul'];
                        $absen_count = $rekap[$id_matkul];
                        $min_absen = $matkul['min_absen'];
                        if($absen_count == 'Offline'){
                            echo "<td class='empty'>" . ($absen_count == 'Offline' ? '-' : $absen_count) . "</td>";
                        }else{
                            if($absen_count==0){
                                $class="class='merah'";
                            }elseif($absen_count<$min_absen){
                                $class="class='kurang'";
                            }else{  
                                $class="";
                            }
                            echo "<td $class>" .$absen_count . "</td>";
                        }
                    }
                    ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
