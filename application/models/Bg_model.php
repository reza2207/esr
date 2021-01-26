<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Bg_model extends CI_Model {

	var $table = 'bg';
	var $column_order = array('', 'id_bg','no_bg', 'beneficiary', 'applicant', 'issuer', 'ccy', 'amount', 'eqv', 'open', 'start', 'maturity', 'gl_acc', 'type', 'keterangan', 'buku_satu', 'buku_dua', 'jenis_pekerjaan');//,'status');//field yang ada di table user
	var $column_search = array('id_bg','no_bg', 'beneficiary', 'applicant', 'issuer', 'ccy', 'amount', 'eqv', 'open', 'start', 'maturity', 'gl_acc', 'type', 'keterangan', 'buku_satu', 'buku_dua', 'jenis_pekerjaan', 'divisi');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('open'=>'desc'); //default sort
	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	private function _get_datatables_query() 
	{
		$this->db->select('`id_bg`, `no_bg`, `beneficiary`, `applicant`, `issuer`, `ccy`, `amount`, `eqv`, `open`, `start`, `maturity`, `gl_acc`, `type`, `keterangan`, `buku_satu`, `buku_dua`, `jenis_pekerjaan`, `divisi`');
		$this->db->from($this->table);
		
	    if($this->input->post('divisi') != ''){
	    	$this->db->where('divisi', $this->input->post('divisi'));
	    }
	    if($this->input->post('tahun') != ''){
	    	$this->db->where('YEAR(start)', $this->input->post('tahun'));
	    }

	    if($this->input->post('jenis') == 'Active'){
	    	$this->db->where('DATEDIFF(maturity, CURRENT_DATE) >',0);
	    }elseif($this->input->post('jenis') == 'Penerimaan'){
	    	$this->db->where('buku_dua', '');
	    }elseif($this->input->post('jenis') == 'Pencairan'){
	    	$this->db->where('buku_dua !=', '');
	    }elseif($this->input->post('jenis') == 'Expired'){
	    	$this->db->where('DATEDIFF(maturity, CURRENT_DATE) <=',0);
	    }elseif($this->input->post('jenis') == 'Expired'){
	    	$this->db->where('DATEDIFF(maturity, CURRENT_DATE) <=',0);
	    }
	    if($this->input->post('bulan') != ''){
	    	$this->db->where('MONTH(open)',$this->input->post('bulan'));
	    }
	    if($this->input->post('type') != ''){
	    	$this->db->where('type',$this->input->post('type'));
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

	public function get_last_id($year, $divisi){
		$this->db->select('id_bg');
		$this->db->from($this->table);
		$this->db->where('YEAR(open)', $year);
		$this->db->where('divisi', $divisi);
		$this->db->order_by('id_bg', 'DESC');
		$this->db->limit('1');
		return $this->db->get();
	}

	public function add_data($id, $nobg, $beneficiary, $applicant, $issuer, $ccy, $amount, $eqv, $open, $start, $maturity, $gl, $type, $keterangan, $buku1, $jenispekerjaan, $divisi){
		$data = array('id_bg'=>$id,
					  'no_bg'=>$nobg,
					  'beneficiary'=>$beneficiary,
					  'applicant'=>$applicant,
					  'issuer'=>$issuer,
					  'ccy'=>$ccy,
					  'amount'=>$amount,
					  'eqv'=>$eqv,
					  'open'=>$open,
					  'start'=>$start,
					  'maturity'=>$maturity,
					  'gl_acc'=>$gl,
					  'type'=>$type,
					  'keterangan'=>$keterangan,
					  'buku_satu'=>$buku1,
					  'jenis_pekerjaan'=>$jenispekerjaan,
					  'divisi'=>$divisi);
		return $this->db->insert($this->table, $data);
	}

	public function get_year(){
		$this->db->select('YEAR(open) AS tahun');
		$this->db->from($this->table);
		$this->db->group_by('YEAR(open)');
		$this->db->order_by('YEAR(open)', 'DESC');
		return $this->db->get();
	}

	

	public function get_expired()
	{
		$this->db->select('id_bg');
		$this->db->from($this->table);
		$this->db->where('DATEDIFF(maturity, CURRENT_DATE) <=',10);
		$this->db->where('DATEDIFF(maturity, CURRENT_DATE) >',0);
		$this->db->where('DATEDIFF(maturity, CURRENT_DATE) !=', NULL);
		return $this->db->get();
	}


	public function get_bg($year = null, $month = null, $divisi = null)
	{
		$query = $this->db->query("SELECT * FROM (SELECT `id_bg`, `no_bg`, `beneficiary`, `applicant`, `issuer`, `ccy`, `amount`, `eqv`, `open`, `start`, `maturity`, `gl_acc`, `type`, `keterangan`, `buku_satu`, `buku_dua`, `jenis_pekerjaan`, `divisi`, MONTH(open) AS bulan_open, YEAR(open) AS tahun, MONTH(maturity) AS bulan_maturity FROM `bg` WHERE YEAR(open) = '$year' AND MONTH(open) <= '$month' AND `divisi` = '$divisi' OR `maturity` >= 'YEAR(CURRENT_DATE)' AND MONTH(maturity) >= 'MONTH(CURRENT_DATE)' AND YEAR(maturity) >= '$year' AND `buku_dua` = '' ORDER BY `open`) as a
UNION SELECT * FROM (SELECT `id_bg`, `no_bg`, `beneficiary`, `applicant`, `issuer`, `ccy`, `amount`, `eqv`, `open`, `start`, `maturity`, `gl_acc`, `type`, `keterangan`, `buku_satu`, `buku_dua`, `jenis_pekerjaan`, `divisi`, MONTH(open) AS bulan_open, YEAR(open) AS tahun, MONTH(maturity) AS bulan_maturity FROM `bg` WHERE `divisi` = '$divisi' AND 'YEAR(`maturity`)' = 'YEAR(CURRENT_DATE)' AND MONTH(maturity) >= 'MONTH(CURRENT_DATE)' OR `buku_dua` != '' AND YEAR(maturity) >= '$year' ORDER BY `open`) as b ");
		//ada 3 nanti

		/*$this->db->select('`id_bg`, `no_bg`, `beneficiary`, `applicant`, `issuer`, `ccy`, `amount`, `eqv`, `open`, `start`, `maturity`, `gl_acc`, `type`, `keterangan`, `buku_satu`, `buku_dua`, `jenis_pekerjaan`, `divisi`, MONTH(open) AS bulan_open, YEAR(open) AS tahun, MONTH(maturity) AS bulan_maturity');
		$this->db->from($this->table);
		$this->db->where('YEAR(open)', $year);
		$this->db->where('MONTH(open) <=', $month);
		$this->db->where('divisi', $divisi);
		$this->db->or_where('maturity >=', 'YEAR(CURRENT_DATE)');
		$this->db->where('MONTH(maturity) >=', 'MONTH(CURRENT_DATE)');
		$this->db->or_where('buku_dua !=', '');
		$this->db->where('YEAR(maturity) >=',$year);
		//$this->db->or_where('buku_dua !=','');
		$this->db->order_by('open');*/
		return $query;
	}


//penerimaan, pencairan, expired

}