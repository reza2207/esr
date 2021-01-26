<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Broadcast_model extends CI_Model {

	var $table = 'broadcast';


	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	public function send_broadcast($nama, $msg, $sendto, $time)
	{
		$data = array('chat'=>$msg,
			'send_by'=>$_SESSION['username'],
			'send_to'=>$sendto,
			'created_at'=>$time);
		return $this->db->insert('broadcast', $data);
	}

	public function get_broadcast($sendto)
	{
		$this->db->select('`broadcast.id`, `broadcast.chat`, `broadcast.send_by`, `broadcast.send_to`, `broadcast.created_at`, `broadcast.deleted_at`,`user.nama`,`user.profil_pict`, `a.nama as nm`, (SELECT defaultnya FROM settings WHERE namasetting = "dir_foto") AS loc ');
		$this->db->from('broadcast');
		$this->db->join('user', 'broadcast.send_by = user.username', 'LEFT');
		$this->db->join('user a', 'broadcast.send_to = a.username', 'LEFT');
		if($sendto == 'all'){
			$this->db->where('broadcast.send_to', $sendto);
		}else{
			$this->db->where('broadcast.send_to', $sendto);
			$this->db->or_where('broadcast.send_by', $sendto);
			$this->db->where('broadcast.send_to !=', 'all');
		}
		$this->db->order_by('broadcast.id', 'ASC');
		return $this->db->get();
	}
}