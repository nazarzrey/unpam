<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model {

    public function get_all_mahasiswa() {
        $query = $this->db->get('unpam_mahasiswa');
        return $query->result();
    }
}
?>
