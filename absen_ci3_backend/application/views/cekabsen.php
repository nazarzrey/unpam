<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dynamic Form</title>
    <style>
        tr:hover {
            background-color: #ccc;
        }
        tr:hover td {
            background-color: transparent;
        }
        td {
            padding: 2px 5px;
        }
        .fl {
            float: left;
            margin-right: 10px;
        }
        .post {
            margin-top: 18px;
            margin-left: 5px;
        }
        .red {
            background: #efc9ae;
        }
        select {
            padding: 3px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('select[name="dosen"]').change(function() {
                var dosen = $(this).val();
                $.ajax({
                    url: 'get_matkul.php',
                    method: 'POST',
                    data: { dosen: dosen },
                    success: function(data) {
                        $('select[name="matkul"]').html(data);
                    }
                });
            });

            $('select[name="matkul"]').change(function() {
                var matkul = $(this).val();
                $.ajax({
                    url: 'get_students.php',
                    method: 'POST',
                    data: { matkul: matkul },
                    success: function(data) {
                        $('#students-table tbody').html(data);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <form action="" method="POST">
        <div class="fl w1" style="width:auto">
            Cari Matkul <a href="">Reset</a>
            </br>
            <?php    
            $kls = $this->uri->segments[2];
            ?>
            <select name="dosen">
                <?php
                $sql = cekopt("dosen_sql", $kls);
                $hasil = each_query($this->db->query($sql));
                echo cekopt("dosen", $kls);
                if (isset($hasil)) {
                    foreach ($hasil as $key => $has) {
                        echo "<option value='$has->dosen'>".Uw($has->dosen)."</option>";
                    }
                }
                ?>
            </select>
            <input type="submit" value="Cek" class="post">
        </div>
    </form>

    <div class="fl w1" style="width:400px">
        &nbsp;
        </br>
        <select name="matkul">
            <option value="">Pilih Matkul</option>
        </select>
    </div>

    <table id="students-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>TTL Absen</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <?php
    function cekopt($val, $kls) {
        $balikan = "";
        if ($val == "dosen") {
            if (isset($_POST["dosen"])) {
                $balikan = "<option value='".$_POST["dosen"]."'>".Uw($_POST["dosen"])."</option>";
            } else {
                $balikan = "<option value='x'>Pilih Dosen</option>";
            }
        }
        if ($val == "dosen_sql") {  
            if (isset($_POST["dosen"])) {
                $balikan =  "select distinct(matkul_dosen) as dosen from unpam_dosen_matkul where  matkul_dosen not like '%".trim($_POST["dosen"])."%' and matkul_kelas='$kls' order by 1";  
            } else {
                $balikan = "select distinct(matkul_dosen) as dosen from unpam_dosen_matkul where matkul_kelas='$kls' order by 1";  
            }
        }
        if ($val == "matkul_sql") {  
            if (isset($_POST["matkul_sql"])) {
                $balikan =  "select distinct(matkul_dosen) as dosen from unpam_dosen_matkul where  matkul_dosen not like '%".trim($_POST["dosen"])."%' and matkul_kelas='$kls' order by 1";  
            } else {
                $balikan = "select matkul_url, matkul_fordis from unpam_dosen_matkul where trim(matkul_dosen) like '%".trim($_POST["dosen"])."%'";  
            }
        }
        return $balikan;
    }
    ?>
</body>
</html>
