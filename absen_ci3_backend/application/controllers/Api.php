
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

// require_once(APPPATH . 'controllers/Settings.php');
// require_once(APPPATH . 'vendor/autoload.php');

// require_once 'vendor/autoload.php';

// use GeoIp2\WebService\Client;

class Api extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mod_query'));
        #$this->load->helper('fungsi');
        
        $sv = $_SERVER['SERVER_NAME'];
        if ($sv == "localhost" || $sv == "127.0.0.1" || substr_count($sv, "192.168") == 1) {
            // dbg($this->uri->rsegments);
        }        
    }
    public function index($value = "", $value2 = "")
    {
      echo "ok";
    }
    public function forum($value = "", $value2 = "", $value3 = ""){
      // dbg($this->uri->segments);
      if($this->uri->segments[4]!=""){
        $this->datajson();
      }else{        
        $this->load->view("forum_view");
      }

    }
    public function courses($value = "", $value2 = ""){
       $lastc =  count($this->uri->segments);
       $uri =  $this->uri->segments[$lastc];
       $data["uri"]= $uri;
      $this->load->view("forum_view",$data);
    }
    // public function datajson($value = "", $value2 = ""){
    //     $jsonFilePath = FCPATH . 'data.json';

    //     if (file_exists($jsonFilePath)) {
    //         $jsonContent = file_get_contents($jsonFilePath);
    //         $data = json_decode($jsonContent, true);

    //         if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    //             // Handle error jika format JSON tidak valid
    //             log_message('error', 'Format JSON tidak valid: ' . json_last_error_msg());
    //             $response = array('status' => 'error', 'message' => 'Format JSON tidak valid.');
    //         } else {
    //             // Data JSON berhasil di-decode
    //             $response = array($data);
    //         }
    //     } else {
    //         // Handle error jika file tidak ditemukan
    //         log_message('error', 'File data.json tidak ditemukan.');
    //         $response = array('status' => 'error', 'message' => 'File data.json tidak ditemukan.');
    //     }

    //     // Mengatur header respons
    //     header('Content-Type: application/json');

    //     // Mengirim respons JSON
    //     echo json_encode($response);
    // }
    public function datajson($value = "", $value2 = ""){
        $jsonFilePath = FCPATH . 'data.json';

        // Cek apakah request datang dari referer yang benar
        $allowed_referer = base_url(); // Misalnya hanya boleh dari halaman utama
        $referer = $this->input->server('HTTP_REFERER');

        if (!$referer || strpos($referer, $allowed_referer) === false) {
            // Kalau bukan dari halaman yang diperbolehkan
            $this->output
                ->set_status_header(401)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Unauthorized']));
            return;
        }

        if (file_exists($jsonFilePath)) {
            $jsonContent = file_get_contents($jsonFilePath);
            $data = json_decode($jsonContent, true);

            if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
                // Handle error jika format JSON tidak valid
                log_message('error', 'Format JSON tidak valid: ' . json_last_error_msg());
                $response = array('status' => 'error', 'message' => 'Format JSON tidak valid.');
            } else {
                // Data JSON berhasil di-decode
                $response = $data;
            }
        } else {
            // Handle error jika file tidak ditemukan
            log_message('error', 'File data.json tidak ditemukan.');
            $response = array('status' => 'error', 'message' => 'File data.json tidak ditemukan.');
        }

        // Mengatur header respons
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

}