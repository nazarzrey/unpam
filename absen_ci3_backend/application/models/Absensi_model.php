<?php
class Absensi_model extends CI_Model {
    public function get_absensi_by_week($week) {
        $this->db->select('a.*, m.id_matkul, m.min_absen');
        $this->db->from('unpam_absensi a');
        $this->db->join('unpam_dosen_matkul dm', 'dm.matkul_url = a.url_matkul', 'left');
        $this->db->join('unpam_matkul m', 'm.dosen = dm.matkul_dosen', 'leftx');
        $this->db->where('WEEK(a.absen_time)', $week);
        
    echo $this->db->get_compiled_select();
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_mahasiswa() {
        $this->db->select('nama,substr(nim,1,12) as nim,keter');
        $this->db->from('unpam_mahasiswa');
        $this->db->where('ifnull(keter,"")=','');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_matkul() {
        // $this->db->select('*');
        // $this->db->from('unpam_matkul');
        // $query = $this->db->get();
        // return $query->result_array();
        
        if($this->session->userdata('nim')!=""){
            $value2 = $this->session->userdata('nim');
            $kls = $this->session->userdata('kelas');
        }else{
            $kls = "TPLE004";
        }
        
        $sql = "SELECT a.*,date_format(max(b.`updrec_date`),'%d-%m-%y %H:%i') as sync FROM unpam_matkul a left join unpam_absen_log b
        on trim(a.`dosen`)=trim(b.`obj_dosen`) where semester=(SELECT konten FROM unpam_setting WHERE jenis='semester') and kelas='$kls' group by a.`dosen`,matkul;";
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
