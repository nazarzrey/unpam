<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // if ($this->session->userdata('username')) {
        //   redirect(base_url('site'));
        // }
        // $this->load->model(array('Mod_data',
        //                           'Mod_karyawan',
        //                           'Mod_siswa',
        //                           'Mod_proses'));
        $this->load->model(array('Mod_setting', 'Mod_query'));
        #$this->load->helper('fungsi');
    }
    public function data($value = "")
    {
        $dd = $this->Mod_setting->get_setting($value);
        if (count($dd) > 0) {
            $data = $dd[0]->data;
        } else {
            $data = "";
        }
        return $data;
    }

    public function content($value = '', $value2 = '')
    {
        if (strlen($value) == 0) {
        } else {
            if ($value == "menu_produk") {
                $prod_sort  = $this->data("order_produk");
                $prod_data  = $this->Mod_setting->get_produk("", $prod_sort);
                $result = $prod_data;
            } else if ($value == "menu_proyek") {
                $proy_sort  = $this->data("order_proyek");
                $proy_data  = $this->Mod_setting->get_proyek("", $proy_sort);
                $result = $proy_data;
            } else {
                $result = "";
            }
            return $result;
        }
    }

    public function catat($random)
    {
        $this->form_validation->set_rules("screen", "screen", "required|trim");
        $this->form_validation->set_rules("device", "device", "required|trim");

        if ($this->form_validation->run() == true) {
            $device = $_POST["device"];
            $screen = $_POST["screen"];
            $url    = $_POST["url"];
            $proyek = $this->Mod_query->proyek_data($_POST["project"]);
            $ip     = $_SERVER['REMOTE_ADDR'];
            $ua     = $this->getBrowser();
            $bname  = $ua['name'];
            $bversi = $ua['version'];
            $os     = $ua['platform'];
            $id_pry = $proyek[0]->proyek_id;
            $id_prd = $proyek[0]->produk_id;
            $id_page = "";
            $tgl    = date('y-m-d H:i');
            if (strlen($proyek[0]->proyek_url)) {
                $ins_pr  = array(
                    'url'               => $url,
                    'product'           => $id_pry,
                    'project'           => $id_prd,
                    'updrec_date'       => date("Y-m-d H:i:s")
                );
                $tab    = "new_page_visit";
                $tipe   = "update";
                $id     = "";
                $kol    = array(
                    'url'               => $url,
                    'product'           => $id_pry,
                    'project'           => $id_prd,
                    "date_format(updrec_date,'%y-%m-%d H:i')" => $tgl,
                );
                $id_page = $this->Mod_query->updLog($tab, $kol, $ins_pr, $url, $tgl);
            };
            $ins  = array(
                'log_ip'                => $ip,
                'log_page_id'           => $id_page,
                'log_url'               => $url,
                'log_device'            => $device,
                'log_browser'           => $bname,
                'log_browser_detail'    => $bversi . "|" . $os,
                'log_screen'            => $screen,
                'updrec_date'           => date("Y-m-d H:i:s")
            );

            $tbl  = "new_log";
            $klm  = array(
                "log_ip" => $ip,
                'log_url'               => $url,
                "date_format(updrec_date,'%y-%m-%d-%H-%i')" => date('y-m-d-H-i'),
                'log_device'            => $device,
                'log_screen'            => $screen
            );
            $tipe = "post";
            $id   = "";
            $cek  = $this->Mod_query->updDataForm($tbl, $tipe, $klm, $id, $ins);
            echo json_encode($cek);
        }
    }

    public function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        } else {
            $platform = 'Other Os';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        } else {
            $bname = 'Other Browser';
            $ub = "Other Browser";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                //            $version= $matches['version'][0];
                $version = "unknown";
            }
            echo $version;
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    }

    /* template */
    public function header($judul = "")
    {
        $sv = $_SERVER['SERVER_ADDR'];
        if ($sv == "localhost" || $sv == "127.0.0.1" || $sv == "::1" || substr_count($sv, "192.168") == 1) {

            $uri = $this->uri;
            // dbg($uri);
            #popup("2.5", "controller " . json_encode($uri->rsegments));
            #popup("3.5", "view " . json_encode($uri->segments));
        }

        $produk         = $this->content('menu_produk', '');
        $proyek         = $this->content('menu_proyek', '');
        $data["produk"] = $produk;
        $data["proyek"] = $proyek;
        $data["title"]  = $judul;
        $this->load->view("header", $data);
    }
    public function footer()
    {
        $data[] = "";
        $data["contact_popup"] = $this->Mod_query->konten("content", "kontak_popup");
        $data["kontak_footer"] = $this->Mod_query->kontak("where recid='1' order by urut");
        $data["proyek_all"]  = $this->Mod_query->proyek_list("", "");
        $uri = $this->uri->segment(1);
        // if (strpos($uri, "project") !== false || strpos($uri, "product") !== false || strpos($uri, "product") !== false || strpos($uri, "proyek") !== false || strpos($this->uri->rsegment(2), "p404") !== false) {
        //     $this->load->view("project_more", $data);
        // }
        if (strpos($this->uri->rsegment(2), "data_project") !== false || strpos($this->uri->rsegment(2), "p404") !== false) {
            $this->load->view("project_more", $data);
        }
        $this->load->view("footer", $data);
    }
    public function template($view, $data)
    {
        $judul = "";
        if (isset($data["judul"])) {
            if (strlen($data["judul"])) {
                $judul = $data["judul"];
            }
        }
        $this->header($judul);
        if (is_array($data)) {
            $this->load->view($view, $data);
        } else {
            echo $view;
        }
        $this->footer();
    }
}
