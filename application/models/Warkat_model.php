<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Warkat_model extends CI_Model {

	var $table = 'register_warkat';
	var $column_order = array('id_warkat', 'no_warkat', 'perihal', 'b.nama_pemutus', 'c.nama','nominal','tanggal','catatan','status');//,'status');//field yang ada di table user
	var $column_search = array('id_warkat', 'no_warkat', 'perihal', 'pemutus', 'petugas','nominal','tanggal','catatan');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('id_warkat'=>'desc'); //default sort

	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	private function _get_datatables_query() 
	{
		$this->db->select('a.id_warkat, a.perihal, a.petugas, a.nominal, a.catatan, a.tanggal, a.tahun_warkat, a.no_warkat, b.nama_pemutus, c.nama, a.status');
		$this->db->from('register_warkat AS a');
		$this->db->join('pemutus_warkat AS b','a.pemutus = b.id_pemutus', 'LEFT');
		$this->db->join('user AS c', 'a.petugas = c.username', 'LEFT');

		if($this->input->post('tahun') == null){
			//$this->db->where('a.tahun_warkat', date('Y'));
		}elseif($this->input->post('tahun') != 'All'){
	    	$this->db->where('a.tahun_warkat', $this->input->post('tahun'));
	    }

		$i = 0;
		
		foreach($this->column_search as $item) // looping awal
		{
			if($_POST['search']['value']) // jika dtb mengirimkan pencarian melalui method post
			{
				if($i === 0) // looping awal
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) -1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function cek_id($tahun)
	{
		$this->db->select('id_surat');
		$this->db->from($this->table);
		$this->db->where('tahun', $tahun);
		$this->db->order_by('id_surat', 'DESC');
		$this->db->limit('1');
		return $this->db->get();
	}

	public function get_year()	
	{
		$this->db->select('tahun_warkat as tahun');
		$this->db->from($this->table);
		$this->db->group_by('tahun_warkat');
		$this->db->order_by('tahun_warkat', 'DESC');
		return $this->db->get();
	}

	public function get_data_pengolahan($id){
		$this->db->select('sirkulasi.id_surat, sirkulasi.no_srt, sirkulasi.perihal, sirkulasi.dari_kelompok, sirkulasi.tgl_petugas_kirim, sirkulasi.tgl_terima_doc, sirkulasi.tahun, sirkulasi.divisi, sirkulasi.print');
		$this->db->from($this->table);
		$this->db->where_in('id_surat', $id);
		return $this->db->get();
	}

	public function update_pengolahan($id, $no, $divisi, $perihal, $dari, $tglkirim, $tglterima)
	{
		$data = array('no_srt'=>$no,
					  'perihal'=>$perihal,
					  'dari_kelompok'=>$dari,
					  'tgl_petugas_kirim'=>$tglkirim,
					  'divisi'=>$divisi);
		$this->db->where('id_surat', $id);
	}


	public function hapus_pengolahan($id)
	{
		$this->db->where('id_surat', $id);
		return $this->db->delete($this->table, $id);
	}
	
	public function hapus_status($id)
	{
		$this->db->where('id_surat', $id);
		return $this->db->delete('status_sirkulasi', $id);
	}

	public function get_last_id($tahun)
	{
		$this->db->select('no_warkat');
		$this->db->from($this->table);
		$this->db->where('tahun_warkat', $tahun);
		$this->db->order_by('id_warkat', 'DESC');
		$this->db->limit(1);
		return $this->db->get();
	}

	public function insert_data($idwarkat, $nowarkat, $perihal, $pemutus, $petugas, $nominal, $tanggal, $catatan, $tahun)
	{

		$data = array('id_warkat'=>$idwarkat,
					'perihal'=>$perihal,
					'petugas'=>$petugas,
					'nominal'=>$nominal,
					'catatan'=>$catatan,
					'tanggal'=>$tanggal,
					'tahun_warkat'=>$tahun,
					'no_warkat'=>$nowarkat,
					'pemutus'=>$pemutus);

		return $this->db->insert($this->table, $data);
	}

	public function update($id, $val)
	{
		$data = array('status'=>$val);
		$this->db->where('id_warkat', $id);
		return $this->db->update('register_warkat', $data);
	}


	
}
