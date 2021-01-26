<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Persekot_model extends CI_Model {

	var $table = 'persekot';
    var $column_order = array('a.id', 'a.tgl_permintaan', 'a.no_rekening_pskt', 'a.nama_rekening_pskt', 'a.user', 'a.perihal', 'a.nominal', 'a.tgl_proses', 'a.tgl_penyelesaian', 'a.sli', 'status.status', 'a.id');//,'status');
    //field yang ada di table user
	var $column_search = array('a.id', 'a.tgl_permintaan', 'a.no_rekening_pskt', 'a.nama_rekening_pskt', 'a.user', 'a.perihal', 'a.nominal', 'a.tgl_proses', 'a.tgl_penyelesaian','status.status');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('a.id'=>'desc'); //default sort */

	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	private function _get_datatables_query() 
	{
		$this->db->select('`a.id`, `a.tgl_permintaan`, `a.no_rekening_pskt`, `a.nama_rekening_pskt`, `a.user`, `a.perihal`, `a.nominal`, `a.tgl_proses`, `a.tgl_penyelesaian`, `a.created_date`, `a.created_by`, `a.deleted_at`, a.sli, a.status, a.berjalan');
		$this->db->from('(SELECT `id`, `tgl_permintaan`, `no_rekening_pskt`, `nama_rekening_pskt`, `user`, `perihal`, `nominal`, `tgl_proses`, `tgl_penyelesaian`, `created_date`, `created_by`, `deleted_at`, DATEDIFF(tgl_penyelesaian, tgl_proses) sli, (select count(datediff(curdate(), tgl_proses)) berjalan FROM persekot where datediff(curdate(), tgl_proses) > 5) as berjalan, IF(`tgl_penyelesaian` IS NULL, "1", "2") as status FROM persekot) a');
		$this->db->join('status', 'a.status = status.id', 'LEFT');
		
		$this->db->where('a.deleted_at', null);
		
		if($this->input->post('tgla') != ''){
	    	$this->db->where('tgl_permintaan >=', $this->input->post('tgla'));
		}

		if($this->input->post('tglb') != ''){
	    	$this->db->where('tgl_permintaan <=', $this->input->post('tglb'));
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
    function get_data()
    {
        $this->db->select('`id_kel`, `nama_kel`, `keterangan`, `prioritas_urutan`');
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
	
	
	
	public function store($tgl_minta, $rek, $nama_rek, $user, $perihal, $nominal, $tgl_proses, $pic)
	{

		$data = array('tgl_permintaan'=>$tgl_minta, 
		'no_rekening_pskt'=>$rek, 
		'nama_rekening_pskt'=>$nama_rek,
		'user'=>$user,
		'perihal'=>$perihal,
		'nominal'=>$nominal,
		'tgl_proses'=>$tgl_proses,
		'created_by'=>$pic);

		return $this->db->insert($this->table, $data);
	}

	public function get_reminder()
	{
		$this->db->select('datediff(curdate(), tgl_proses) berjalan');
		$this->db->from('persekot');
		$this->db->where('datediff(curdate(), tgl_proses) > 5');
		$this->db->where('datediff(curdate(), tgl_proses) <= 15');
		$this->db->where('tgl_penyelesaian is null');
		return $this->db->get();
	}

	public function get_exp()
	{
		$this->db->select('tgl_penyelesaian');
		$this->db->from('persekot');
		$this->db->where('datediff(curdate(), tgl_proses) > 15');
		$this->db->where('tgl_penyelesaian is null');
		return $this->db->get();
	}
	
	public function proses($id, $tgl)
	{
		$data = array('tgl_penyelesaian'=>$tgl);
		$this->db->where('id', $id);
		return $this->db->update('persekot', $data);
	}

	public function get_detail($id)
	{
		$this->db->from($this->table);
		$this->db->where('id', $id);
		return $this->db->get();
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

		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}
}
