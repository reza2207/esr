<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Log_kerja_model extends CI_Model {

	var $table = 'log_kerja_esr';
	var $column_order = array('id_log', 'tanggal', 'nama', 'kelompok','keterangan','pic','status','done','tgl_done', 'jam_input');//,'status');//field yang ada di table user
	var $column_search = array('id_log', 'tanggal', 'nama', 'kelompok','keterangan','pic','status','done','tgl_done', 'jam_input');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('tanggal'=>'desc'); //default sort
	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	private function _get_datatables_query() 
	{
		$this->db->select('`id_log`, `hari`, `tanggal`, `nama`, `kelompok`, `keterangan`, `pic`, `status`, `tgl_done`, `jam_input`, `date_created`');
		$this->db->from($this->table);
		$this->db->where('deleted_at', NULL);
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

	public function get_log_user($username)
	{
		# code...
		$this->db->select('`id_log`, `hari`, `tanggal`, `nama`, `kelompok`, `keterangan`, `pic`, `status`, `tgl_done`, `jam_input`, `date_created`');
		$this->db->from($this->table);
		$this->db->where('deleted_at', NULL);
		$this->db->where('username');
	}
	
	public function list_log_pending($id) {
		
		
		$this->db->select('`id_log`, `hari`, `tanggal`, `nama`, `kelompok`, `keterangan`, `pic`, `status`, `tgl_done`, `jam_input`, `date_created`');
		$this->db->from($this->table);
		//$this->db->order_by("$sort_by ASC");
		$this->db->where('username', $id);
		$this->db->where('tgl_done =','0000-00-00');
		return $this->db->get();
		
	}

	public function list_log($limit, $start, $id) {
		
		
		$this->db->select('`id_log`, `hari`, `tanggal`, `nama`, `kelompok`, `keterangan`, `pic`, `status`, `tgl_done`, `jam_input`, `date_created`, datediff(`tgl_done`,`tanggal`) as sli');
		$this->db->from($this->table);
		//$this->db->order_by("$sort_by ASC");
		$this->db->where('username', $id);
		$this->db->where('tgl_done !=','0000-00-00');
		$this->db->limit($limit, $start);
		return $this->db->get();
		
	}

	public function count_by_id($username)
	{
		$this->db->from($this->table);
		$this->db->where('username', $username);
		$this->db->where('tgl_done !=','0000-00-00');
		return $this->db->count_all_results();
		
	}
	
}