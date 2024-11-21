<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MasterSoal_model extends CI_Model {

    public function get_all_soal() {
        $query = $this->db->get('master_soal');
        return $query->result();
    }
}
?>
