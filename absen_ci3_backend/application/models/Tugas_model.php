<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tugas_model extends CI_Model {

    public function simpan_tugas($data) {
        return $this->db->insert('tugas', $data);
    }
    public function get_all_tugas() {
        $this->db->where("judul_tugas !=", ""); // Menambahkan filter judul_tugas tidak kosong
        return $this->db->get('tugas')->result_array();
        }
    public function get_tugas_by_id($id) {
        return $this->db->get_where('tugas', ['id' => $id])->row_array();
    }

    public function update_tugas($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tugas', $data);
    }

    public function delete_tugas($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tugas');
    }

}
