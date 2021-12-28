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
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */


	var $table = 'user';
    var $column_order = array('a.id_user', 'a.tgl_permintaan', 'a.no_rekening_pskt', 'a.nama_rekening_pskt', 'a.user', 'a.perihal', 'a.nominal', 'a.tgl_proses', 'a.tgl_penyelesaian', 'a.sli', 'status.status', 'a.id');//,'status');
    //field yang ada di table user
	var $column_search = array('`id_user`, `username`, `nama`, `password`, `role`, `recovery_q`, `answer_rec`, `status`, `profil_pict`, `jabatan`, `birthdate`, `email`');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('id_user'=>'desc'); //default sort */

	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}

	private function _get_datatables_query() 
	{
		$this->db->select('`id_user`, `username`, `nama`, `password`, `role`, `recovery_q`, `answer_rec`, `status`, `profil_pict`, `jabatan`, `birthdate`, `email`');
		$this->db->from($this->table);
		
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
		return $this->db->get();
		
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
					  'password'=>$this->hash_password($newpassword));
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

	public function update_status($id, $val){
		$data = array(
			'status'=>$val);
		$this->db->where('id_user', $id);
		return $this->db->update('user', $data);
	}

	
}
