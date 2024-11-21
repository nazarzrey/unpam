<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
    public function check_login($nim, $kelas) {
        $this->db->where('nim', $nim);
        $query = $this->db->get('unpam_mahasiswa');
        
        if ($query->num_rows() == 1) {
            $user = $query->row();
            dbg($user);
            dbg($kelas);
            dbg(md5($nim."|".$kelas));
            dbg(md5($user->nim."|".$user->kelas));
            dbg(md5($nim."|".$kelas)==md5($user->nim."|".$user->kelas)."++");
            if (md5($nim."|".$kelas)==md5($user->nim."|".$user->kelas)) {
                // dbg("ZRe");
                return $user;
            }
        }
        
        return false;
    }
    public function insert_log($tipe, $script) {
        $data = array(
            'tipe' => $tipe,
            'script' => $script,
            'running' => date('Y-m-d H:i:s')
        );
        $this->db->insert('log_data', $data);
    }
}
