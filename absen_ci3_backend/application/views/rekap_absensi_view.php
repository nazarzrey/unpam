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
            /* display: block; */
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
        .t1{width: 300px;}
        .t2{width:100px}
    </style>
</head>
<body>
    <h2>Rekap Absensi - Minggu ke : <?php echo $week." (".getLastDateOfCurrentWeek($week,1,6)["date"].date("-Y").")"; ?></h2>
    <a href="<?= base_url('grup/'. (($week - 1)>=8?($week - 1):"#")); ?>">Prev</a>
    <a href="<?= base_url('grup/'. (($week + 1)<=date("W")-1?($week + 1):"#")); ?>">Next</a>
    <?php 
    // dbg($matkul_data);
    ?>
    <table border="1">
        <thead>
            <tr>
                <th class='t1'>Sync</th>
                <?php foreach ($matkul_data as $matkul): ?>
                    <th class='sync t2'><?php echo $matkul['sync']; ?></th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <th class='t1'>Nama</th>
                <?php foreach ($matkul_data as $matkul): ?>
                    <th class='t2'><?php echo substr($matkul['matkul_singkat'], 0, 3); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rekap_absensi as $rekap): ?>
                <tr>
                    <td class='t1'><?php echo $rekap['nama']; ?></td>
                    <?php
                    foreach ($matkul_data as $matkul) {
                        $id_matkul = $matkul['id_matkul'];
                        $absen_count = $rekap[$id_matkul];
                        $min_absen = $matkul['min_absen'];
                        if ($absen_count == 'Offline') {
                            echo "<td class='empty'>" . ($absen_count == 'Offline' ? '-' : $absen_count) . "</td>";
                        } else {
                            if ($absen_count == 0) {
                                $class = "merah";
                            } elseif ($absen_count < $min_absen) {
                                $class = "kurang";
                            } else {
                                $class = "";
                            }
                            echo "<td class='t2 $class'>" . $absen_count . "</td>";
                        }
                    }
                    ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <script>
        // document.addEventListener('DOMContentLoaded', function () {
        //     const theadHeight = document.querySelector('thead').offsetHeight;
        //     const tableHeight = window.innerHeight - theadHeight - 50; // Adjust the 50 to your needs
        //     document.querySelector('tbody').style.maxHeight = tableHeight + 'px';
        // });
    </script>
</body>
</html>
