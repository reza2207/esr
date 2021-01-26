<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Setting_model extends CI_Model {

	var $table = 'tgl_libur';
	var $column_order = array('id_tgl', 'tgl', 'keterangan', 'id_tgl');//,'status');//field yang ada di table user
	var $column_search = array('id_tgl', 'tgl', 'keterangan', 'id_tgl');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('id_tgl'=>'desc'); //default sort


	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	private function _get_datatables_query() 
	{
		$this->db->select('id_tgl, tgl, keterangan');
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
	
	public function get_divisi()
	{
		$this->db->select('divisi');
		$this->db->from('divisi');
		return $this->db->get();
	}

	public function get_dir_file($tahun)
	{
		$this->db->select('settings.defaultnya');
		$this->db->from('settings');
		$this->db->where('namasetting', 'default_doc_'.$tahun);
		return $this->db->get();
	}

	public function get_tgl_libur($tglawal, $tglakhir)
	{
		$this->db->select('tgl, keterangan');
		$this->db->from('tgl_libur');
		$where = "tgl BETWEEN '$tglawal' AND '$tglakhir'";
		$this->db->where($where);
		return $this->db->get();
	}

	public function dir_foto()
	{
		$this->db->select('defaultnya');
		$this->db->from('settings');
		$this->db->where('namasetting','dir_foto');
		return $this->db->get();
	}

	public function theme($user = null, $title = null)
	{
		$this->db->select('value');
		$this->db->from('theme_user');
		$this->db->where('user_id', $user);
		
		return $this->db->get();
	}


}