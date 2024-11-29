<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TugasKelompok extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('TugasKelompok_model'); // Load model
    }

    public function index() {
        $data['mahasiswa'] = $this->TugasKelompok_model->getMahasiswa();
        $this->load->view('tugas_kelompok', $data);
    }
    
    public function getMataKuliah() {
        $semester = $this->input->post('semester'); // Ambil semester dari request
        $this->db->select('dm_id AS id, matkul_desk AS nama'); // Ambil kolom yang diperlukan
        $this->db->from('unpam_dosen_matkul');
        $this->db->where('matkul_kelas', $semester); // Sesuaikan dengan kolom untuk semester
        $this->db->order_by('matkul_desk', 'ASC'); // Urutkan berdasarkan nama mata kuliah
        $query = $this->db->get();
    
        echo json_encode($query->result_array());
    }
    
    public function getMahasiswa() {
        $mahasiswa = $this->TugasKelompok_model->getMahasiswa();
        echo json_encode($mahasiswa);
    }

    public function saveKelompok() {
        $kelompok = $this->input->post('kelompok');
        $mahasiswa_ids = $this->input->post('mahasiswa_ids');
        $result = $this->TugasKelompok_model->saveKelompok($kelompok, $mahasiswa_ids);
        echo json_encode(['status' => $result ? 'success' : 'error']);
    }

    public function checkKelompok() {
        $matkulId = $this->input->post('matkul_id');
        $hasKelompok = $this->TugasKelompok_model->checkKelompok($matkulId);
        echo json_encode(['hasKelompok' => $hasKelompok]);
    }

    public function clearKelompok() {
        $matkulId = $this->input->post('matkul_id');
        $result = $this->TugasKelompok_model->clearKelompok($matkulId);
        echo json_encode(['status' => $result ? 'success' : 'error']);
    }

    public function createKelompok() {
        $data = [
            'matkul_id' => $this->input->post('matkul_id'),
            'judul_materi' => $this->input->post('judul_materi'),
            'tanggal_presentasi' => $this->input->post('tanggal_presentasi'),
            'recid' => 1
        ];
        $result = $this->TugasKelompok_model->createKelompok($data);
        echo json_encode(['status' => $result ? 'success' : 'error']);
    }
}
