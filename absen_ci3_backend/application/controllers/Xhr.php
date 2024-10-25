<?php

$sv = $_SERVER['SERVER_NAME'];
if ($sv != "localhost" && $sv != "127.0.0.1" && substr_count($sv, "192.168") != 1) {    
 error_reporting(0);
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
defined('BASEPATH') or exit('No direct script access allowed');
/*
header("Access-Control-Allow-Origin: *");   
header("Content-Type: application/json; charset=UTF-8");    
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");    
header("Access-Control-Max-Age: 3600");    
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");    
*/
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

require_once(APPPATH . 'controllers/Settings.php');
// require_once(APPPATH . 'vendor/autoload.php');

// require_once 'vendor/autoload.php';

// use GeoIp2\WebService\Client;

class Xhr extends Settings
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mod_query'));
        #$this->load->helper('fungsi');
        
        $sv = $_SERVER['SERVER_NAME'];
        if ($sv == "localhost" || $sv == "127.0.0.1" || substr_count($sv, "192.168") == 1) {
            dbg($this->uri->rsegments);
        }
        
    }
    public function semester($value=""){
        if($value!=""){
            return $value;
        }else{            
            $sql = "SELECT konten FROM unpam_setting WHERE jenis='semester'";
            $hasil=single_query($this->db->query($sql))->konten;
            // dbg($hasil);
            return $hasil;
        }
    }
    public function week($value=""){
        if($value!=""){
            return $value;
        }else{            
            $sql = "select ifnull((SELECT WEEK(konten)-(SELECT MIN(WEEK(absen_time)) FROM unpam_absensi) AS time_week FROM unpam_setting WHERE jenis='start_week'),0) as minggu  ";
            $hasil=single_query($this->db->query($sql))->minggu;
            return $hasil;
        }
    }
    public function get($value = "", $value2 = "")
    {
		//dbg($this->uri->segments);
        if($value=="link-get"){
            header('Access-Control-Allow-Origin: *');
            header('Content-type: application/json');
            $data  = $this->Mod_query->get_setting("url-elearning");
            echo json_encode( array("url" => $data[0]->konten));
        }elseif($value=="link-send"){
            header('Access-Control-Allow-Origin: *');
            header('Content-type: application/json');
            $data  = $this->Mod_query->get_setting("url-server");
            echo json_encode( array("url" => $data[0]->konten));
        }elseif($value=="absen"){
            header('Access-Control-Allow-Origin: *');
            header('Content-type: application/json');
            $response = json_encode("http://localhost/web/unpam_project/data.json");
            header('Content-Type: application/json');
            echo $response;
        }elseif($value=="cekabsen"){
            $sql = "call cek_absen('https://e-learning.unpam.id/mod/forum/discuss.php?d=236984','4')";
            $hasil = each_query($this->db->query($sql));
            // echo "<style>body{font-family:thoma}</style>";
            echo "<table border='1' style='border-collapse:collapse'>";
            echo "<tr><td><b>Nama</b></td><td width='100px'><b>Absen</b></td><td  width='100px'><b>hasil</b></td></tr>";
            foreach($hasil as $has){
                echo "<tr><td>".ucwords(strtolower($has->nama))."</td><td> &nbsp;".ucwords(strtolower($has->absen))."</td><td>".ucwords(strtolower($has->hasil))."</td></tr>";
            }
            echo "</table>";
        }elseif($value=="nama"){
            if(empty($value2)){;
                $this->load->view("ceknama");
                // if($value2==""){
                //     echo "nama harus di isi..!! tambahkan di ujung url dengan nama/nazar";
                // }
            }else{
                $sql = "select * from absen_mahasiswa where nama like '%$value2%' or nim like '%$value2%'";
                $hasil = each_query($this->db->query($sql));
                echo "<table style='border-collapse:collapse' border='1' width='100%'> ";
                echo "<tr style='font-weight:bold'><td>No</td><td>Nama</td><td>Matkul</td><td>Fordis</td><td>Judul Fordis</td><td>Dosen</td><td>Absen</td></tr>";
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
        }elseif($value=="url"){
            if(empty($value2)){
                echo "<h3>Tambahkan kelas di ujung url contoh /url/TPLE004<h3>";
            }else{
                $this->load->view("cekurl");
            }
        }elseif($value=="loging"){
            $data[] = "";
            if($value2==""){
                $sql = "SELECT 
                dm.`dm_id`,
                ual.obj_dosen, 
                ual.obj_fordis, 
                ual.obj_fordis_title, 
                ual.obj_url, 
                ual.updrec_by, 
                COUNT(ua.url_matkul) AS total_url_matkul
            FROM 
                unpam_absen_log ual
            JOIN 
                (SELECT 
                    obj_url, 
                    MAX(updrec_date) AS max_updrec_date
                FROM 
                    unpam_absen_log
                GROUP BY 
                    obj_url
                ) latest 
            ON 
                ual.obj_url = latest.obj_url 
                AND ual.updrec_date = latest.max_updrec_date
            LEFT JOIN 
                unpam_absensi ua 
            ON 
                ual.obj_url = ua.url_matkul
            LEFT JOIN 
                unpam_dosen_matkul dm 
            ON
                ual.`obj_url`=dm.`matkul_url`
            GROUP BY 
                ual.obj_dosen, 
                ual.obj_fordis, 
                ual.obj_fordis_title, 
                ual.obj_url, 
                ual.updrec_by,
                ual.updrec_date
            ORDER BY 
                ual.obj_dosen,
                ual.updrec_date DESC;
            ";
                $data["hasilnya"] = each_query($this->db->query($sql));
                $this->load->view("logabsen",$data);
            }else{
                $sql = "SELECT matkul_url,trim(matkul_dosen) as matkul_dosen,matkul_fordis,matkul_fordis_title,IFNULL(matkul_min_absen,'2') AS  matkul_min_absen,
                        IFNULL(MAX(b.`updrec_date`),'') AS updrec_date
                        FROM unpam_dosen_matkul a
                        LEFT JOIN url_log b ON a.`matkul_url`=b.`url`
                        WHERE dm_id='$value2'";                
                $result = single_query($this->db->query($sql));
                $data["master"] = $result;
                $msUrl =$result->matkul_url;
                $msMin= $result->matkul_min_absen;
                $mssyn= $result->updrec_date;
                $sql = "
                SELECT a.nama,a.nim,IFNULL(b.absen,0) AS absen,IFNULL(b.hasil,0) AS hasil FROM unpam_mahasiswa a LEFT JOIN (
                SELECT a.nama,COUNT(1) AS absen,IF(COUNT(1)<$msMin,COUNT(1)-$msMin,IF(COUNT(1)>$msMin,IF(COUNT(1)<6,'Semangat','Luar Biasa'),'standar')) hasil FROM unpam_mahasiswa a
                LEFT JOIN unpam_absensi b ON a.`nama`=b.`nama`
                WHERE url_matkul='$msUrl'
                AND b.nim LIKE '%55201-E'
                GROUP BY a.nama ORDER BY 2 DESC) b ON a.`nama`=b.nama
                ORDER BY 3 DESC;";      
                $data["hasilnya"] = each_query($this->db->query($sql));
                $this->load->view("logabsendtl",$data);                
            }
        }elseif($value=="sync"){
            $sql = "truncate unpam_dosen_matkul;";
            $this->db->query($sql);
            $sql2 = "SELECT obj_dosen,obj_url,obj_fordis,obj_fordis_title FROM unpam_absen_log 
                    GROUP BY obj_url ORDER BY updrec_date DESC;";
            $datanya = each_query($this->db->query($sql2));
            foreach($datanya as $key => $data){
                $ds = trim($data->obj_dosen);
                $ur = $data->obj_url;
                $fd = $data->obj_fordis;
                $ft = $data->obj_fordis_title;
                $sql = "insert ignore into unpam_dosen_matkul (matkul_dosen,matkul_url,matkul_fordis,matkul_fordis_title) values ('$ds','$ur','$fd','$ft')";
                $this->db->query($sql);
            }
        }elseif($value=="log_dtl"){
            $data[] = "";
            $sql    = "SELECT WEEK(MIN(absen_time)) AS min_week,WEEK(CURDATE()) AS max_week,(SELECT COUNT(1) FROM unpam_mahasiswa WHERE IFNULL(keter,'')='') AS ttl_mahasiswa FROM unpam_absensi ";
            $week   = single_query($this->db->query($sql));
            $this->db->order_by("dosen", "asc");
            $dosen = $this->db->get("unpam_matkul");
            $result = each_query($dosen);
            $data["tweek"] = ($week->max_week - $week->min_week) +1;
            $data["fweek"] = $week->min_week;
            $data["lweek"] = $week->max_week;            
            $data["minggu"] = week("");            
            $data["result"] = $result;
            $data["tsiswa"] = $week->ttl_mahasiswa;
            $this->load->view("absendosen",$data);
        }elseif($value=="log_dtl_siswa"){
            if($this->session->userdata('nim')!=""){
                $value2 = $this->session->userdata('nim');
                $kls = $this->session->userdata('kelas');
            }
            if($value2!=""){
                $data[] = "";
                $sql    = "SELECT WEEK(MIN(absen_time)) AS min_week,WEEK(CURDATE()) AS max_week,(SELECT COUNT(1) FROM unpam_mahasiswa WHERE IFNULL(keter,'')='') AS ttl_mahasiswa";
                $sql   .= ",(select nama from unpam_mahasiswa where nim='$value2') as siswa";
                $sql   .= ",(select max(updrec_date) from unpam_absensi) as sync";
                $sql   .= " FROM unpam_absensi ";

                // echo $sql;
                $week   = single_query($this->db->query($sql));
                $dosen  = "SELECT a.*,IFNULL(DATE_FORMAT(MAX(b.updrec_date),'%y-%m-%d %H:%i'),'') AS sync FROM unpam_matkul a LEFT JOIN unpam_absen_log b ON a.`dosen`=b.`obj_dosen`
                            WHERE semester='".$this->semester("")."' and kelas='$kls' 
                            GROUP BY a.`dosen`,matkul ORDER BY dosen ASC";
                $dosen  = $this->db->query($dosen);
                $result = each_query($dosen);
                $data["tweek"] = ($week->max_week - $week->min_week) + 1;
                $data["fweek"] = $week->min_week;
                $data["lweek"] = $week->max_week;  
                $data["minggu"] = $this->week("");
                $data["result"] = $result;
                $data["tsiswa"] = $week->ttl_mahasiswa;
                $data["nim"] = $value2;
                $data["siswa"] = $week->siswa;
                $data["sync"] = $week->sync;
                if(empty($week->siswa)){    
                    $data["tipe"] = "dashboard";                      
                    $this->load->view('login_view',$data);
                }else{
                    $this->load->view("absensimahasiswa",$data);
                }
			}else{
                echo "variabel NIM belum di pasang gitu..!!";
            }
        }elseif($value=="menu"){
            // echo $value;
            $this->load->view("menu");
        }elseif($value=="grup"){
            $data["tipe"] = "grup";
            if($this->session->userdata("nim")==""){
                $this->load->view('login_view',$data);
            }else{
                $this->detail_week($value2);
            }
        }elseif($value=="url-elearning"){
            $sql = "SELECT IFNULL((SELECT konten FROM unpam_setting WHERE jenis='url'),'x') AS konten";
            $qry = $this->db->query($sql);
            $data = each_query($qry);
            echo json_encode($data);
		}elseif($value=="mangkir"){
            $this->load->model('Absensi_model');
            $mahasiswa_data = $this->Absensi_model->get_all_mahasiswa();
            $rekap_absensi = [];
            foreach ($mahasiswa_data as $mahasiswa) {
                $rekap_absensi[$mahasiswa['nim']] = [
                    'nim' => $mahasiswa['nim'],
                    'nama' => trim($mahasiswa['nama']),            
                    'keter' => $mahasiswa['keter']
                ];
                // dbg($matkul_data);
                foreach ($matkul_data as $matkul) {
                    $rekap_absensi[$mahasiswa['nim']][$matkul['id_matkul']] = 0;
                }
            }
            // $data = each_query($qry);
            echo json_encode($rekap_absensi);
		}elseif($value=="makalah"){
				echo "konsep makalh di mari";
        }else{
            echo "variabel belum di pasang..!!";
        }
    }



    public function detail_week($week_number = ""){
        $this->load->model('Absensi_model');
        // Dapatkan nomor minggu saat ini
        if ($week_number === "") {
            $week_number = date('W') - 1;
        }

        // Ambil data absensi, mahasiswa, matkul, dan dosen matkul
        $absensi_data = $this->Absensi_model->get_absensi_by_week($week_number);
        $matkul_aktif = $this->Absensi_model->get_matkul_aktif($week_number);
        $mahasiswa_data = $this->Absensi_model->get_all_mahasiswa();
        $matkul_data = $this->Absensi_model->get_all_matkul();
        $dosen_matkul_week = $this->Absensi_model->get_dosen_matkul_aktif($week_number);

        // dbg($mahasiswa_data);
        // Buat rekap absensi
        $rekap_absensi = [];
        foreach ($mahasiswa_data as $mahasiswa) {
            $rekap_absensi[$mahasiswa['nim']] = [
                'nim' => $mahasiswa['nim'],
                'nama' => trim($mahasiswa['nama']),  
                'alias' => trim($mahasiswa['alias']),                   
                'keter' => $mahasiswa['keter']
            ];
            // dbg($matkul_data);
            foreach ($matkul_data as $matkul) {
                $rekap_absensi[$mahasiswa['nim']][$matkul['id_matkul']] = 0;
            }
        }
        // dbg($matkul_aktif[0]["matkul_aktif"]);
        // Populate attendance data
        // dbg($mahasiswa_data);
        $mtkul_akt = $matkul_aktif[0]["matkul_aktif"];
        foreach ($absensi_data as $absensi) {
            $nnim = substr($absensi['nim'], 0, 12);
            $nnam = $absensi['nama'];
            if($nnim!="Dosen"){
                if (strpos($mtkul_akt,(string)$absensi['id_matkul']) !== false) {
                    if (isset($rekap_absensi[$nnim][$absensi['id_matkul']])) {
                        $rekap_absensi[$nnim][$absensi['id_matkul']]++;
                    }
                }
            }
        }
        // foreach ($rekap_absensi as $nim => $rkpmahasiswa) {
        //     $ceknim =  $rkpmahasiswa["nim"];
        //     foreach($rekap_absensi[$nim] as $keymatkul => $rekap){
        //         if(is_numeric($keymatkul)){
        //             if (strpos($mtkul_akt,(string)$keymatkul) === false) {
        //                 $rekap_absensi[$nim][$keymatkul] = "Offline";
        //             }
        //         };
        //     }
        // }
        foreach ($rekap_absensi as $nim => $rkpmahasiswa) {
            $ceknim = $rkpmahasiswa["nim"];
            foreach ($rekap_absensi[$nim] as $keymatkul => $rekap) {
                
                // Ensure keymatkul is treated as a string
                $keymatkul_str = (string)$keymatkul;

                // Check if keymatkul is numeric and not found in mtkul_akt
                if (is_numeric($keymatkul) && strpos($mtkul_akt, $keymatkul_str) === false) {
                    $rekap_absensi[$nim][$keymatkul] = "Offline";
                }
            }
        }

        $data["week"] = $week_number;
        $data['rekap_absensi'] = $rekap_absensi;
        $data['matkul_data'] = $matkul_data;
        $data['matkul_aktif'] = $matkul_aktif;
        $this->load->view('rekap_absensi_view', $data);
    }



    public function UW($value){
        return ucfirst(strtolower($value));
    }
    public function post($value = "", $value2 = "")
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        if($value=="link"){
            $data  = $this->Mod_query->get_setting("url");
            echo json_encode( array("url" => $data[0]->konten));
        }elseif($value=="absen"){
            $response = json_encode("http://localhost/web/unpam_project/data.json");
            header('Content-Type: application/json');
            echo $response;
        }elseif($value=="reciveabsen"){
            $this->receive_data();
        }

        
    }
    public function receive_data()
    {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        // dbg($data['data'][0]['nama']);
        if (empty($data)) {
            http_response_code(400);
            echo json_encode(array("message" => "No data received."));
            return;
        }
        $obj_dosen  = isset($data['data'][0]['nama']) ? $data['data'][0]['nama'] : null;
        $obj_data   = isset($data['data']) ? $data['data'] : null;
        $obj_url    = isset($data['url']) ? $data['url'] : null;
        $obj_kelas  = isset($data['kelas']) ? $data['kelas'] : null;
        $obj_fordis = isset($data['fordis']) ? $data['fordis'] : null;
        $admin      = isset($data['admin']) ? $data['admin'] : null;
        $matkul     = isset($data['matkul']) ? $data['matkul'] : null;
        $testing    = isset($data['testing']) ? $data['testing'] : true;
        $obj_smster = "";
        $sks        = "";
        if(is_array($matkul)){
            $mtkul  = str_replace(array("[","]"),"",$matkul[0]["pelajaran"]);
            $sks    = trim(substr($mtkul,0,2));
            $matkl = explode("#",substr($mtkul,2,strlen($mtkul)));
            if(is_array($matkl)){
                $matkul = trim($matkl[0]);
                $newobj_kelas = explode(" ",trim($matkl[1]))[0];
                $arr_kelas   = explode(" ",$newobj_kelas);
                // if($obj_kelas == null){
                //     $obj_kelas = right($newobj_kelas,7);
                // }
                // 'insert nama kelas dari dosen inputan awal'
                if (!empty($obj_dosen)) {
                    if (!$this->cekDataDosen($obj_dosen)) {                        
                        $obj_kelas = right($newobj_kelas,7);                   
                        $obj_smster = left($newobj_kelas,2);
                    }
                }
            }
        };
        if($testing){
            if (empty($obj_data) || empty($obj_url) || empty($obj_kelas)) {
                http_response_code(400);
                echo json_encode(array("message" => "data masih ada yang kosong, silahkan refresh lagi"));
                return;
            }
        }
        if(strpos($obj_url,"discuss.php")===false){
            if(strpos($obj_url,"localhost")===false){
                http_response_code(400);
                echo json_encode(array("message" => "URL sepertinya salah harus mengandung discuss.php ya"));
                return;
            }else{        
                $sv = $_SERVER['SERVER_NAME'];
                if ($sv != "localhost" && $sv != "127.0.0.1" && substr_count($sv, "192.168") != 1) {                    
                    http_response_code(400);
                    echo json_encode(array("message" => "lemparan data localhost, ditolak di server live"));
                    return;
                }
            }
        }
        $url = explode(",",explode("#",$obj_url)[0])[0];
        $fordis = $obj_fordis;
        if(is_array($fordis)){
            $ftitle = addslashes($fordis[0]["fordistitle"]);
            $fflow  = $fordis[1]["fordiske"];
        }else{            
            $ftitle = "x";
            $fflow  = "x";
        };
        // echo $ftitle[0]["fordistitle"];
        // Cek apakah data sudah ada dalam database
        $existing_data = $this->db->get_where('unpam_absen_log', array('obj_data' => json_encode($obj_data), 'obj_url' => $url, 'obj_kelas' => $obj_kelas))->row();
        
        //jagaan supaya ga di terusin 
        if ($existing_data) {
            http_response_code(409); // Konflik
            echo json_encode(array("message" => "data log sudah pernah masuk bre"));
            return;
        }
        
    
        // Jika data belum ada, lakukan penyisipan data ke dalam database
        $data_to_insert = array(
            'obj_data' => json_encode($obj_data),
            'obj_url' => $url,
            'obj_kelas' => $obj_kelas,
            'obj_fordis' => $fflow,
            'obj_fordis_title' => $ftitle,
            'updrec_by' => $admin
        );
        $log_insert = array(
            'url' => $url,
            'jenis' => "auto",
            'updrec_date' => date("Y-m-d H:i:s"),
            'updrec_by' => $admin
        );
        $this->db->insert('unpam_absen_log', $data_to_insert);
        $arr[] = "Sukses simpan data";
        $dosen = "";
        $absen_time = "";
        foreach ($obj_data as $item) {
            $mnama = addslashes($item['nama']);
            if(is_numeric(left(substr($mnama, -20),10))){
                $nim = substr($mnama, -20);
                $nama = substr($mnama, 0, -20);
            }else{
                $nim = "Dosen";
                $nama = trim(getNamaTanpaDosen($mnama));
                $dosen = $nama;
            };
            $absen_time = date("Y-m-d H:i:s", strtotime($item['waktu']));
            $postId     = $item["postid"];
            $url_matkul = $url;
            $kelas = $obj_kelas;
            if(empty($postId)){
                $sql = "SELECT count(1) as ttl FROM unpam_absensi WHERE url_matkul='$url' AND nama='$nama' AND  nim='$nim' and kelas='$kelas' AND absen_time='$absen_time'";
            }else{
                $sql = "SELECT count(1) as ttl FROM unpam_absensi WHERE id_post='$postId'";
            }
            if(single_query($this->db->query($sql))->ttl == 0){
                $sql = "INSERT ignore into unpam_absensi (id_post,url_matkul, nama, nim,kelas, absen_time,updrec_by) values ('$postId','$url', '$nama', '$nim','$kelas', '$absen_time','$admin');";
                if($this->db->query($sql)){
                    $arr[] = "<br/>sukses simpan $nama";
                }else{
                    $arr[] = "gagal $nama";
                }
            };
        }
        if($dosen!=""){
            $sql = "select count(1) as ttl from unpam_absen_log where obj_url='$url_matkul' and ifnull(obj_dosen,'')=''";
            if(single_query($this->db->query($sql))->ttl > 0){
                $upd = "update unpam_absen_log set obj_dosen='$dosen' where obj_url='$url_matkul'";
                $this->db->query($upd);
            }            
            if($matkul!=""){
                $sql = "select count(1) as ttl from unpam_dosen_matkul where matkul_dosen='$dosen' and matkul_url='$url_matkul' ";
                if(single_query($this->db->query($sql))->ttl == 0){
                    $upd = "insert ignore into unpam_dosen_matkul (matkul_dosen,matkul_desk,matkul_sks,matkul_url,matkul_kelas,matkul_fordis,matkul_fordis_title,updrec_date,updrec_by,absensi_dosen) values ('$dosen','$matkul','$sks','$url_matkul','$obj_kelas','$fflow','$ftitle',now(),'$admin','$absen_time');";
                    $this->db->query($upd);
                    $arr[] = "sukses insert dosen";
                }else{
                    $ssql = $sql." and matkul_desk='$matkul'";
                    if(single_query($this->db->query($ssql))->ttl == 0){
                        $upd = "update unpam_dosen_matkul set matkul_desk='$matkul' where matkul_url='$url_matkul';";
                        $this->db->query($upd);
                        $arr[] = "sukses update dosen matkul";
                    }                    
                }
            }else{                
                $sql = "select count(1) as ttl from unpam_dosen_matkul where matkul_dosen='$dosen' and matkul_url='$url_matkul' ";
                if(single_query($this->db->query($sql))->ttl == 0){
                    $upd = "insert into unpam_dosen_matkul (matkul_dosen,matkul_url,matkul_kelas,matkul_fordis,matkul_fordis_title,updrec_date,updrec_by,absensi_dosen) values ('$dosen','$url_matkul','$obj_kelas','$fflow','$ftitle',now(),'$admin','$absen_time');";
                    $this->db->query($upd);
                    $arr[] = "sukses insert dosen matkul";
                }
            }
        }
        if($dosen!="" && $matkul!=""){
            $sql = "select count(1) as ttl from unpam_matkul where dosen='$dosen' and matkul='$matkul' ";
            if(single_query($this->db->query($sql))->ttl == 0){
                
                if (empty($obj_smster)){
                    $upd = "insert into unpam_matkul (dosen,matkul,sks,updrec_date,kelas,updrec_by) values ('$dosen','$matkul','$sks',now(),'$kelas','$admin');";
                }else{
                    $upd = "insert into unpam_matkul (dosen,matkul,sks,updrec_date,kelas,updrec_by,semester) values ('$dosen','$matkul','$sks',now(),'$kelas','$admin','$obj_semest');";
                }
                $this->db->query($upd);
            }
        }
        $this->db->insert('url_log', $log_insert);
        echo json_encode(array("message" => $arr));
    }   
    
    public function cekDataDosen($dosen = "")
    {
        
        $sql = "select count(1) as ttl from unpam_matkul where dosen='$dosen'";
        if(single_query($this->db->query($sql))->ttl == 0){
            return false;
        }else{
            return true;
        }
    }

    public function index($value = "", $value2 = "")
    {
    }
    public function visit($vdata = null)
    {
        $data["session"] = $vdata;
        $this->load->view("visit", $data);
    }
    public function generate_dyn($target = "")
    {
        $this->load->view("dyn_create");
    }
    public function daftar_dynurl($target = null)
    {
        $this->form_validation->set_rules("url", "url", "required|trim");

        if ($this->form_validation->run() == true) {
            $url  = $_POST["url"];
            $desk  = $_POST["desk"];
            if ((strpos($url, 'http') === FALSE && strpos($url, 'www') === FALSE) || strlen($url) < 10) {
                $this->session->set_flashdata('result_login', 'alamat link kurang lengkap harus ada http / https atau ada www nya');
                redirect(base_url('create'));
            } else {
                $tbl  = "link_data";
                $klm  = "link_url_dynamic";
                $tipe = "post";
                $key  = $this->Mod_query->dynKey();
                $ins  = array(
                    "link_url_dynamic" => $key,
                    "link_url_target" => $url,
                    "link_desk" => $desk,
                    "updrec_date" => date('y-m-d H:i:s')
                );
                $id   = $key;
                $cek  = $this->Mod_query->updDataForm($tbl, $tipe, $klm, $id, $ins);
                if ($cek) {
                    $newdyn = base_url($key);
                    $this->session->set_flashdata('result_success', 'untuk dynamic url ' . $url . ' adalah <input id="copy-data" value="' . $newdyn . '" readonly class="w-100 btn"/><br/><button type="button" class="btn btn-sm btn-success" id="copy-button">copy url</button>');
                    redirect(base_url('create'));
                }
            }
        } else {
            $this->session->set_flashdata('result_login', 'harap isi dulu alamatnya');
            redirect(base_url('create'));
        }
    }
    public function visit_log($value = "")
    {
        $this->form_validation->set_rules("screen", "screen", "required|trim");
        $this->form_validation->set_rules("device", "device", "required|trim");
        if ($this->input->raw_input_stream == true) {
            $json_data  = json_decode($this->input->raw_input_stream);
            $device     = $json_data->device;
            $screen     = $json_data->screen;
            $tbl  = "link_data_log";
            $ins  = array(
                "link_fk_id" => $json_data->id,
                'log_url'    => "",
                "log_ip"     => $json_data->ip,
                'log_device' => $json_data->device,
                'log_screen' => $json_data->screen,
                'log_browser' => $json_data->browser,
                'log_detail' => $json_data->vbrowser . "|" . $json_data->os,
                "updrec_date" => date('y-m-d H:i:s')
            );
            $klm  = "link_fk_id";
            $tipe = "post";
            $id   = "";
            $cek  = $this->Mod_query->updDataForm($tbl, $tipe, $klm, $id, $ins);
            $target = $json_data->target;
        } else {
            echo "invalid post";
            $target = "https://rotator.sinarlink.com";
        }
        echo $target;
    }
    public function daftar($value = "", $value2 = "")
    {
        echo "daftar";
        $data[] = "";
        $uri = $this->uri->segments;
        // if(strlen($uri))
        // dbg(count($uri));
        // dbg($uri);
        // $this->template('home', $data);
    }

    public function job($ip = "")
    {
        if (strlen($ip)) {

            // $ipapi = "http://www.geoplugin.net/json.gp?ip=" . $ip;

            // $ipapi = "https://api.ipregistry.co/" . $ip . "?key=y26gtsgowgon7wzh";
            // $ipapi = "https://api.ipregistry.co/36.37.99.34?key=y26gtsgowgon7wzh";
            $analitik = $this->Mod_query->analitik("");
            if ($analitik) {
                foreach ($analitik as $key => $value) {
                    echo $value->log_ip . "<br/>";
                    $ip = $value->log_ip;
                    $master = $this->Mod_query->analitik($ip);
                    if ($master) {
                        $tbl  = "link_data_log";
                        $ins  = array(
                            "log_country"     => $master->ip_country,
                            'log_region' => $master->ip_region,
                            'log_city' => $master->ip_city,
                            'log_isp' => $master->ip_isp
                        );
                        $klm  = array("log_ip" => $ip, "log_country" => null);
                        $tipe = "edit";
                        $id   = array($ip, null);
                        $cek = $this->Mod_query->updDataForm($tbl, $tipe, $klm, $id, $ins);
                    } else {
                        $ipapi = file_get_contents("https://api.ipregistry.co/" . $ip . "?key=y26gtsgowgon7wzh");
                        // $ipapi = file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip);
                        $obj  = json_decode($ipapi);
                        $isp  = $obj->connection->domain;
                        $ispx = $obj->connection->organization;
                        $loc  = $obj->location->country->name;
                        $reg  = $obj->location->region->name;
                        $cty  = $obj->location->city;
                        $tbl  = "link_ip";
                        $ins  = array(
                            "ip" => $ip,
                            "ip_country"     => $loc,
                            'ip_region' => $reg,
                            'ip_city' => $cty,
                            'ip_isp' => $isp,
                            'ip_isp_detail' => $ispx,
                            'ip_data' => json_encode($obj),
							'updrec_date' => date('y-m-d H:i:s')
                        );
                        $klm  = "ip";
                        $tipe = "post";
                        $id   = $ip;
                        $this->Mod_query->updDataForm($tbl, $tipe, $klm, $id, $ins);
                    }
                }
            } else {
                echo "data kosong";
            }
        }
    }
}
