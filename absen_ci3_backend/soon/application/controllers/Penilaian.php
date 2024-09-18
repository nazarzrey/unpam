<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mahasiswa_model');
        $this->load->model('MasterSoal_model');
        $this->load->model('Penilaian_model');
    }

    public function index($value="") {
        echo $value;
        $data['mahasiswa'] = $this->Mahasiswa_model->get_all_mahasiswa();
        $data['soal'] = $this->MasterSoal_model->get_all_soal();
        $data['penilaian'] = $this->Penilaian_model->get_penilaian();
        $this->load->view('penilaian_view', $data);
    }
    public function nilai($value="") {
        echo $value;
        $data['mahasiswa'] = $this->Mahasiswa_model->get_all_mahasiswa();
        $data['soal'] = $this->MasterSoal_model->get_all_soal();
        $data['penilaian'] = $this->Penilaian_model->get_penilaian();
        $this->load->view('penilaian_view', $data);
    }

    public function save_nilai() {
        $nim = $this->input->post('nim');
        $matkul = $this->input->post('matkul');
        $id_fk_soal = $this->input->post('id_fk_soal');
        $nilai = $this->input->post('nilai');

        $data = array(
            'nim' => $nim,
            'matkul' => $matkul,
            'id_fk_soal' => $id_fk_soal,
            'nilai' => $nilai,
            'updrec_date' => date('Y-m-d H:i:s'),
            'updrec_by' => 'Admin'
        );

        $this->Penilaian_model->insert_penilaian($data);

        $updated_penilaian = $this->Penilaian_model->get_penilaian();
        echo json_encode($updated_penilaian);
    }
}
?>
