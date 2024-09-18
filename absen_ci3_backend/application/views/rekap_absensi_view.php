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
        .btn,.btn1{
            padding:5px;
            border: radius 5px;
            background:green;
            text-decoration:none;
            color:#fff;
            margin:2px;
            border-radius:5px;
        }
        .btn1{background:blue}
        .susulan{
            color:blue
        }
        .tr:hover{border:solid 2px;background:#e6fbff !important;cursor:pointer}
        .tno{width: 30px;}
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
    </div>
    <div style="float:right">
        <input type="checkbox" id="toggleCheckbox">
        <label for="toggleCheckbox">Munculkan Angka</label>
    </div>
    <?php 
    // dbg($matkul_data);
    ?>
    <table border="1">
        <thead>
            <tr>
                <th class='tno' rowspan='2'>No</th>
                <th class='t1'>Sync</th>
                <?php
                // dbg($matkul_data);
                ?>
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

            <?php 
            // dbg($rekap_absensi);
            $z = 1;
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
                    ?>
                    <td class=''><?= $z ?></td>
                    <td class='t1 tl <?= $csus ?>'><?php echo Uw($rekap['nama'])." ".$susul; ?></td>
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
                                $class = "checked";
                            }
                            echo "<td class='t2 $class'>" . $absen_count . "</td>";
                        }
                    }
                    ?>
                </tr>
            <?php $z++; endforeach; ?>
        </tbody>
    </table>
    <script>
        document.getElementById('toggleCheckbox').addEventListener('change', function() {
            const isChecked = this.checked;
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
        });

        // Save original values in data attribute and set initial state to checkmark
        document.querySelectorAll('td.checked').forEach(cell => {
            cell.setAttribute('data-original', cell.innerHTML);
            cell.innerHTML = '&#x2713;'; // Initial state with checkmark symbol
            cell.style.color = 'green';
        });
    </script>
</body>
</html>
