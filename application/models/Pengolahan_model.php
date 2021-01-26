<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Pengolahan_model extends CI_Model {

	var $table = 'sirkulasi';
	var $column_order = array('id_surat', 'no_srt', 'perihal', 'dari_kelompok', 'divisi','tgl_petugas_kirim','tgl_terima_doc','print','id_surat');//,'status');//field yang ada di table user
	var $column_search = array('id_surat', 'no_srt', 'perihal', 'dari_kelompok', 'divisi','tgl_petugas_kirim','tgl_terima_doc','print','id_surat');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('id_surat'=>'desc'); //default sort

	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	private function _get_datatables_query() 
	{
		$this->db->select('sirkulasi.id_surat, sirkulasi.no_srt, sirkulasi.perihal, sirkulasi.dari_kelompok, sirkulasi.tgl_petugas_kirim, sirkulasi.tgl_terima_doc, sirkulasi.tahun, sirkulasi.divisi, sirkulasi.print');
		$this->db->from($this->table);

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

	public function add_pengolahan($id_register, $no_surat, $perihal, $dari, $tgl_kirim, $divisi, $tahun)
	{
		$data = array('id_surat'=>$id_register,
					  'no_srt'=>$no_surat,
					  'perihal'=>$perihal,
					  'dari_kelompok'=>$dari,
					  'tgl_petugas_kirim'=>$tgl_kirim,
					  'tahun'=>$tahun,
					  'divisi'=>$divisi);
		return $this->db->insert($this->table, $data);
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
					  'tgl_terima_doc'=>$tglterima,
					  'divisi'=>$divisi);
		$this->db->where('id_surat', $id);
		return $this->db->update($this->table, $data);
	}

	public function get_status($id)
	{
		$this->db->select('status_sirkulasi.id_status, status_sirkulasi.id_surat, status_sirkulasi.tgl_buat, status_sirkulasi.status, user.nama');
		$this->db->from('status_sirkulasi');
		$this->db->join('user', 'status_sirkulasi.dibuat_oleh = user.username', 'LEFT');
		$this->db->where('status_sirkulasi.id_surat', $id);
		$this->db->order_by('tgl_buat', 'DESC');
		return $this->db->get();

	}

	public function input_status($idstatus, $idsurat, $status, $by, $date)
	{
		$data = array('id_status'=>$idstatus,
						'id_surat'=>$idsurat,
						'status'=>$status,
						'dibuat_oleh'=>$by,
						'tgl_buat'=>$date);
		$this->db->where('id_surat', $idsurat);
		return $this->db->insert('status_sirkulasi', $data);
	}

	public function get_id_status($id)
	{
		$this->db->select('id_status');
		$this->db->from('status_sirkulasi');
		$this->db->where('id_surat', $id);
		$this->db->order_by('id_status', 'DESC');
		$this->db->limit('1');
		return $this->db->get();

	}

	public function hapus_pengolahan($id)
	{
		

		return $this->db->delete($this->table, array('id_surat'=>$id));
	}
	
	public function hapus_status($id)
	{
		
		return $this->db->delete('status_sirkulasi', array('id_surat'=>$id));
	}


	
}
