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
                    $selected = isset($_POST['dosen']) && $_POST['dosen'] == $has->dosen ? 'selected' : '';
                    echo "<option value='$has->dosen' $selected>" . Uw($has->dosen) . "</option>";
                }
            }
            ?>
        </select>
        <input type="submit" value="Cek" class="post">
    </div>
</form>

<?php
if (isset($_POST["dosen"])) {
?>
<form action="" method="POST">
    <div class="fl w1" style="width:400px">
        &nbsp;
        </br>    
        <?php    
        $sql = cekopt("matkul_sql", $kls);
        $hasil = each_query($this->db->query($sql));     
        ?>
        <!-- <select name="matkul"> -->
            <?php
            echo cekopt("matkul", $kls);
            if (isset($hasil)) {
                foreach ($hasil as $key => $has) {
                    $selected = isset($_POST['matkul']) && $_POST['matkul'] == $has->matkul_url ? 'selected' : '';
                    echo "<option value='$has->matkul_url' $selected>" . Uw($has->matkul_fordis) . "</option>";
                }
            }
            ?>
        </select>
        <input type="hidden" name="dosen" value="<?php echo $_POST['dosen']; ?>">
        <input type="submit" value="Cek" class="post">
    </div>
</form>
<?php } ?>

<?php
function cekopt($val, $kls) {
    $balikan = "";
    if ($val == "dosen") {
        if (isset($_POST["dosen"])) {
            $balikan = "<option value='" . $_POST["dosen"] . "'>" . Uw($_POST["dosen"]) . "</option>";
        } else {
            $balikan = "<option value='x'>Pilih Dosen</option>";
        }
    }
    if ($val == "dosen_sql") {
        if (isset($_POST["dosen"])) {
            $balikan = "select distinct(matkul_dosen) as dosen from unpam_dosen_matkul where matkul_dosen not like '%" . trim($_POST["dosen"]) . "%' and matkul_kelas='$kls' order by 1";
        } else {
            $balikan = "select distinct(matkul_dosen) as dosen from unpam_dosen_matkul where matkul_kelas='$kls' order by 1";
        }
    }
    if ($val == "matkul") {
        if (isset($_POST["matkul"])) {
            $sql = "select select matkul_url, matkul_fordis from unpam_dosen_matkul where trim(matkul_url) ='".$_POST["matkul"]."'";
            $has = single_query($this->db->query($sql));
            dbg($has);
            $balikan = "<option value='" . $_POST["matkul"] . "'>" . Uw($_POST["matkul"]) . "</option>";
        } else {
            $balikan = "<option value='x'>Pilih Fordis</option>";
        }
    }
    if ($val == "matkul_sql") {
        if (isset($_POST["matkul"])) {
            $balikan = "select matkul_url, matkul_fordis from unpam_dosen_matkul where trim(matkul_dosen) like '%" . trim($_POST["dosen"]) . "%'";
        } else {
            $balikan = "select matkul_url, matkul_fordis from unpam_dosen_matkul where trim(matkul_dosen) like '%" . trim($_POST["dosen"]) . "%'";
        }
    }
    return $balikan;
}

?>

</body>
</html>
