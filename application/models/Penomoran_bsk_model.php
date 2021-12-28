<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Penomoran_bsk_model extends CI_Model {

	var $table = 'berkas';
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
		$this->db->select('`id`, `tgl_surat`, `no_surat`, `perihal`, `url`, `date_created`, `created_by`, `deleted_at`, `nama_file`, `dari`, `kepada`');
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
	
	
	
	public function store($tgl, $no, $rubrik, $nm, $tujuan, $perihal)
	{

		$data = array('tgl' => $tgl, 
		'no'=>$no,
		'rubrik'=>$rubrik, 
		'nmcc'=>$nm, 
		'tujuan'=>$tujuan,
		'perihal'=>$perihal,
		);

		return $this->db->insert($this->table, $data);
	}

		public function proses($id, $tgl)
	{
		$data = array('tgl_penyelesaian'=>$tgl);
		$this->db->where('id_persekot', $id);
		return $this->db->update('persekot', $data);
	}


	public function update($id, $tgl_mnt, $rek,$user, $perihal, $nominal, $tgl_proses, $tgl_selesai, $nmrek, $by)
	{
		$data = array('tgl_permintaan'=>$tgl_mnt, 
		'no_rekening_pskt'=>$rek, 
		'nama_rekening_pskt'=>$nmrek,
		'user'=>$user,
		'perihal'=>$perihal,
		'nominal'=>$nominal,
		'tgl_proses'=>$tgl_proses,
		'tgl_penyelesaian'=>$tgl_selesai,
		'update_at'=>date('Y-m-d H:i:s'),
		'update_by'=>$by);

		$this->db->where('id_persekot', $id);
		return $this->db->update($this->table, $data);
	}

	public function get_data_id($id)
	{
		$this->db->select('url, nama_file');
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

	public function get_last_num($tahun){
		$this->db->select('no');
		$this->db->from('no_bsk');
		$this->db->where('tahun', $tahun);
		$this->db->order_by('id');
		$this->db->limit(1);
		return $this->db->get();
	}
}
