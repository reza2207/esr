<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Invoice_model extends CI_Model {

	var $table = 'invoice';
	var $column_order = array('a.tgl_input', 'tdr.nm_vendor', 'a.no_invoice','a.tgl_invoice', 'a.no_kontrak','a.nominal','a.perihal','a.tgl_invoice_diantar','a.tgl_invoice_kembali','a.tgl_kebagian_pembayaran','a.status');//,'status');//field yang ada di table user
	var $column_search = array(	'tdr.nm_vendor', 'a.no_invoice','a.tgl_invoice', 'a.memo_keluar', 'a.no_kontrak','a.nominal','a.perihal','a.status');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('tgl_input'=>'desc'); //default sort

	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	private function _get_datatables_query() 
	{
		$this->db->select('a.id_invoice, a.tgl_input, a.no_invoice, a.memo_keluar, a.no_kontrak, a.nominal, a.perihal, a.tgl_invoice, a.tgl_invoice_diantar, a.tgl_invoice_kembali, a.tgl_kebagian_pembayaran, a.tahun, tdr.nm_vendor, status.keterangan, a.status, a.id_vendor');
		$this->db->from('(SELECT invoice.id_invoice, invoice.tgl_input, invoice.id_vendor, invoice.no_invoice, invoice.memo_keluar, invoice.no_kontrak, invoice.nominal, invoice.perihal, invoice.tgl_invoice, invoice.tgl_invoice_diantar, invoice.tgl_invoice_kembali, invoice.tgl_kebagian_pembayaran, invoice.tahun, IF(invoice.no_invoice IS NULL, "10", IF(invoice.tgl_invoice_diantar = "0000-00-00", "11", IF(invoice.tgl_invoice_kembali = "0000-00-00", "12", IF(invoice.tgl_kebagian_pembayaran = "0000-00-00", "13", "14")))) AS status FROM invoice ) AS a');
		$this->db->join('tdr', 'a.id_vendor = tdr.id_vendor', 'LEFT');
		$this->db->join('status', 'a.status = status.id_status', 'LEFT');

		if($this->input->post('tahun') != 'All'){
	    	$this->db->where('a.tahun', $this->input->post('tahun'));
	    }

	    if($this->input->post('status') != ''){
	      $this->db->where('a.status', $this->input->post('status'));	
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


	public function submit_invoice($idinv, $tglinput, $idvendor, $noinv, $memo, $nokontrak, $nominal, $perihal, $tglinv, $invkeuser, $tahun)
	{
		$data = array('id_invoice'=>$idinv,
					  'tgl_input'=>$tglinput,
					  'id_vendor'=>$idvendor,
					  'no_invoice'=>$noinv,
					  'memo_keluar'=>$memo,
					  'no_kontrak'=>$nokontrak,
					  'nominal'=>$nominal,
					  'perihal'=>$perihal,
					  'tgl_invoice'=>$tglinv,
					  'tgl_invoice_diantar'=>$invkeuser,
					  'tahun'=>$tahun);
		return $this->db->insert('invoice', $data);
	}

	public function update_tk($id,$tgl)
	{
		$data = array('tgl_invoice_kembali'=>$tgl);
		$this->db->where('id_invoice', $id);
		return $this->db->update('invoice', $data);
	}
	public function update_tp($id,$tgl)
	{
		$data = array('tgl_kebagian_pembayaran'=>$tgl);
		$this->db->where('id_invoice', $id);
		return $this->db->update('invoice', $data);
	}


	public function get_year()
	{
		$this->db->select('tahun');
		$this->db->from($this->table);
		$this->db->group_by('tahun');
		$this->db->order_by('tahun', 'DESC');
		return $this->db->get();
	}

	public function get_select_status($menu = 'INVOICE')
	{
		$this->db->select('keterangan, id_status');
		$this->db->from('status');
		$this->db->where('menu', $menu);
		$this->db->where('id_status !=', '10');
		$this->db->where('id_status !=', '11');
		
		return $this->db->get();
	}

	public function hapus_inv($id)
	{
		return $this->db->delete('invoice', array('id_invoice'=>$id));

	}
	
	
}
