<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Register_masuk_model extends CI_Model {

	var $table = 'register_masuk';
	var $column_order = array('id_register', 'tgl_email', 'email', 'tgl_terima_email', 'tgl_surat','no_surat','tgl_terima_surat','perihal','jenis_surat, status');//,'status');//field yang ada di table user
	var $column_search = array('a.id_register', 'tgl_register', 'divisi', 'email', 'tgl_email', 'tgl_terima_email', 'kelompok', 'no_surat', 'tgl_surat', 'perihal', 'tgl_terima_surat', 'jenis_surat', 'tgl_disposisi_pimkel', 'tgl_disposisi_manajer', 'b.keterangan', 'tahun', 'nama', 'jenis_pengadaan', 'user', 'status_data');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('id_register'=>'desc'); //default sort
	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	private function _get_datatables_query() 
	{	
		$this->db->select('a.id_register, a.tgl_register, a.divisi, a.email, a.tgl_email, a.tgl_terima_email, a.kelompok, a.no_surat_masuk, a.tgl_surat_masuk, a.perihal, a.tgl_terima_surat, a.jenis_surat, a.tgl_disposisi_pimkel, a.tgl_disposisi_manajer, a.keterangan, a.tahun, a.jenis_pengadaan, a.user, a.status_data, a.tgl_surat, a.no_surat, a.id_surat, a.username, a.nama, a.no_srt_pengembalian, a.tgl_srt_pengembalian, a.alasan, a.jmldoc, b.keterangan as status, a.type_surat, a.divisi, c.comment, c.created_at');
		$this->db->from('(SELECT `register_masuk`.`id_register`, `register_masuk`.`tgl_register`, `register_masuk`.`divisi`, `register_masuk`.`email`, `register_masuk`.`tgl_email`, `register_masuk`.`tgl_terima_email`, `register_masuk`.`kelompok`, `register_masuk`.`no_surat` as `no_surat_masuk`, `register_masuk`.`tgl_surat` as `tgl_surat_masuk`, `register_masuk`.`perihal`, `register_masuk`.`tgl_terima_surat`, `register_masuk`.`jenis_surat`, `tgl_disposisi_pimkel`, `register_masuk`.`tgl_disposisi_manajer`, `register_masuk`.`keterangan`, `register_masuk`.`tahun`, `jenis_pengadaan_reg`.`jenis_pengadaan`, `register_masuk`.`user`, `register_masuk`.`status_data`, `a`.`tgl_surat`, `a`.`no_surat`, `a`.`id_surat`, `b`.`username`, `b`.`nama`, `d`.`no_surat` as `no_srt_pengembalian`, `d`.`tgl_surat` as `tgl_srt_pengembalian`, `d`.`alasan`, `c`.`jmldoc`, IF(e.id is not null, 20,IF(d.tgl_kembali is not null, 21, IF(jenis_pengadaan_reg.jenis_pengadaan = "Pembelian Langsung" AND c.jmldoc > 0, 19, IF(c.jmldoc > 0, 19, 18)))) as status, c.type_surat FROM `register_masuk` LEFT JOIN `jenis_pengadaan_reg` ON `register_masuk`.`id_register` = `jenis_pengadaan_reg`.`id_register` LEFT JOIN (SELECT a.id_register, GROUP_CONCAT(a.tgl_surat) AS tgl_surat, GROUP_CONCAT(a.no_surat) AS no_surat, GROUP_CONCAT(a.id_surat) AS id_surat, GROUP_CONCAT(b.jenis_surat) AS jenis FROM detail_register_masuk a LEFT JOIN jenis_surat b ON b.id_surat = a.id_surat GROUP BY a.id_register) AS a ON `a`.`id_register` = `register_masuk`.`id_register` LEFT JOIN (SELECT id_register, GROUP_CONCAT(pembuat_pekerjaan.username) AS username, GROUP_CONCAT(user.nama) AS nama FROM pembuat_pekerjaan LEFT JOIN user ON pembuat_pekerjaan.username = user.username GROUP BY id_register) AS b ON `register_masuk`.`id_register` = `b`.`id_register` LEFT JOIN (SELECT count(*) AS jmldoc, id_register, id_surat as type_surat FROM detail_register_masuk GROUP BY id_register ORDER BY id_surat DESC) c ON `register_masuk`.`id_register` = `c`.`id_register` LEFT JOIN `pengembalian_surat` `d` ON `register_masuk`.`id_register` = `d`.`id_register` LEFT JOIN pembatalan e ON register_masuk.id_register = e.id_register) a');
		
		$this->db->join('status b', 'a.status = b.id_status', 'LEFT');
		$this->db->join('(SELECT * FROM `comment_register` WHERE created_at in (SELECT MAX(created_at) from comment_register GROUP BY id_register) ) c', 'a.id_register = c.id_register', 'LEFT');
	    if($this->input->post('divisi') != 'All'){
	    	$this->db->where('divisi', $this->input->post('divisi'));
	    

	    }
	    if($this->input->post('tahun') != 'All'){
	    	$this->db->where('tahun', $this->input->post('tahun'));
	    }
	    
	    if($this->input->post('my_task') != '' && $this->input->post('my_task') == "All"){
	    	$this->db->where('status !=','');
	    	
	    }elseif($this->input->post('my_task') != "All"){
	    	$status = $this->input->post('my_task');
	    	
	    	$this->db->where('status',$status);
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

	public function add_data_masuk($id,  $divisi, $jenis, $email, $tglemail, $nosurat, $tglsurat, $perihal, $user, $kelompok,$tglterimasurat, $tglterimaemail, $tahun, $status, $beban, $anggaran, $idr){
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
					  'status_data'=>$status,
					  'id_register_sebelum'=>$idr);
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
		$this->db->select('a.id_register, a.tgl_register, a.divisi, a.email, a.tgl_email, a.tgl_terima_email, a.kelompok, a.no_surat, a.tgl_surat, a.perihal, a.tgl_terima_surat, a.jenis_surat, a.tgl_disposisi_pimkel, a.tgl_disposisi_manajer, a.keterangan, a.tahun, a.nama, a.username, a.id_detail_register, a.no_kontrak, a.nm_vendor, a.jenis_pengadaan, a.user, b.keterangan as status_data, a.tempat_pengadaan, a.no_srt_llg, a.tgl_srt_llg, a.perihal_llg, a.tgl_kembali, a.no_pengembalian, a.tgl_srt_pengembalian, a.alasan, a.alasan_batal, a.tgl_pembatalan, a.tgl_srt_btl, a.no_srt_btl, e.jmlp');
		$this->db->from('(SELECT `register_masuk`.`id_register`, `register_masuk`.`tgl_register`, `register_masuk`.`divisi`, `register_masuk`.`email`, `register_masuk`.`tgl_email`, `register_masuk`.`tgl_terima_email`, `register_masuk`.`kelompok`, `register_masuk`.`no_surat`, `register_masuk`.`tgl_surat`, `register_masuk`.`perihal`, `register_masuk`.`tgl_terima_surat`, `register_masuk`.`jenis_surat`, `register_masuk`.`tgl_disposisi_pimkel`, `register_masuk`.`tgl_disposisi_manajer`, `register_masuk`.`keterangan`, `register_masuk`.`tahun`, `b`.`nama`, `b`.`username`, `id_detail_register`, `a`.`no_kontrak`, `a`.`nm_vendor`, `jenis_pengadaan_reg`.`jenis_pengadaan`, `register_masuk`.`user`, IF(f.id is not null, 20, IF(d.tgl_kembali is not null, 21, IF(jenis_pengadaan_reg.jenis_pengadaan = "Pembelian Langsung" AND e.jmldoc > 0, 19, IF(e.jmldoc > 0, 19,18)))) as status_data, `jenis_pengadaan_reg`.`tempat_pengadaan`, `c`.`no_surat` as `no_srt_llg`, `c`.`tgl_surat` as `tgl_srt_llg`, 
			`c`.`perihal` as `perihal_llg`,
			`d`.`tgl_kembali`, `d`.`no_surat` as `no_pengembalian`, `d`.`tgl_surat` as `tgl_srt_pengembalian`, `d`.`alasan`, f.alasan as alasan_batal, f.tgl_pembatalan, f.tgl_surat as tgl_srt_btl, f.no_surat as no_srt_btl FROM `register_masuk` LEFT JOIN (SELECT id_register, GROUP_CONCAT(pembuat_pekerjaan.username) AS username, GROUP_CONCAT(user.nama SEPARATOR ", ") AS nama FROM pembuat_pekerjaan LEFT JOIN user ON pembuat_pekerjaan.username = user.username GROUP BY id_register) AS b ON `register_masuk`.`id_register` = `b`.`id_register` LEFT JOIN (SELECT a.id_register, GROUP_CONCAT(a.id_detail_register) id_detail_register, GROUP_CONCAT( CONCAT(a.no_surat,"|", a.tgl_surat,"|", b.jenis_surat, "|", tdr.nm_vendor) SEPARATOR "&") no_kontrak, GROUP_CONCAT(tdr.nm_vendor SEPARATOR "
") nm_vendor FROM detail_register_masuk a LEFT JOIN tdr ON a.id_vendor = tdr.id_vendor LEFT JOIN jenis_surat b ON b.id_surat = a.id_surat GROUP BY id_register) a ON `register_masuk`.`id_register` = `a`.`id_register` LEFT JOIN `pengumuman_lelang` `c` ON `register_masuk`.`id_register` = `c`.`id_register` LEFT JOIN `jenis_pengadaan_reg` ON `register_masuk`.`id_register` = `jenis_pengadaan_reg`.`id_register` LEFT JOIN (SELECT count(*) AS jmldoc, id_register FROM detail_register_masuk GROUP BY id_register) e ON `register_masuk`.`id_register` = `e`.`id_register` LEFT JOIN `pengembalian_surat` `d` ON `register_masuk`.`id_register` = `d`.`id_register` LEFT JOIN pembatalan f ON register_masuk.id_register = f.id_register) as a');
		$this->db->join('status b', 'a.status_data = b.id_status', 'LEFT');
		$this->db->join('(SELECT id_register, count(username) as jmlp FROM pembuat_pekerjaan GROUP BY id_register) e','a.id_register = e.id_register','LEFT');
		$this->db->where('a.id_register', $id);
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
		$data = array('status_data'=>'19');
		$this->db->where('id_register', $id);
		
		return $this->db->update($this->table, $data);
	}

	public function hapus_register($id)
	{	
		$this->db->where('id_register', $id);
		return $this->db->update('register_masuk', array('deleted_at'=>date('Y-m-d')));
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
					  'tgl_terima_surat'=>$tgltrm,
					  'email'=>'');
		$this->db->where('id_register', $id);
		return $this->db->update($this->table, $data);
	}

	public function select_jenis_surat($delete = null)
	{
		$this->db->select('*');
		$this->db->from('jenis_surat');
		$this->db->where('deleted_at', $delete);
		return $this->db->get();
	}

	public function get_last_id($idregister)
	{
		$this->db->select('id_detail_register');
		$this->db->from('detail_register_masuk');
		$this->db->where('id_register', $idregister);
		$this->db->order_by('id_detail_register', 'DESC');
		$this->db->limit(1);
		return $this->db->get();
	}

	public function new_aanwijzing($id, $idp, $tgl, $jam, $tempat, $perihal, $peserta)
	{
		$data = array('id'=>$id,
					  'id_register'=>$idp,
					  'tgl'=>$tgl,
					  'jam'=>$jam,
					  'tempat'=>$tempat,
					  'perihal'=>$perihal,
					  'peserta'=>$peserta);
		return $this->db->insert('aanwijzing', $data);
	}

	public function get_aanwijzing($id)
	{
		$this->db->select('*');
		$this->db->from('aanwijzing');
		$this->db->where('id_register', $id);
		return $this->db->get();
	}

	public function add_auction($id, $idregister, $tempat, $tanggal, $jam)
	{
		$data = array('id'=>$id,
					  'id_register'=>$idregister,
					  'tempat'=>$tempat,
					  'tanggal'=>$tanggal,
					  'jam'=>$jam);
		return $this->db->insert('auction', $data);
	}

	public function get_auction($id){
		$this->db->select('id, a.id_register, a.tempat, a.tanggal, a.jam, GROUP_CONCAT(b.nm_vendor SEPARATOR ";<br>") AS vendor');
		$this->db->from('auction a');
		$this->db->join('(SELECT a.id_register, b.nm_vendor FROM vendor_auction a LEFT JOIN tdr b ON a.id_vendor = b.id_vendor) b', 'a.id_register = b.id_register', 'LEFT');
		$this->db->group_by('id_register');
		$this->db->where('a.id_register', $id);
		return $this->db->get();
	}

	public function get_ven_auc($id)
	{
		$this->db->select('id, id_register, a.id_auction, a.id_vendor, b.nm_vendor');
		$this->db->from('vendor_auction a');
		$this->db->join('tdr b', 'a.id_vendor = b.id_vendor', 'LEFT');
		$this->db->where('id_register', $id);
		return $this->db->get();
	}

	public function add_pengumuman_lelang($id, $idr, $no_surat, $tgl_surat, $perihal)
	{	
		$data = array('id'=>$id,
					'id_register'=>$idr,
					'no_surat'=>$no_surat,
					'tgl_surat'=>$tgl_surat,
					'perihal'=>$perihal);
		return $this->db->insert('pengumuman_lelang', $data);
	}

	public function cek_jenis($id)
	{	
		$this->db->from('jenis_pengadaan_reg');
		$this->db->where('id_register', $id);
		return $this->db->get();
	}

	public function update_jenis($id, $jenis, $tempat)
	{
		$data = array(
			'jenis_pengadaan'=>$jenis,
			'tempat_pengadaan'=>$tempat);
		$this->db->where('id_register',$id);
		return $this->db->update('jenis_pengadaan_reg', $data);
	}

	public function cek_status_done($idr)
	{
		$this->db->from('detail_register_masuk', $idr);
		$this->db->where('id_register', $idr);
		$this->db->where('id_surat', 4);
		return $this->db->get();

	}

	public function new_return($id, $idr, $tglk, $no, $tgls, $alasan)
	{
		$data = array('id_return'=>$id,
			'id_register'=>$idr,
			'tgl_kembali'=>$tglk,
			'no_surat'=>$no,
			'tgl_surat'=>$tgls,
			'alasan'=>$alasan);
		return $this->db->insert('pengembalian_surat', $data);
	}

	public function new_comment_register($id, $idr, $comment, $comment_by)
	{
		$data = array('id'=>$id,
			'id_register'=>$idr,
			'comment'=>$comment,
			'comment_by'=>$comment_by);
		return $this->db->insert('comment_register', $data);
	}

	public function get_comment($id)
	{
		
		$this->db->from('comment_register');
		$this->db->join('user', 'comment_register.comment_by = user.username', 'LEFT');
		$this->db->where('id_register', $id);
		$this->db->order_by('created_at', 'DESC');


		return $this->db->get();
	}

	public function new_pfa($id, $idr, $tglkirim, $no, $tgl, $perihal)
	{
		$data = array('id'=>$id,
			'id_register'=>$idr,
			'tgl_kirim'=>$tglkirim,
			'no_surat'=>$no,
			'tgl_surat'=>$tgl,
			'perihal'=>$perihal);
		return $this->db->insert('surat_ke_pfa',$data);
	}

	public function get_pfa($idr)
	{
		$this->db->from('surat_ke_pfa');
		$this->db->where('id_register', $idr);
		return $this->db->get();
	}

	public function pembatalan($id, $idr, $tglb, $no, $tgls, $alasan)
	{
		$data = array('id'=>$id,
			'id_register'=>$idr,
			'tgl_pembatalan'=>$tglb,
			'no_surat'=>$no,
			'tgl_surat'=>$tgls,
			'alasan'=>$alasan);
		return $this->db->insert('pembatalan', $data);
	}

	public function get_list_status()
	{
		$this->db->from('status');
		$this->db->where('menu', 'Register Masuk');
		return $this->db->get();
	}

	public function get_my_task($user, $status = 18)
	{
		$this->db->select('a.id_register, a.username, a.status_data');
		$this->db->from('(SELECT `register_masuk`.`id_register`, `b`.`username`,
		IF(f.id is not null, 20, 
		IF(d.tgl_kembali is not null, 21, 
		IF(jenis_pengadaan_reg.jenis_pengadaan = "Pembelian Langsung" AND e.jmldoc > 0, 19, IF(e.jmldoc > 0, 19, 18)))) as status_data FROM `register_masuk` 
		LEFT JOIN pembuat_pekerjaan AS b ON `register_masuk`.`id_register` = `b`.`id_register` LEFT JOIN `jenis_pengadaan_reg` ON `register_masuk`.`id_register` = `jenis_pengadaan_reg`.`id_register` 
		LEFT JOIN (SELECT count(*) AS jmldoc, id_register FROM detail_register_masuk GROUP BY id_register) e ON `register_masuk`.`id_register` = `e`.`id_register` LEFT JOIN `pengembalian_surat` `d` ON `register_masuk`.`id_register` = `d`.`id_register` LEFT JOIN pembatalan f ON register_masuk.id_register = f.id_register) a');
		$this->db->where('a.username', $user);
		$this->db->where('a.status_data', $status);
		return $this->db->get();
	}

	public function cek_pembuat($id)
	{
		$this->db->select('id_register, id_pembuat');
		$this->db->from('pembuat_pekerjaan');
		$this->db->where('id_register', $id);
		return $this->db->get();
	}

	

}