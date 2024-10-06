<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
    }

    public function index() {
        $this->load->view('login_view');
    }

    public function authenticate() {
        // dbg($this->uri->segments);
        $nim = $this->input->post('nim');
        $kelas = strtoupper(trim($this->input->post('kelas')));
        if(substr($kelas,0,1)=="0"){
            $kelas = right($kelas,7);
        }
        $user = $this->Login_model->check_login($nim, $kelas);
        if(isset($this->uri->segments[3])){
            $redirect = $this->uri->segments[3];
        }else{
            $redirect = "dashboard";
        };
        if ($user) {
            $this->Login_model->insert_log('login', $nim);
            $this->session->set_userdata('nim', $user->nim);
            $this->session->set_userdata('nama', $user->nama);
            $this->session->set_userdata('tipe', $user->tipe);
            $this->session->set_userdata('kelas', $user->kelas);
            redirect($redirect);
        } else {
            $this->session->set_flashdata('error', 'Invalid NIM or kelas');
            redirect('login');
        }
    }

    public function logout($value="") {
        if(isset($this->uri->segments[3])){
            $redirect = $this->uri->segments[3];
        }else{
            $redirect = "login";
        };
        $this->session->unset_userdata('nim');
        // dbg($this->uri->segments);
        redirect($redirect);
    }
}
