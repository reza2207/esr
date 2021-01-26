<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Barang_in_model extends CI_Model {

	var $table = 'barang_in';
    var $column_order = array('id', 'no_surat', 'tgl_surat', 'perihal', 'url');//,'status');
    //field yang ada di table user
	var $column_search = array('id', 'tgl_surat', 'no_surat', 'perihal','dari','kepada', 'url');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('id'=>'desc'); //default sort */

	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	private function _get_datatables_query() 
	{
		$this->db->select('`barang_in`.`id`, `barang_in`.`id_barang`, `barang_in`.`jumlah`, `barang_in`.`created_at`, `barang_in`.`created_by`, `barang_in`.`deleted_at`, `barang_in`.`divisi, `barang`.`merk`, `barang`.`type`, `barang`.`warna`, `barang`.`item`, `barang_in`.`tgl_masuk`');
		$this->db->from($this->table);
		$this->db->join('barang', 'barang_in.id_barang = barang.id', 'LEFT');
		$this->db->where('barang_in.deleted_at', null);
		

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
        $this->db->select('`id`, `id_barang`, `jumlah`, `created_at`, `created_by`, `deleted_at`');
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

	public function get_url()
	{
		$this->db->from('dir_scan');
		$this->db->order_by('id', 'DESC');
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
	
	
	
	public function store($idbrg,$jml,$divisi, $created)
	{

		$data = array('id_barang' => $idbrg, 
		'jumlah'=>$jml, 
		'divisi'=>$divisi,
		'created_by'=> $created);

		return $this->db->insert($this->table, $data);
	}

	
	public function get_detail($id)
	{
		$this->db->select('`barang_in`.`id`, `barang_in`.`id_barang`, `barang_in`.`jumlah`, `barang_in`.`created_at`, `barang_in`.`created_by`, `barang_in`.`deleted_at`, `barang_in`.`divisi,`barang_in`.`tgl_masuk`');
		$this->db->from($this->table);
		$this->db->where('id', $id);
		return $this->db->get();
	}
	public function update($id, $idbrg,$jml,$divisi, $created)
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

	public function get_divisi()
    {
        $this->db->select('divisi');
		$this->db->from($this->table);
		$this->db->group_by('divisi');
		return $this->db->get();
    }
}
