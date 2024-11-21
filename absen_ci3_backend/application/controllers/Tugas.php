<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tugas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Tugas_model');
    }
    public function index() {
        // Ambil data tugas dari database
        $data['tugas'] = $this->Tugas_model->get_all_tugas();

        // Load view untuk menampilkan daftar tugas
        $this->load->view('list_tugas', $data);
    }

    public function simpan() {
        // Ambil data dari POST
        $data = array(
            'judul_tugas' => $this->input->post('judul_tugas'),
            'deskripsi' => $this->input->post('deskripsi'),
            'tanggal_mulai' => $this->input->post('tanggal_mulai'),
            'tanggal_selesai' => $this->input->post('tanggal_selesai'),
            'status' => 'baru' // Default status
        );

        // Simpan ke database
        if ($this->Tugas_model->simpan_tugas($data)) {
            $this->session->set_flashdata('success', 'Tugas berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan tugas.');
        }

        // Redirect ke halaman form (hilangkan POST data)
        redirect('note');
    }
    public function edit($id) {
    // Ambil data tugas berdasarkan ID
    $data['tugas'] = $this->Tugas_model->get_tugas_by_id($id);

    // Tampilkan form dengan data yang sudah ada
    $this->load->view('form_tugas', $data);
}

public function update($id) {
    // Data yang diupdate
    $data = array(
        'judul_tugas' => $this->input->post('judul_tugas'),
        'deskripsi' => $this->input->post('deskripsi'),
        'tanggal_selesai' => $this->input->post('tanggal_selesai')
    );

    if ($this->Tugas_model->update_tugas($id, $data)) {
        $this->session->set_flashdata('success', 'Tugas berhasil diupdate.');
    } else {
        $this->session->set_flashdata('error', 'Gagal mengupdate tugas.');
    }

    redirect('tugas');
}

public function delete($id) {
    if ($this->Tugas_model->delete_tugas($id)) {
        $this->session->set_flashdata('success', 'Tugas berhasil dihapus.');
    } else {
        $this->session->set_flashdata('error', 'Gagal menghapus tugas.');
    }

    redirect('tugas');
}


    public function form() {
        $this->load->view('form_tugas');
    }
}
