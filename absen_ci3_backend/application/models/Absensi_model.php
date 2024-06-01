<?php
class Absensi_model extends CI_Model {
    public function get_absensi_by_week($week) {
        $this->db->select('a.*, m.id_matkul, m.min_absen');
        $this->db->from('unpam_absensi a');
        $this->db->join('unpam_dosen_matkul dm', 'dm.matkul_url = a.url_matkul', 'left');
        $this->db->join('unpam_matkul m', 'm.dosen = dm.matkul_dosen', 'left');
        $this->db->where('WEEK(a.absen_time)', $week);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_mahasiswa() {
        $this->db->select('nama,substr(nim,1,12) as nim,keter');
        $this->db->from('unpam_mahasiswa');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_matkul() {
        // $this->db->select('*');
        // $this->db->from('unpam_matkul');
        // $query = $this->db->get();
        // return $query->result_array();
        $sql = "SELECT a.*,date_format(max(b.`updrec_date`),'%d-%m-%y %H:%i') as sync FROM unpam_matkul a left join unpam_absen_log b
        on trim(a.`dosen`)=trim(b.`obj_dosen`) group by a.`dosen`;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_all_dosen_matkul() {
        $this->db->select('*');
        $this->db->from('unpam_dosen_matkul');
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>
