<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Rek_persekot_model extends CI_Model {

	var $table = 'rekening_persekot';
    var $column_order = array('id', 'nama_rekening', 'no_rek');//,'status');
    //field yang ada di table user
	var $column_search = array('id', 'nama_rekening', 'no_rek');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('id'=>'asc'); //default sort */

	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	private function _get_datatables_query() 
	{
		$this->db->select('`id`, `nama_rekening`, `no_rek`, `date_created`, `deleted_at`, `created_by`');
		$this->db->from('rekening_persekot');
		$this->db->where('deleted_at', null);
		

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
    function get_data()
    {
        $this->db->select('`id`, `nama_rekening`, `no_rek`, `date_created`, `deleted_at`, `created_by`');
		$this->db->from($this->table);
		$this->db->where('deleted_at', null);
        return $this->db->get();
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


	public function store($norek, $namarek, $pic)
	{

		$data = array('no_rek'=>$norek,
					'nama_rekening'=>$namarek,
					'created_by'=>$pic);

		return $this->db->insert($this->table, $data);
	}

	public function update($id, $norek, $namarek)
	{
		$data = array('no_rek'=>$norek,
					'nama_rekening'=>$namarek,
					);
		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}

	public function get_detail($id)
	{
		$this->db->from($this->table);
		$this->db->where('id', $id);
		return $this->db->get();
	}
	
	public function delete($id)
	{
		$data = array(
			'deleted_at'=>date('Y-m-d H:i:s'),
			);

		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}

	public function cek_rek($norek)
	{
		$this->db->select('nama_rekening');
		$this->db->from($this->table);
		$this->db->where('no_rek', $norek);
		return $this->db->get();
	}

}
