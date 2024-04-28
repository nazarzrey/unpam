<?php

error_reporting(0);
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/Settings.php');
// require_once(APPPATH . 'vendor/autoload.php');

// require_once 'vendor/autoload.php';

// use GeoIp2\WebService\Client;

class Backend extends Settings
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mod_query'));
        #$this->load->helper('fungsi');
    }
    public function index($value = "", $value2 = "")
    {
        $data[] = "";
        $uri = $this->uri->segments;
        if (count($uri)) {
            $ua      = $this->getBrowser();
            $kondisi = "and link_url_dynamic='$uri[1]'";
            $table   = "link_data";
            $kolom   = "link_id,link_url_target";
            $url     = $this->Mod_query->Query($table, $kolom, $kondisi);
            $data["lnk_id"] = is_array($uri)?count($uri)==1?$uri[1]:"":"";
            $data["ip"]     = $_SERVER['REMOTE_ADDR'];
            $data["bname"]  = $ua['name'];
            $data["bversi"] = $ua['version'];
            $data["os"]     = $ua['platform'];
            $data["sesi"]   = "x";
            $target         = "https://rotator.sinarlink.com";
            if ($url) {
                $tujuan = $url[0]->link_url_target;
                if (!empty($tujuan)) {
                    $target = $tujuan;
                    $data["lnk_id"] = $url[0]->link_id;
                }
            };
            $data["target"] = $target;
            $this->load->view("visit", $data);
            #redirect($target);
        } else {
            #$this->load->view("welcome", $data);
            
            $ua      = $this->getBrowser();
            
            $url     = $this->Mod_query->sinarlink();
            $data["ip"]     = $_SERVER['REMOTE_ADDR'];
            $data["bname"]  = $ua['name'];
            $data["bversi"] = $ua['version'];
            $data["os"]     = $ua['platform'];
            $data["sesi"]   = "x";
            $data["lnk_id"] = "";
            if ($url) {
                $target = $url->link_url_target;
                $linkid = $url->link_id;
                $data["target"] = $target;
                $data["lnk_id"] = $linkid;
                if (!empty($target)) {
                    $this->load->view("visit", $data);
                }else{
                    $this->load->view("rotator", $data);
                }
            };
        };
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
