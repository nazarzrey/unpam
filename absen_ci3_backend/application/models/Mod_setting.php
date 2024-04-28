<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mod_setting extends CI_Model
{
    public function get_setting($value = '')
    {
        $this->db->where("name", $value);
        return $this->db->get('content_setting')->result();
    }
    public function get_produk($value = '', $order = '')
    {
        $sintak = "SELECT a.`produk_id`,a.`produk_url`,a.`produk_desk`,COUNT(* ) AS ttl FROM new_produk a LEFT JOIN new_proyek b ON a.`produk_id`=b.`produk_id` 
                  GROUP BY a.`produk_id` " . $order;
        return each_query($this->db->query($sintak));
    }
    public function get_proyek($value = '', $order = '')
    {
        $sintak = "SELECT b.`produk_id`,b.`produk_url`,b.`produk_desk`,COUNT(* ) AS ttl FROM new_proyek a LEFT JOIN  new_produk b ON a.`produk_id`=b.`produk_id` 
                GROUP BY a.`produk_id` ORDER BY 4 DESC,produk_id ASC " . $order;
        return each_query($this->db->query($sintak));
    }













    public function katalog($value = '')
    {
        $sintak = "
				SELECT * FROM new_produk b  LEFT JOIN new_katalog  a
				ON a.produk_id=b.produk_id
				WHERE b.produk_id=(SELECT produk_id FROM new_produk WHERE produk_url='$value')";
        return each_query($this->db->query($sintak));
    }
    public function kontak($value = '')
    {
        $sintak = "
				SELECT contact_name,contact_phone,contact_email2 as contact_email from new_contact ORDER BY urut";
        return each_query($this->db->query($sintak));
    }
    public function kontak_utama($value = '')
    {
        $sintak = "SELECT contact_name,contact_phone,contact_email2 as contact_email from new_contact where contact_prioritas='$value' and recid='1' ORDER BY urut";
        return each_query($this->db->query($sintak));
    }
    // public function proyek_list($produk = '', $tahun = '')
    // {
    //     if (!empty($produk) && empty($tahun)) {
    //         $sql = " where b.produk_url='$produk'";
    //     } elseif (!empty($produk) && !empty($tahun)) {
    //         $sql = " where b.produk_url='$produk' and tahun='$tahun'";
    //     } elseif (empty($produk) && !empty($tahun)) {
    //         $sql = " where tahun='$tahun'";
    //     } else {
    //         $sql = "";
    //     }
    //     if ($produk == "home") {
    //         $limit = " limit 8";
    //         $sql   = "";
    //     } else {
    //         $limit = "";
    //     }
    //     $sintak = "SELECT 
    // 				proyek_id,proyek_url,proyek_desk,produk_url,produk_desk,lokasi,CONCAT(proyek_desk,', ',proyek_person,', ',proyek_unit,' unit - ',proyek_tahun) AS proyek_info,proyek_tahun as tahun,
    // 				c.gallery_path,c.gallery_image
    // 				FROM new_proyek a 
    // 				LEFT JOIN new_produk b ON a.produk_id=b.produk_id
    // 				LEFT JOIN new_gallery c ON a.proyek_id=c.proyek_fk_id AND c.gallery_urut='1'
    // 				$sql
    // 				GROUP BY proyek_id
    // 				order by a.updrec_date+proyek_tahun desc
    // 				$limit
    // 				";
    //     return each_query($this->db->query($sintak));
    // }
    public function proyek_data($proyek)
    {
        $sintak = "SELECT 
					proyek_id,proyek_url,proyek_desk,produk_url,produk_desk,lokasi,CONCAT(proyek_desk,', ',proyek_person,', ',proyek_unit,' unit - ',proyek_tahun) AS proyek_info,proyek_tahun as tahun,
					c.gallery_path,c.gallery_image
					FROM new_proyek a 
					LEFT JOIN new_produk b ON a.produk_id=b.produk_id
					LEFT JOIN new_gallery c ON a.proyek_id=c.proyek_fk_id
					where a.proyek_url='$proyek'
					order by a.updrec_date+proyek_tahun desc
					";
        return each_query($this->db->query($sintak));
    }
}
