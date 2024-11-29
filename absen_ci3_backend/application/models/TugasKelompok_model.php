<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TugasKelompok_model extends CI_Model {

    // Ambil data mahasiswa yang belum memiliki keter
    public function getMahasiswa() {
        $this->db->select('id, nama, alias');
        $this->db->from('unpam_mahasiswa');
        $this->db->where('keter IS NULL');
        $this->db->order_by('nama', 'ASC');
        $this->db->order_by('keter', 'ASC');
        return $this->db->get()->result_array();
    }

    // Simpan kelompok
    public function saveKelompok($kelompok, $mahasiswa_ids) {
        $data = [];
        foreach ($mahasiswa_ids as $id) {
            $data[] = [
                'kelompok' => $kelompok,
                'mahasiswa_id' => $id
            ];
        }
        return $this->db->insert_batch('kelompok_mahasiswa', $data);
    }

    // Periksa apakah kelompok sudah ada
    public function checkKelompok($matkulId) {
        $this->db->from('tugas_kelompok');
        $this->db->where('matkul_id', $matkulId);
        $this->db->where('recid', 1);
        return $this->db->count_all_results() > 0;
    }

    // Clear kelompok dengan mengubah flag recid menjadi 0
    public function clearKelompok($matkulId) {
        $this->db->where('matkul_id', $matkulId);
        return $this->db->update('tugas_kelompok', ['recid' => 0]);
    }

    // Buat kelompok baru
    public function createKelompok($data) {
        return $this->db->insert('tugas_kelompok', $data);
    }
}
