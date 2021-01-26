<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class User_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function create_user($username, $password, $fullname, $recovery, $answer, $role, $status = null) {
		$this->load->library('encryption');
	
		
		if($status !== null){
			$data = array (
				'username'=>$username, 
				'password'=>$this->hash_password($password),
				'nama'=>$fullname,
				'role'=>$role,
				'recovery_q'=>$recovery,
				'answer_rec'=>$answer,
				'status' => $status
				);
		}else{
			$data = array (
				'username'=>$username, 
				'password'=>$this->hash_password($password),
				'nama'=>$fullname,
				'role'=>$role,
				'recovery_q'=>$recovery,
				'answer_rec'=>$answer
				);
		}
		return $this->db->insert('user', $data);
		
	}
	
	/**
	 * resolve_user_login function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function resolve_user_login($username, $password) {
		
		$this->db->select('password');
		$this->db->from('user');
		$this->db->where('username', $username);
		$hash = $this->db->get()->row('password');
		
		return $this->verify_password_hash($password, $hash);
		
	}
	
	
	/**
	 * get_user function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user($username) {
		
		$this->db->from('user');
		$this->db->where('username', $username);
		return $this->db->get()->row();
		
	}

	public function check_available_username($username){

		$this->db->from('user');
		$this->db->where('username', $username);
		return $this->db->count_all_results();
	}
	
	/**
	 * hash_password function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	private function hash_password($password) {
		
		return password_hash($password, PASSWORD_BCRYPT);
		
	}
	
	/**
	 * verify_password_hash function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verify_password_hash($password, $hash) {
		
		return password_verify($password, $hash);
		
	}

	public function select_user($role = NULL, $none = null){
		
		$this->db->select('username, nama, profil_pict');
		$this->db->from('user');
		$this->db->where('status', 'aktif');
		
		
		
		
		return $this->db->get();

	}

	public function get_name($username)
	{
		$this->db->select('GROUP_CONCAT(nama) AS nama');
		$this->db->from('user');
		$this->db->where_in('username', $username);
		return $this->db->get();
		
	}

	public function get_detail($username)
	{
		$this->db->select('username, recovery_q,answer_rec');
		$this->db->from('user');
		$this->db->where('username', $username);
		return $this->db->get();
	}

	public function submit_new_pass($username, $newpassword)
	{
		$data = array('password'=>$this->hash_password($newpassword));
		$this->db->where('username', $username);
		return $this->db->update('user', $data);
	}

	public function check_answer($username, $question, $answer)
	{
		$this->db->from('user');
		$this->db->where('username', $username);
		$this->db->where('recovery_q', $question);
		$this->db->where('answer_rec', $answer);
		return $this->db->get();
	}

	public function update_photo($username, $profilpict)
	{
		$this->db->where('username', $username);
		return $this->db->update('user', array('profil_pict'=>$profilpict));
	}

	public function update_profil($username, $newpassword)//, $question, $answer)
	{
		$data = array(//'recovery_q'=>$question,
					  //'answer_rec'=>$answer,
					  '$newpassword'=>$this->hash_password($newpassword));
		$this->db->where('username', $username);
		return $this->db->update('user', $data);
	}

	public function pemutus_warkat($params)
	{
		$this->db->select('*');
		$this->db->from('pemutus_warkat');
		$this->db->where('status', $params);
		$this->db->order_by('id_pemutus', 'DESC');
		return $this->db->get();
	}

	public function update_log($kata, $iduser)
	{
		$tgl = date('Y-m-d H:i:s');
		$data = array('user' => $iduser,
					'kegiatan'=>$kata,
					'tanggal'=>$tgl);
		return $this->db->insert('log', $data);
	}

	
}
