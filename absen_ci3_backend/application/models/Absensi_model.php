<?php
class Absensi_model extends CI_Model {
    public function get_absensi_by_week($week) {
       $sql = "SELECT 
                    LEFT(nim, 12) AS nim,
                    (SELECT COUNT(1) 
                    FROM unpam_dosen_matkul mtk 
                    WHERE WEEK(mtk.absensi_dosen) = $week 
                    AND mtk.matkul_dosen = ab.matkul_dosen) AS fd,
                    nama,
                    id_matkul,
                    min_absen,
                    SUM(total) AS total,
                    GROUP_CONCAT(id_matkul_abs,'|',total) AS url_matkuls
                FROM (
                    SELECT a.id_matkul_abs,a.url_matkul,LEFT(a.nim, 12) AS nim,a.nama,m.id_matkul,m.min_absen,COUNT(1) AS total,dm.matkul_dosen
                    FROM unpam_absensi a
                    LEFT JOIN unpam_dosen_matkul dm ON dm.matkul_url = a.url_matkul
                    JOIN unpam_matkul m ON m.dosen = dm.matkul_dosen
                    WHERE WEEK(dm.`absensi_dosen`) = $week 
                    AND LOWER(a.nim) != 'dosen'
                    -- and nama like 'NAZA%'
                    GROUP BY a.url_matkul, LEFT(a.nim, 12)
                    ORDER BY a.nama, m.id_matkul, a.url_matkul
                ) ab 
                GROUP BY id_matkul, nim;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_matkul_aktif($week) {
        $sql = "SELECT GROUP_CONCAT(DISTINCT(id_matkul)) AS matkul_aktif FROM unpam_dosen_matkul a 
                LEFT JOIN unpam_matkul b ON a.`matkul_dosen`=b.`dosen`
                WHERE WEEK(a.absensi_dosen) = '$week' "; 
                // GROUP BY matkul_dosen
        $query = $this->db->query($sql);
        $hasil = $query->result_array();
        if(empty($hasil[0]["matkul_aktif"])){
            $takeother = $this->get_all_matkul();
            foreach($takeother as $aktif_all){
                $matkul_aktif[] = $aktif_all["id_matkul"];
            }
            $balikan[] = array("matkul_aktif"=>implode(",",$matkul_aktif));
            $hasil = $balikan;
        }
        return $hasil;
    }

    public function get_matkul_aktif_detail($week) {
        $sql = "SELECT id_matkul,matkul_url,b.`matkul_singkat`,CONCAT(REPLACE(a.`matkul_fordis`,'FORUM DISKUSI','FD'),'-',LEFT(matkul_fordis_title,5)) AS judul,b.`min_absen` FROM unpam_dosen_matkul a 
                LEFT JOIN unpam_matkul b ON a.`matkul_dosen`=b.`dosen`
                WHERE WEEK(a.absensi_dosen) = '$week' GROUP BY matkul_url order by 1 "; 
                // GROUP BY matkul_dosen
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_all_mahasiswa() {
        $this->db->select('nama,substr(nim,1,12) as nim,alias,keter,gender');
        $this->db->from('unpam_mahasiswa');
        $this->db->order_by('alias');
        //$this->db->where('ifnull(keter,"")=','');
        // $this->db->where('alias','NAZA');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_matkul() {        
        if($this->session->userdata('nim')!=""){
            $value2 = $this->session->userdata('nim');
            $kls = $this->session->userdata('kelas');
        }else{
            $kls = "TPLE004";
        }
        
        $sql = "SELECT a.*,date_format(max(b.`updrec_date`),'%d-%m-%y %H:%i') as sync FROM unpam_matkul a left join unpam_absen_log b
        on trim(a.`dosen`)=trim(b.`obj_dosen`) where semester=(SELECT konten FROM unpam_setting WHERE jenis='semester') and kelas='$kls' group by a.`dosen`,matkul;";
        $query = $this->db->query($sql);
        $hasil = $query->result_array();
        return $hasil;
    }
    public function get_dosen_matkul_aktif($week) {
        $sql = "SELECT
            b.`dm_id` AS id_matkul_abs,
            a.*,REPLACE(b.`matkul_fordis`,'FORUM DISKUSI ','FD-') AS fordis,
            b.`matkul_fordis_title`,
            b.matkul_url,
            IFNULL(
            DATE_FORMAT(
                MAX(b.`updrec_date`),
                '%d-%m-%y %H:%i'
            ),'00-00-00 00:00') AS sync
            FROM
            unpam_matkul a
            LEFT JOIN unpam_dosen_matkul b
                ON TRIM(a.`dosen`) = TRIM(b.`matkul_dosen`)
            WHERE a.semester =
            (SELECT
                konten
            FROM
                unpam_setting
            WHERE jenis = 'semester')
            AND kelas = 'TPLE004'
            AND WEEK(b.`absensi_dosen`)='$week'
            GROUP BY a.`dosen`,matkul,b.`matkul_url`
            ORDER BY  id_matkul,dm_id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function upd_absensi() {
        $sql = "UPDATE unpam_absensi a LEFT JOIN unpam_dosen_matkul b ON a.`url_matkul`=b.`matkul_url` SET a.`id_matkul_abs`=b.`dm_id` WHERE ifnull(a.id_matkul_abs,0)=0";
        $this->db->query($sql);
    }
}
?>
