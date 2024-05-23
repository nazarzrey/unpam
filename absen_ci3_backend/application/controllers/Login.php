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
        $nim = $this->input->post('nim');
        $kelas = $this->input->post('kelas');
        $user = $this->Login_model->check_login($nim, $kelas);
        
        dbg($user);
        // die();
        if ($user) {
            $this->session->set_userdata('nim', $user->nim);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid NIM or kelas');
            redirect('login');
        }
    }

    public function logout() {
        $this->session->unset_userdata('nim');
        redirect('login');
    }
}
