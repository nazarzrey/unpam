<?php

error_reporting(0);
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
        
    }
    public function get($value = "", $value2 = "")
    {
        if($value=="link"){
            header('Access-Control-Allow-Origin: *');
            header('Content-type: application/json');
            $data  = $this->Mod_query->get_setting("url");
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
            $sql    = "SELECT a.obj_dosen, a.obj_fordis, a.obj_fordis_title, a.obj_url, a.updrec_by, COUNT(b.url_matkul) AS total_url_matkul 
                        FROM unpam_absen_log a 
                        LEFT JOIN unpam_absensi b ON a.obj_url = b.url_matkul 
                        GROUP BY a.obj_dosen, a.obj_fordis, a.obj_fordis_title, a.obj_url, a.updrec_by 
                        ORDER BY MAX(a.updrec_date) DESC;
                        ";
            $data["hasilnya"] = each_query($this->db->query($sql));
            $this->load->view("logabsen",$data);
        }else{
            echo "variabel belum di pasang..!!";
        }
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
        
        if (empty($data)) {
            http_response_code(400);
            echo json_encode(array("message" => "No data received."));
            return;
        }
        $obj_data = isset($data['data']) ? $data['data'] : null;
        $obj_url = isset($data['url']) ? $data['url'] : null;
        $obj_kelas = isset($data['kelas']) ? $data['kelas'] : null;
        $obj_fordis = isset($data['fordis']) ? $data['fordis'] : null;
        $admin = isset($data['admin']) ? $data['admin'] : null;
        
        if (empty($obj_data) || empty($obj_url) || empty($obj_kelas) || empty($obj_kelas)) {
            http_response_code(400);
            echo json_encode(array("message" => "data masih ada yang kosong, silahkan refresh lagi"));
            return;
        }
        if(strpos($obj_url,"discuss.php")===false){
            http_response_code(400);
            echo json_encode(array("message" => "URL sepertinya salah harus mengandung discuss.php ya"));
            return;
        }
        $url = explode("#",$obj_url)[0];
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
            echo json_encode(array("message" => "data log sudah pernah masuk"));
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
        $this->db->insert('unpam_absen_log', $data_to_insert);
        $arr[] = "Sukses simpan data";
        $dosen = "zre";
        foreach ($obj_data as $item) {
            $mnama = addslashes($item['nama']);
            if(is_numeric(left(substr($mnama, -20),10))){
                $nim = substr($mnama, -20);
                $nama = substr($mnama, 0, -20);
            }else{
                $nim = "Dosen";
                $nama = getNamaTanpaDosen($mnama);
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
        $sql = "select count(1) as ttl from unpam_absen_log where obj_url='$url_matkul' and obj_dosen is null";
        if(single_query($this->db->query($sql))->ttl > 0){
            $upd = "update unpam_absen_log set obj_dosen='$dosen' where obj_url='$url_matkul'";
            $this->db->query($upd);
        }
        //$sql = "select count(1) as ttl from unpam_dosen_matkul where matkul_dosen='$dosen' and matkul_url='$url_matkul' and matkul_kelas='$obj_kelas' and matkul_fordis='$fflow' and matkul_fordis_title='$ftitle'";
        $sql = "select count(1) as ttl from unpam_dosen_matkul where matkul_dosen='$dosen' and matkul_url='$url_matkul' ";
        if(single_query($this->db->query($sql))->ttl == 0){
            $upd = "insert into unpam_dosen_matkul (matkul_dosen,matkul_url,matkul_kelas,matkul_fordis,matkul_fordis_title,updrec_date,updrec_by) values ('$dosen','$url_matkul','$obj_kelas','$fflow','$ftitle',now(),'$admin');";
            $this->db->query($upd);
        }
        echo json_encode(array("message" => $arr));
    }   
    

    public function index($value = "", $value2 = "")
    {
        // $data[] = "";
        // $uri = $this->uri->segments;
        // if (count($uri)) {
        //     $ua      = $this->getBrowser();
        //     $kondisi = "and link_url_dynamic='$uri[1]'";
        //     $table   = "link_data";
        //     $kolom   = "link_id,link_url_target";
        //     $url     = $this->Mod_query->Query($table, $kolom, $kondisi);
        //     $data["lnk_id"] = is_array($uri)?count($uri)==1?$uri[1]:"":"";
        //     $data["ip"]     = $_SERVER['REMOTE_ADDR'];
        //     $data["bname"]  = $ua['name'];
        //     $data["bversi"] = $ua['version'];
        //     $data["os"]     = $ua['platform'];
        //     $data["sesi"]   = "x";
        //     $target         = "https://rotator.sinarlink.com";
        //     if ($url) {
        //         $tujuan = $url[0]->link_url_target;
        //         if (!empty($tujuan)) {
        //             $target = $tujuan;
        //             $data["lnk_id"] = $url[0]->link_id;
        //         }
        //     };
        //     $data["target"] = $target;
        //     $this->load->view("visit", $data);
        //     #redirect($target);
        // } else {
        //     #$this->load->view("welcome", $data);
            
        //     $ua      = $this->getBrowser();
            
        //     $url     = $this->Mod_query->sinarlink();
        //     $data["ip"]     = $_SERVER['REMOTE_ADDR'];
        //     $data["bname"]  = $ua['name'];
        //     $data["bversi"] = $ua['version'];
        //     $data["os"]     = $ua['platform'];
        //     $data["sesi"]   = "x";
        //     $data["lnk_id"] = "";
        //     if ($url) {
        //         $target = $url->link_url_target;
        //         $linkid = $url->link_id;
        //         $data["target"] = $target;
        //         $data["lnk_id"] = $linkid;
        //         if (!empty($target)) {
        //             $this->load->view("visit", $data);
        //         }else{
        //             $this->load->view("rotator", $data);
        //         }
        //     };
        // };
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
            // $loc = file_get_contents($ipapi);
            // $obj = json_decode($loc);
            // dbg($obj);
            // $apiKey = "d36838658fba4812a7e98e430036e5e3"; // Your api key found at: https://www.bigdatacloud.net/customer/account

            // $client = new \BigDataCloud\Api\Client($apiKey);
            // $result = $client->getIpGeolocationFull(['ip' => '116.206.8.12']);

            // dbg($result);
            // $ipapi = "http://www.geoplugin.net/json.gp?ip=" . $ip;
            // $ipapi = "http://ip-api.com/json/".$ip;
            // echo $ipapi = "https://ipapi.co/$ip/json/";

            // $loc = file_get_contents('https://ipapi.co/8.8.8.8/json/');
            // echo $loc;
            // $obj = json_decode($loc);
            #Adeli@bizaR@123.
            // echo $ipapi = "http://ipinfo.io/{$ip}";

            // curl -u "{657304}:{T5taMwQZdvsgSuHH}" \"https://geoip.maxmind.com/geoip/v2.1/city/{ip_address}?pretty";
            #T5taMwQZdvsgSuHH
            // Maxmind GeoIP2 Precision Web Services
            // City https://geoip.maxmind.com/geoip/v2.1/city/<ip>?pretty
            // City https://geoip.maxmind.com/geoip/v2.1/country/<ip>?pretty
            // City https://geoip.maxmind.com/geoip/v2.1/insights/<ip>?pretty
            // Replace userid and key and use info and output as you see fit.


            // $client = new Client(657304, 'T5taMwQZdvsgSuHH');

            // You can also use `$client->city` or `$client->insights`
            // `$client->insights` is not available to GeoLite2 users
            // $record = $client->country('128.101.101.101');

            // print($record->country->isoCode . "\n");

            // $loc = file_get_contents($ipapi);
            // $obj = json_decode($loc);
            // var_dump($obj);
        }
    }
}
