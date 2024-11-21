<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian_model extends CI_Model {

    public function get_penilaian() {
        $this->db->select('nim, matkul, id_fk_soal, nilai');
        $query = $this->db->get('penilaian');
        return $query->result();
    }

    public function insert_penilaian($data) {
        $this->db->insert('penilaian', $data);
    }
}
?>
