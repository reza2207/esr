<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct(){

		parent::__construct();
		
		$this->load->helper(array('form', 'url', 'terbilang_helper','tanggal_helper'));
		date_default_timezone_set("Asia/Bangkok");
	}	


	public function index() {	
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Welcome '.$_SESSION['nama'].'!';
			$data->page = 'User';

			$this->load->view('header', $data);
			

		}else{
			
			$this->load->view('header_login');
			$this->load->view('login');
		}
	}

	public function add_user()
	{
		$_SESSION['role'] = 'superuser';
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Register';
			$data->page = 'Register';
			$this->load->view('header', $data);
			$this->load->view('add_user');
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}

	}
	public function profile($user = 'Reza')
	{
		$this->load->view('profile');

	}

	public function login() {
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			$data = new stdClass();
			$data->title = 'Welcome '.$_SESSION['nama'].'!';
			$this->load->view('header', $data);
			$this->load->view('index');
			
		}else{
			// create the data object
			$data = new stdClass();
			
			// load form helper and validation library
			$this->load->helper('form');
			$this->load->library('form_validation');
			
			// set validation rules
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if ($this->form_validation->run() == false) {
				
				$errors = validation_errors();
	            $respons_ajax['status'] = 'error';
	            $respons_ajax['pesan'] = $errors;
				
			} else {

				// set variables from the form
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				
				if ($this->User_model->resolve_user_login($username, $password)) {
					
					$user  = $this->User_model->get_user($username);
					
					if($user->status == 'aktif'){
						// set session user datas
						$_SESSION['username']     = (string)$user->username;
						$_SESSION['logged_in']    = (bool)true;
						$_SESSION['role']     = $user->role;
						$_SESSION['nama'] = (string)$user->nama;
						$_SESSION['icon'] = $user->profil_pict == '' ? '/gambar/profile/user.png' : $user->profil_pict ;
						$_SESSION['jabatan'] = $user->jabatan;
						$respons_ajax['status'] = 'success';
						$respons_ajax['pesan'] = 'Welcome <b>'.$user->nama.'</b>';
						
						$kata = $_SESSION['nama'].' is Login.';
						$respons_ajax['kata'] = $kata;
						$this->User_model->update_log($kata, $_SESSION['username']);
					}else{
						$respons_ajax['status'] = 'error';
						$respons_ajax['pesan'] = 'Sorry your account is inactive, please call admin';
					}

					
				} else {
					
					// login failed
					$respons_ajax['status'] = 'error';
					$respons_ajax['pesan'] = 'Wrong Username or Password';
										
				}

				
				
			}

			return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($respons_ajax));
		}
	}

	public function logout() {
		
		// create the data object
		$data = new stdClass();
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$kata = $_SESSION['nama'].' is logout.';
			$this->User_model->update_log($kata, $_SESSION['username']);
			// remove session datas
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			$kata = $_SESSION['nama'].' Login';
			
			// user logout ok
			redirect(base_url());
		} else {
			
			// there user was not logged in, we cannot logged him out,
			// redirect him to site root
			redirect(base_url());
			
		}
		
	}

	public function submit_register(){

		if($this->input->post(null)){

			if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
				$data = new stdClass();
				$data->title = 'Register';
				//initialize button submit
			
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');
				$this->load->library('encryption');
				
				$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]',
						array('required' => 'You must provide a %s.')
				);
				$this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|min_length[3]');
				$this->form_validation->set_rules('recovery', 'Recovery Question', 'required|trim|min_length[10]');
				$this->form_validation->set_rules('recovery_answer', 'Recovery Answer', 'required|trim');
				$this->form_validation->set_rules('role', 'Role', 'required');
				
				if ($this->form_validation->run() == FALSE){

					$errors = validation_errors();
					$respons_ajax['status'] = 'error';
					$respons_ajax['pesan'] = $errors;

				}
				else{
					$username = $this->input->post('username',TRUE);
					$password = $this->input->post('password');
					$fullname = $this->input->post('full_name',TRUE);
					$recovery = $this->input->post('recovery', TRUE);
					$answer = $this->input->post('recovery_answer', TRUE);
					$role = $this->input->post('role');

					$this->User_model->create_user($username, $password, $fullname, $recovery, $answer, $role);
					$respons_ajax['status'] = 'success';
					$respons_ajax['pesan'] = 'Register Success';
					$kata = $_SESSION['nama'].' Menambahkan Login '.$username.'('.$fullname.')';
					$this->User_model->update_log($kata, $_SESSION['username']);		
				}
				
				return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($respons_ajax));
			}else{
				$data = new stdClass();
				$data->title = 'Register';
				//initialize button submit
			
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');
				$this->load->library('encryption');
				
				$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]',
						array('required' => 'You must provide a %s.')
				);
				$this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|min_length[3]');
				$this->form_validation->set_rules('recovery', 'Recovery Question', 'required|trim|min_length[10]');
				$this->form_validation->set_rules('recovery_answer', 'Recovery Answer', 'required|trim');
				
				if ($this->form_validation->run() == FALSE){

					$errors = validation_errors();
					$respons_ajax['status'] = 'error';
					$respons_ajax['pesan'] = $errors;

				}
				else{
					$username = $this->input->post('username',TRUE);
					$password = $this->input->post('password');
					$fullname = $this->input->post('full_name',TRUE);
					$recovery = $this->input->post('recovery', TRUE);
					$answer = $this->input->post('recovery_answer', TRUE);
					$role = 'user';
					$status = 'non aktif';

					$this->User_model->create_user($username, $password, $fullname, $recovery, $answer, $role, $status);
					$respons_ajax['status'] = 'success';
					$respons_ajax['pesan'] = 'Register Success';
					$kata = ' Menambahkan Login '.$username.'('.$fullname.')';
					$this->User_model->update_log($kata, 'newuser');		
				}
				
				return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($respons_ajax));
			}
		}else{
			show_404();
		}
	}


	public function forgot_password(){

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			show_404();
		}else{

			$data = new stdClass();
			$this->load->view('header_login');
			$this->load->view('forgot_password');
		}
	}

	public function check_user(){
		if($this->input->post(null)){
			$username = $this->input->post('username');

			$data = new stdClass();
			if($this->User_model->get_detail($username)->num_rows() == 0)
			{
				
				$data->type = 'error';
				$data->message = 'Username Not Found';
				
			}else{
				
				$data->type = 'success';
				$data->message = $this->User_model->get_detail($username)->row('recovery_q');
				
			}
			return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($data));
		}
	}

	public function submit_answer()
	{
		if($this->input->post(null)){
			$username = $this->input->post('username');
			$question = $this->input->post('question');
			$answer = $this->input->post('answer');

			$data = new stdClass();
			if($this->_check_answer($username, $question, $answer)){
				
				$data->type = 'success';
				
			}else{
				
				$data->type = 'error';
				$data->message = 'Sorry, your answer is wrong';
				
			}
			return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($data));
		}else{

			show_404();
		}
	}

	protected function _check_answer($username, $question, $answer){

		if($this->User_model->check_answer($username, $question, $answer)){
			return true;
		}else{
			return false;
		}
	}

	public function submit_new_password()
	{
		if($this->input->post(null))
		{

			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]',
	                array('required' => 'You must provide a %s.')
	        );
 			if ($this->form_validation->run() == FALSE){

	            $errors = validation_errors();
	            $respons_ajax['status'] = 'error';
	            $respons_ajax['pesan'] = $errors;
				return $this->output
				->set_content_type('application/json')
				->set_output(json_encode($respons_ajax));

	        }else{
				$username = $this->input->post('username');
				$newpassword = $this->input->post('password');
				if($this->User_model->submit_new_pass($username, $newpassword))
				{
					$data = new stdClass();
					$data->type = 'success';
					$data->message = 'Your password is updated!';
					
					$kata = $username.' Telah Merubah Password Dalam Fitur Lupa Password';
					$this->User_model->update_log($kata, $username);
				}else{
					$data = new stdClass();
					$data->type = 'error';
					$data->message = 'Failed to update';
				}
				return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($data));
			}
		}else{
			show_404();
		}
	}



	public function change_profile()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{
			if($this->input->post(null)){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
				/*$this->form_validation->set_rules('question', 'Recovery Question', 'required|trim|min_length[10]');
	        	$this->form_validation->set_rules('answer', 'Recovery Answer', 'required|trim');*/

				if ($this->form_validation->run() == FALSE){

				}else{
					$username = $_SESSION['username'];
					$newpassword = $this->input->post('newpassword');
					//$question = $this->input->post('question');
					//$answer = $this->input->post('answer');

					//if($this->User_model->update_profil($username, $newpassword, $question, $answer))
					if($this->User_model->update_profil($username, $newpassword))
					{
						$data = new stdClass();
						$data->type = 'success';
						$data->message = 'Your password is updated!';
						$kata = $_SESSION['nama'].' Telah Merubah Password';
						$this->User_model->update_log($kata, $_SESSION['username']);

					}else{
						$data = new stdClass();
						$data->type = 'error';
						$data->message = 'Failed to update';
					}

					return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($data));
				}
				

			}else{
				show_404();
			}

		}else{
			show_404();
		}
	}

	public function list_pegawai(){
        header('Content-Type: application/json');
        $query = $this->db->get('pegawai');
        if ($query){
            $response = array(
                "data" => $query->result(),
                "message" => "OK",
            );
        }else{
            $response = array(
                "data" => array(),
                "message" => "Table Empty"
            );
        }
	
		return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($response));
	}
	
	public function daftar_baru()
	{
		
		$data['page'] = true;
		$this->load->view('header_login',$data);
		$this->load->view('add_user');
	}

	
}