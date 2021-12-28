<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Barang_model extends CI_Model {

	var $table = 'barang';
    var $column_order = array('id', 'item', 'merk', 'type', 'warna');//,'status');
    //field yang ada di table user
	var $column_search = array('id', 'item', 'merk', 'type', 'warna');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('id'=>'desc'); //default sort */

	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	private function _get_datatables_query() 
	{
		$this->db->select('`id`, `item`, `merk`, `type`, `warna`, `created_by`, `deleted_at`, `created_at`, `min_stock`');
		$this->db->from($this->table);
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
        $this->db->select('`id`, `item`, `merk`, `type`, `warna`, `created_by`, `deleted_at`, `created_at`, `min_stock`');
        $this->db->from($this->table);
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

	
	public function delete($id)
	{
		$data = array(
			'deleted_at'=>date('Y-m-d H:i:s'),
			);

		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}
	
	
	
	public function store($item, $merk, $tipe, $warna, $created, $min)
	{

        $data = array('item'=>$item, 
        'merk'=>$merk,
        'type'=>$tipe, 
        'warna'=>$warna,
        'created_by'=> $created,
        'min_stock'=>$min);

		return $this->db->insert($this->table, $data);
	}

		public function proses($id, $tgl)
	{
		$data = array('tgl_penyelesaian'=>$tgl);
		$this->db->where('id_persekot', $id);
		return $this->db->update('persekot', $data);
	}

    public function get_item()
    {
        $this->db->select('item');
		$this->db->from($this->table);
		$this->db->group_by('item');
		return $this->db->get();
    }
    public function get_merk()
    {
        $this->db->select('merk');
		$this->db->from($this->table);
		$this->db->group_by('merk');
		return $this->db->get();
    }
	public function update($id, $item, $merk, $tipe, $warna, $by,$min)
	{
		$data = array('item'=>$item, 
        'merk'=>$merk,
        'type'=>$tipe, 
        'warna'=>$warna,
        'min_stock'=>$min,
		'created_by'=> $created);

		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}

	

    public function get_detail($id)
	{
		$this->db->select('`id`, `item`, `merk`, `type`, `warna`, `created_by`, `deleted_at`, `created_at`, `min_stock`');
		$this->db->from($this->table);
		$this->db->where('id', $id);
		return $this->db->get();
    }
    
	public function add_count_look($idfile, $by)
	{
		$data = array('id_file' => $idfile, 
					'look_by'=>$by);

		return $this->db->insert('count_look', $data);
	}

	public function add_count_download($idfile, $by)
	{
		$data = array('id_file' => $idfile, 
					'download_by'=>$by);

		return $this->db->insert('count_download', $data);
	}
}
