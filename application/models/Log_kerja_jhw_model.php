<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Log_kerja_jhw_model extends CI_Model {

	var $table = 'log_kerja';
	var $column_order = array('id_log', 'tanggal', 'nama', 'kelompok','keterangan','pic','status','done','tgl_done', 'jam_input');//,'status');//field yang ada di table user
	var $column_search = array('id_log', 'tanggal', 'nama', 'kelompok','keterangan','pic','status','done','tgl_done', 'jam_input');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('tanggal'=>'desc'); //default sort
	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	private function _get_datatables_query() 
	{
		$this->db->select('`id_log`, `hari`, `tanggal`, `nama`, `kelompok`, `keterangan`, `pic`, `status`, `tgl_done`, `jam_input`, `date_created`');
		$this->db->from('log_kerja');
		$this->db->where('deleted_at', NULL);
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


	public function get_detail($id)
	{
		$this->db->select('a.id_pks, a.tgl_minta, a.no_srt_pelaksana, a.no_notin, a.perihal, a.tgl_krj_awal, a.tgl_krj_akhir, a.tgl_ke_legal, a.tgl_draft_ke_user, a.tgl_draft_ke_user, a.tgl_draft_ke_vendor, a.tgl_review_send_to_legal, a.tgl_ke_vendor, a.tgl_blk_dr_vendor_ke_legal, a.tgl_ke_vendor_kedua, a.nm_vendor, a.reminder, a.beda, a.nominal_rp, a.bg_rp, a.no_pks, a.tgl_pks, IFNULL(b.keterangan, "") segera, status.keterangan AS status, a.id_vendor, a.file, c.no_surat, c.tgl_surat, c.perihal as prhl');
		$this->db->from('(SELECT `pks`.`id_pks`, `pks`.`tgl_minta`, `pks`.`no_srt_pelaksana`, `pks`.`no_notin`, `pks`.`perihal`, `pks`.`nominal_rp`, `pks`.`tgl_krj_awal`, `pks`.`tgl_krj_akhir`, `pks`.`tgl_ke_legal`, `pks`.`tgl_draft_ke_user`, `pks`.`tgl_draft_ke_vendor`, `pks`.`tgl_review_send_to_legal`, `pks`.`tgl_ke_vendor`, `pks`.`tgl_blk_dr_vendor_ke_legal`, `tgl_ke_vendor_kedua`, `pks`.`bg_rp`, `pks`.`no_pks`, `pks`.`tgl_pks`, `tdr`.`nm_vendor`, IF(pks.reminder = "y", "Done", "-") AS reminder, IF(pks.tgl_ke_legal = "0000-00-00", "1", IF(pks.tgl_draft_ke_user = "0000-00-00" AND pks.tgl_draft_ke_vendor = "0000-00-00", "2", IF(pks.tgl_review_send_to_legal = "0000-00-00", "3", IF(pks.tgl_ke_vendor = "0000-00-00", "4", IF(pks.tgl_blk_dr_vendor_ke_legal = "0000-00-00", "5", IF(pks.tgl_ke_vendor_kedua = "0000-00-00", "6", IF(pks.tgl_ke_vendor_kedua != "0000-00-00" AND pks.tgl_krj_akhir > current_date, "7", "8"))))))) AS status, datediff(pks.tgl_krj_akhir, curdate()) as beda, IF(datediff(pks.tgl_krj_akhir, curdate()) > 0 AND datediff(pks.tgl_krj_akhir, curdate()) < 180, "9", "") AS segera, `pks`.`id_vendor`, `pks`.`file` FROM `pks` LEFT JOIN `tdr` ON `pks`.`id_vendor` = `tdr`.`id_vendor`) a');
		$this->db->join('status', 'a.status = status.id_status', 'LEFT');
		$this->db->join('status AS b', 'a.segera = b.id_status', 'LEFT');
		$this->db->join('(SELECT * FROM `reminder_pks` WHERE tgl_surat in (SELECT MAX(tgl_surat) from reminder_pks GROUP BY id_pks) ) c', 'a.id_pks = c.id_pks', 'LEFT');
		//$this->db->join('expired', 'a.segera = expired.id_exp', 'LEFT');
		$this->db->where('a.id_pks', $id);
		return $this->db->get();
	}

	public function get_id_comment($idpks)
	{
		$this->db->select('id_comment');
		$this->db->from('comment_pks');
		$this->db->where('id_pks', $idpks);
		$this->db->order_by('id_comment desc');
		$this->db->limit('1');
		return $this->db->get();
	}

	public function input_comment($comment_id, $id_pks, $comment, $comment_by, $comment_date)
	{
		

		$data = array(
			'id_comment' =>$comment_id,
			'id_pks' =>$id_pks,
			'comment'=>$comment,
			'comment_by'=>$comment_by,
			'comment_date'=>$comment_date);
		return $this->db->insert('comment_pks', $data);

	}

	public function get_comment($id)
	{
		$this->db->select('comment_pks.id_comment, comment_pks.comment, user.nama, comment_pks.comment_date');
		$this->db->from('comment_pks');
		$this->db->join('user', 'comment_pks.comment_by = user.username', 'left');
		$this->db->where('id_pks', $id);
		$this->db->order_by('id_comment', 'DESC');
		return $this->db->get();
	}

	public function update_pks($id, $nopenunjukan, $tglminta, $nousulan, $idtdr, $perihal, $tglawal, $tglakhir, $nominalrp, $nominalusd, $bankgaransi,$tgldraftdarilegal, $tgldraftkeuser,$tgldraftkevendor,$tglreviewkelegal,$tglttdkevendor,$tglttdkepemimpin,$tglserahterimapks, $tglpks, $nopks, $file)
	{
		$data = array(
			'no_srt_pelaksana' => $nopenunjukan,
			'tgl_minta' =>$tglminta,
			'id_vendor' =>$idtdr,
			'no_notin' => $nousulan,
			'perihal' => $perihal,
			'tgl_krj_awal' => $tglawal,
			'tgl_krj_akhir' =>$tglakhir,
			'nominal_usd' =>$nominalusd,
			'nominal_rp'=>$nominalrp,
			'bg_rp' => $bankgaransi,
			'tgl_ke_legal' =>$tgldraftdarilegal,
			'tgl_draft_ke_vendor' =>$tgldraftkevendor,
			'tgl_draft_ke_user' =>$tgldraftkeuser,
			'tgl_review_send_to_legal'=> $tglreviewkelegal,
			'tgl_ke_vendor'=>$tglttdkevendor,
			'tgl_blk_dr_vendor_ke_legal'=>$tglttdkepemimpin,
			'tgl_ke_vendor_kedua'=>$tglserahterimapks,
			'no_pks'=>$nopks,
			'tgl_pks'=>$tglpks,
			'file'=>$file);

		$this->db->where('id_pks', $id);
		return $this->db->update('pks', $data);
	}

	public function delete($id)
	{	
		$data = array(
			'deleted_at'=>date('Y-m-d H:i:s')
		);

		$this->db->where('id_log', $id);
		return $this->db->update('log_kerja', $data);
	}

	
	public function store($nama, $hari, $tanggal, $kelompok, $keterangan, $pic, $status)
	{
		$data = array(
			'hari' => $hari,
			'tanggal'=>$tanggal,
			'nama'=>$nama,
			'kelompok'=>$kelompok,
			'keterangan'=>$keterangan,
			'pic'=>$pic,
			'status'=>$status
		);

		return $this->db->insert('log_kerja', $data);
	}

	public function list_reminder($days){
		$this->db->select('pks.no_srt_pelaksana, pks.perihal, pks.tgl_krj_akhir, datediff(pks.tgl_krj_akhir, curdate()) as beda');
		$this->db->from($this->table);
		$this->db->where('datediff(pks.tgl_krj_akhir, curdate()) > ',0);
		$this->db->where('datediff(pks.tgl_krj_akhir, curdate()) <= ',$days);
		return $this->db->get();

	}

	public function last_id($year)
	{
		$this->db->select('pks.id_pks');
		$this->db->from($this->table);
		$this->db->where('YEAR(tgl_minta)',$year);
		$this->db->order_by('id_pks', 'DESC');
		$this->db->limit('1');

		return $this->db->get();
	}

	public function get_file($id)
	{
		$this->db->select('file');
		$this->db->from($this->table);
		$this->db->where('id_pks', $id);
		return $this->db->get();
	}

	public function add_reminder($id, $idpks, $no, $tgl, $perihal, $file)
	{
		$data = array('id'=>$id,
			          'id_pks'=> $idpks,
			          'no_surat'=>$no,
			          'tgl_surat'=>$tgl,
			          'perihal'=>$perihal,
			          'file'=>$file);
		return $this->db->insert('reminder_pks', $data);
	}

	public function data_reminder($id)

	{
		$this->db->from('reminder_pks');
		$this->db->where('id_pks', $id);
		$this->db->order_by('tgl_surat','DESC');
		return $this->db->get();
	}
}