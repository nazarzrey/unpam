<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mod_query extends CI_Model
{
	public function produk($value = '')
	{
		$this->db->where("recid", "1");
		return $this->db->get('new_produk')->result();
	}
	public function proyek_ttl($value = '')
	{
		$sintak = "
				SELECT b.produk_url,b.produk_desk AS produk,COUNT(b.produk_id) AS total from new_proyek a LEFT JOIN new_produk b 
				ON a.produk_id=b.produk_id GROUP BY a.produk_id ORDER BY total DESC";
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
	public function sinarlink()
	{
		$sintak = "SELECT link_id,link_url_target,COUNT(b.`link_fk_id`) AS total FROM link_data a LEFT JOIN link_data_log b 
		ON a.`link_id`=b.`link_fk_id` AND recid='1'
		GROUP BY a.link_id,a.link_url_target
		ORDER BY 3 asc LIMIT 1";
		return single_query($this->db->query($sintak));
	}
	public function konten($page, $name)
	{
		$sintak = "SELECT content_title,content_lead,content_desc,content_image,a.content_link,b.link_url FROM new_content a
					LEFT JOIN new_link b ON a.content_link=b.link_id  where content_page='$page' and content_name='$name' ORDER BY urut";
		return each_query($this->db->query($sintak));
	}
	public function Query($table, $kolom, $kondisi)
	{
		$sintak = "SELECT $kolom from $table where recid='1' $kondisi";
		return each_query($this->db->query($sintak));
	}
	public function kontak($add_query = '')
	{
		if (strlen($add_query) == 0) {
			$add_query = "ORDER BY urut";
		}
		$sintak = "
				SELECT contact_name,contact_phone,contact_email2 as contact_email from new_contact " . $add_query;
		return each_query($this->db->query($sintak));
	}
	public function kontak_utama($value = '')
	{
		$sintak = "SELECT contact_name,contact_phone,contact_email2 as contact_email from new_contact where contact_prioritas='$value' and recid='1' ORDER BY urut";
		return each_query($this->db->query($sintak));
	}
	public function proyek_list($produk = '', $tahun = '')
	{
		if (!empty($produk) && empty($tahun)) {
			$sql = " where b.produk_url='$produk'";
		} elseif (!empty($produk) && !empty($tahun)) {
			$sql = " where b.produk_url='$produk' and tahun='$tahun'";
		} elseif (empty($produk) && !empty($tahun)) {
			$sql = " where tahun='$tahun'";
		} else {
			$sql = "";
		}
		if ($produk == "home") {
			$limit = " limit 8";
			$sql   = "";
		} else {
			if (is_numeric($produk)) {
				$sql   = "";
				$limit = " limit " . (($produk - 1) * 9) . ",9";
			} else {
				$limit = "";
			}
		}
		$sintak = "SELECT 
					proyek_id,proyek_url,proyek_desk,proyek_client,produk_url,produk_desk,lokasi,CONCAT(proyek_person,'<br/>',proyek_desk,' ',proyek_tahun) AS proyek_info,
					c.gallery_path,c.gallery_image
					FROM new_proyek a 
					LEFT JOIN new_produk b ON a.produk_id=b.produk_id
					LEFT JOIN new_gallery c ON a.proyek_id=c.proyek_fk_id AND c.gallery_urut='1'
					$sql
					GROUP BY proyek_id
					order by a.updrec_date+proyek_tahun desc
					$limit
					";
		return each_query($this->db->query($sintak));
	}
	public function proyek_data($proyek)
	{
		$sintak = "SELECT 
					proyek_id,a.produk_id,proyek_url,proyek_desk,proyek_person,produk_url,produk_desk,proyek_client,lokasi,CONCAT(proyek_desk,', ',proyek_person,', ',proyek_unit,' unit - ',proyek_tahun) AS proyek_info,proyek_tahun as tahun,
					c.gallery_path,
					GROUP_CONCAT(c.gallery_image) as gallery_image
					FROM new_proyek a 
					LEFT JOIN new_produk b ON a.produk_id=b.produk_id
					LEFT JOIN new_gallery c ON a.proyek_id=c.proyek_fk_id
					where a.proyek_url='$proyek'
					order by a.updrec_date+proyek_tahun desc
					";
		return each_query($this->db->query($sintak));
	}
	public function gallery($limit)
	{
		$sintak = "SELECT proyek_id,visit,proyek_url,proyek_id,gallery_image,gallery_video,gallery_link FROM view_project a LEFT JOIN new_gallery b ON a.proyek_id=b.proyek_fk_id 
					WHERE gallery_id IS NOT NULL
					ORDER BY 2 DESC $limit";
		return each_query($this->db->query($sintak));
	}


	public function analitik($ip = "")
	{
		if ($ip == "") {
			$sintak = "SELECT DISTINCT(log_ip) FROM link_data_log WHERE log_country IS NULL";
			return each_query($this->db->query($sintak));
		} else {
			$sintak = "SELECT * from link_ip where ip='$ip'";
			return single_query($this->db->query($sintak));
		}
	}
	function random_key()
	{
		$keys   = ranKey("6");
		$this->db->where("link_url_dynamic", $keys);
		$query  = $this->db->get("link_data");
		if ($query->num_rows($query) == 0) {
			$url  = $keys;
		} else {
			$url  = tgl("sort");
		}
		return $url;
	}
	function dynKey()
	{
		$keys   = ranKey("5");
		$this->db->where("link_url_dynamic", $keys);
		$query  = $this->db->get("link_data");
		if ($query->num_rows($query) == 0) {
			$url  = $keys;
		} else {
			$url  = $this->random_key();
		}
		return $url;
	}
	function updLog($tbl, $kolom, $data_array, $url, $tgl)
	{
		$has =  $this->db->get_where($tbl, $kolom);
		if (count($has->result()) == 0) {
			$this->db->insert($tbl, $data_array);
			$id = $this->db->insert_id();
		} else {
			$sintak = "UPDATE new_page_visit SET total=total+1 WHERE url='$url' AND DATE_FORMAT(updrec_date,'%Y-%m-%d')='$tgl'";
			$select = "SELECT id FROM new_page_visit WHERE url='$url' AND DATE_FORMAT(updrec_date,'%y-%m-%d')='$tgl'";
			$this->db->query($sintak);
			$id = single_query($this->db->query($select))->id;
			return $id;
		}
		return $id;
	}


	function updDataForm($tbl, $tipe, $kolom, $uid,  $data_array)
	{
		if (is_array($kolom)) {
			$has =  $this->db->get_where($tbl, $kolom);
		} else {
			$has =  $this->db->get_where($tbl, array($kolom => $uid));
		}
		$ttl = count($has->result());
		if ($tipe == "Hapus") {
			$result = $this->hapusin_data($tbl, $kolom, $uid);
		} elseif ($tipe == "edit") {
			if (is_array($kolom)) {
				$where  = $kolom;
			} else {
				$where  = array($kolom => $uid);
			}
			$result = $this->editin_data($data_array, $tbl, "", $where);
		} else {

			if ($ttl == 0) {
				$result = $this->masukin_data($data_array, $tbl, "");
			} else {
				if (is_array($kolom)) {
					$where  = $kolom;
				} else {
					$where  = array($kolom => $uid);
				}
				$result = $this->editin_data($data_array, $tbl, "", $where);
			}
		}
		return $result;
	}

	function masukin_data($array, $table, $tipe)
	{
		if ($tipe == "batch") {
			$this->db->insert_batch($table, $array);
		} else {
			$this->db->insert($table, $array);
		}
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	}

	function editin_data($array, $table, $tipe, $where)
	{
		if ($tipe == "batch") {
			$y = $this->db->insert_batch($table, $array);
		} else {
			$this->db->where($where);
			$y = $this->db->update($table, $array);
		}
		return $y;
	}

	function hapusin_data($table, $kolom, $id)
	{
		$this->db->where($kolom, $id);
		$y = $this->db->delete($table);
		return $y;
	}
}
