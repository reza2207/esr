<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Pengumuman_model extends CI_Model {

	var $table = 'register_masuk';
	var $column_order = array('id_register', 'tgl_email', 'email', 'tgl_terima_email', 'tgl_surat','no_surat','tgl_terima_surat','perihal','jenis_surat, status_data');//,'status');//field yang ada di table user
	var $column_search = array('register_masuk.id_register', 'tgl_register', 'divisi', 'email', 'tgl_email', 'tgl_terima_email', 'kelompok', 'no_surat', 'tgl_surat', 'perihal', 'tgl_terima_surat', 'jenis_surat', 'tgl_disposisi_pimkel', 'tgl_disposisi_manajer', 'keterangan', 'tahun', 'nama', 'jenis_pengadaan', 'user', 'status_data', 'nama');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('id_register'=>'desc'); //default sort
	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	private function _get_datatables_query() 
	{
		$this->db->select('register_masuk.id_register, register_masuk.tgl_register, register_masuk.divisi, register_masuk.email, register_masuk.tgl_email, register_masuk.tgl_terima_email, register_masuk.kelompok, register_masuk.no_surat, register_masuk.tgl_surat, register_masuk.perihal, register_masuk.tgl_terima_surat, register_masuk.jenis_surat, tgl_disposisi_pimkel, register_masuk.tgl_disposisi_manajer, register_masuk.keterangan, register_masuk.tahun, jenis_pengadaan_reg.jenis_pengadaan, register_masuk.user, register_masuk.status_data, a.no_kontrak, a.tgl_kontrak, a.tgl_spk, a.no_spk, a.tgl_penunjukan, a.no_penunjukan, a.tgl_pks, a.no_pks, b.username, b.nama');
		$this->db->from($this->table);
		$this->db->join('jenis_pengadaan_reg', 'register_masuk.id_register = jenis_pengadaan_reg.id_register', 'LEFT');
		$this->db->join('(SELECT id_register, GROUP_CONCAT(tgl_kontrak) AS tgl_kontrak, GROUP_CONCAT(no_kontrak) AS no_kontrak , GROUP_CONCAT(tgl_spk) AS tgl_spk, GROUP_CONCAT(no_spk) AS no_spk, GROUP_CONCAT(tgl_penunjukan) AS tgl_penunjukan, GROUP_CONCAT(no_penunjukan) AS no_penunjukan, GROUP_CONCAT(tgl_pks) AS tgl_pks, GROUP_CONCAT(no_pks) AS no_pks FROM detail_register_masuk GROUP BY id_register) AS a','a.id_register = register_masuk.id_register','LEFT');
		$this->db->join('(SELECT id_register, GROUP_CONCAT(pembuat_pekerjaan.username) AS username, GROUP_CONCAT(user.nama) AS nama FROM pembuat_pekerjaan LEFT JOIN user ON pembuat_pekerjaan.username = user.username GROUP BY id_register) AS b','register_masuk.id_register = b.id_register','LEFT');
	    if($this->input->post('divisi') != 'All'){
	    	$this->db->where('register_masuk.divisi', $this->input->post('divisi'));
	    

	    }
	    if($this->input->post('tahun') != 'All'){
	    	$this->db->where('register_masuk.tahun', $this->input->post('tahun'));
	    }
	    
	    if($this->input->post('my_task') != '' && $this->input->post('my_task') == "All"){
	    	$session = $_SESSION['username'];
	    	$this->db->like('b.username',$session);
	    }elseif($this->input->post('my_task') != '' && $this->input->post('my_task') != "All"){
	    	$session = $_SESSION['username'];
	    	$status = $this->input->post('my_task');
	    	$this->db->like('b.username',$session);
	    	$this->db->where('register_masuk.status_data',$status);
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

	public function get_last_id_register($year){
		$this->db->select('id_register');
		$this->db->from('register_masuk');
		$this->db->where('tahun', $year);
		$this->db->order_by('id_register', 'DESC');
		$this->db->limit('1');
		return $this->db->get();
	}

	public function add_data_masuk($id,  $divisi, $jenis, $email, $tglemail, $nosurat, $tglsurat, $perihal, $user, $kelompok,$tglterimasurat, $tglterimaemail, $tahun, $status, $beban, $anggaran){
		$data = array('id_register'=>$id,
					  'divisi'=>$divisi,
					  'jenis_surat'=>$jenis,
					  'email'=>$email,
					  'tgl_email'=>$tglemail,
					  'no_surat'=>$nosurat,
					  'tgl_surat'=>$tglsurat,
					  'perihal'=>$perihal,
					  'user'=>$user,
					  'kelompok'=>$kelompok,
					  'tgl_terima_surat'=>$tglterimasurat,
					  'tgl_terima_email'=>$tglterimaemail,
					  'tahun'=>$tahun,
					  'anggaran'=>$anggaran,
					  'beban_anggaran'=>$beban,
					  'status_data'=>$status);
		return $this->db->insert($this->table, $data);
	}

	public function get_year(){
		$this->db->select('tahun');
		$this->db->from($this->table);
		$this->db->group_by('tahun');
		$this->db->order_by('tahun', 'DESC');
		return $this->db->get();
	}

	public function get_data_register($id)
	{
		$this->db->select('register_masuk.id_register, register_masuk.tgl_register, register_masuk.divisi, register_masuk.email, register_masuk.tgl_email, register_masuk.tgl_terima_email, register_masuk.kelompok, register_masuk.no_surat, register_masuk.tgl_surat, register_masuk.perihal, register_masuk.tgl_terima_surat, register_masuk.jenis_surat, register_masuk.tgl_disposisi_pimkel, register_masuk.tgl_disposisi_manajer, register_masuk.keterangan, register_masuk.tahun, b.nama, b.username, id_detail_register, a.no_spk, a.tgl_spk, a.tgl_penunjukan, a.no_penunjukan, a.tgl_pks, a.no_pks, a.no_kontrak, a.nm_vendor, jenis_pengadaan_reg.jenis_pengadaan, register_masuk.user, register_masuk.status_data, jenis_pengadaan_reg.tempat_pengadaan');
		$this->db->from('register_masuk');
		$this->db->join('(SELECT id_register, GROUP_CONCAT(pembuat_pekerjaan.username) AS username, GROUP_CONCAT(user.nama SEPARATOR ", <br>") AS nama FROM pembuat_pekerjaan LEFT JOIN user ON pembuat_pekerjaan.username = user.username GROUP BY id_register) AS b','register_masuk.id_register = b.id_register','LEFT');
		$this->db->join('(SELECT id_register, GROUP_CONCAT(id_detail_register) id_detail_register, GROUP_CONCAT( CONCAT(no_kontrak, tgl_kontrak)) no_kontrak, GROUP_CONCAT(no_spk SEPARATOR "<br>") no_spk, GROUP_CONCAT(DATE_FORMAT(tgl_spk,"%d-%m-%Y") SEPARATOR "<br>") tgl_spk, GROUP_CONCAT(tgl_penunjukan) tgl_penunjukan, GROUP_CONCAT(no_penunjukan) no_penunjukan, GROUP_CONCAT(tgl_pks) tgl_pks, GROUP_CONCAT(no_pks) no_pks,  GROUP_CONCAT(tdr.nm_vendor SEPARATOR "<br>") nm_vendor FROM detail_register_masuk LEFT JOIN tdr ON detail_register_masuk.id_vendor = tdr.id_vendor GROUP BY id_register) a','register_masuk.id_register = a.id_register','LEFT');
		$this->db->join('jenis_pengadaan_reg', 'register_masuk.id_register = jenis_pengadaan_reg.id_register', 'LEFT');

		$this->db->where('register_masuk.id_register', $id);
		return $this->db->get()->row();
	}

	public function disposisi($idregister, $tgldpimkel ,$tgldmanager)
	{	
		if($tgldmanager == null){
			$data = array('tgl_disposisi_pimkel'=>$tgldpimkel);	
		}else{
			$data = array('tgl_disposisi_pimkel'=>$tgldpimkel ,
			'tgl_disposisi_manajer'=>$tgldmanager);
		}
		$this->db->where('id_register', $idregister);
		return $this->db->update($this->table, $data);
	}

	public function list_register_masuk($year){
		$this->db->select('perihal');
		$this->db->from($this->table);
		$this->db->where('tahun', $year);
		return $this->db->get();
	}

	public function jenis($id, $jenis, $tempat)
	{
		$data = array('id_register'=>$id ,
			'jenis_pengadaan'=>$jenis,
			'tempat_pengadaan'=>$tempat);
		
		return $this->db->insert('jenis_pengadaan_reg', $data);
	}

	public function submit_spk($iddetail, $id, $no, $tgl)
	{
		$data = array('id_detail_register'=>$iddetail ,
			'id_register'=>$id,
			'no_spk'=>$no,
			'tgl_spk'=>$tgl);
		return $this->db->insert('detail_register_masuk', $data);
	}
	public function update_status($id)
	{
		$data = array('status_data'=>'Done');
		$this->db->where('id_register', $id);
		$this->db->group_by('id_register');
		return $this->db->update($this->table, $data);
	}

	public function hapus_register($id)
	{	
		return $this->db->delete('register_masuk', array('id_register' => $id));
	}

	public function hapus_detail($id)
	{
		return $this->db->delete('detail_register_masuk', array('id_register' => $id));
	}
	public function hapus_pembuat_register($id)
	{
		return $this->db->delete('pembuat_pekerjaan', array('id_register' => $id));
	}
	public function hapus_jenis_reg($id)
	{
		return $this->db->delete('jenis_pengadaan_reg', array('id_register' => $id));
	}

	public function update_surat($id, $jenis, $no, $tgl, $perihal, $tgltrm)
	{
		$data = array('jenis_surat'=>$jenis,
					  'no_surat'=>$no,
					  'tgl_surat'=>$tgl,
					  'perihal'=>$perihal,
					  'tgl_terima_surat'=>$tgltrm);
		$this->db->where('id_register', $id);
		return $this->db->update($this->table, $data);
	}




}