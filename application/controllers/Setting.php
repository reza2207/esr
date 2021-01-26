<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {
	
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
		$this->load->model('User_model');
		$this->load->model('Pks_model');
		$this->load->model('Setting_model');
		$this->load->model('Master_setting_model');
		$this->load->model('Register_masuk_model');
		$this->load->helper(array('form', 'url', 'terbilang_helper','tanggal_helper'));
		$this->load->library('form_validation');
		date_default_timezone_set("Asia/Bangkok");

	}	


	public function index()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Settings';
			$data->page = 'Settings';
			
			$username = $_SESSION['username'];
			$data->user = $this->get_detail_account($username);
			

			$this->load->view('header', $data);
			$this->load->view('setting');
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
		
	}

	private function get_detail_account($username)
	{
		return $this->User_model->get_user($username);
	}

	public function update_photo_profile()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$config['upload_path']          = $this->_dir_profile();
            $config['allowed_types']        = 'gif|jpg|jpeg';
            $config['max_size']             = 1024;
            //$config['max_width']          = 150;
            //$config['max_height']         = 150;
            $config['encrypt_name']			= TRUE;
            $this->load->library('upload', $config);
            
        	$data = new stdClass();
            if ( ! $this->upload->do_upload('image'))
            {
        		$data->type = 'error';
                $data->message = $this->upload->display_errors();
                echo json_encode($data);
            }
            else
            {
            	$profilpict = $this->upload->data('file_name');
            	$username =  $_SESSION['username'];
            	$configimg['image_library'] = 'gd2';
				$configimg['source_image'] = $profilpict;
				$configimg['create_thumb'] = FALSE;
				$configimg['maintain_ratio'] = TRUE;
				//$configimg['width']         = 150;
				//$configimg['height']       = 150;

				$this->load->library('image_lib', $configimg);				
				$this->image_lib->resize();
				
				if($this->User_model->update_photo($username, $profilpict))
				{
					$data->type = 'success';
					$data->message = 'Success!';
					echo json_encode($data);
				}else{

					$data->type = 'error';
					$data->message = 'Failed!';
					unset($profilpict);
					echo json_encode($data);
				}
            	
            }
		}
	}

	protected function _dir_profile(){
		return $this->Setting_model->dir_foto()->row()->defaultnya;
	}

	public function get_data_libur()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$list = $this->Setting_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['id'] = $field->id_tgl;
				$row['no'] = $no;
				$row['tgl'] = tanggal_indo($field->tgl);
				$row['keterangan'] = $field->keterangan;
			
				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Setting_model->count_all(),
				"recordsFiltered"=>$this->Setting_model->count_filtered(),
				"data"=>$data,
			);
			echo json_encode($output);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function get_data_setting()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$list = $this->Master_setting_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['id'] = $field->id;
				$row['no'] = $no;
				$row['nama_setting'] = $field->namasetting;
				$row['defaultnya'] = $field->defaultnya;
			
				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Master_setting_model->count_all(),
				"recordsFiltered"=>$this->Master_setting_model->count_filtered(),
				"data"=>$data,
			);
			echo json_encode($output);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function send_broadcast()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

				$nama = $this->input->post('nama');
				$msg = $this->input->post('msg');
				$sends = $this->input->post('sendto');
				$sendto = (in_array('all', $sends) == true ? 'all' : '');
				$time = date('Y-m-d H:i:s');
				$gambar = $this->input->post('gambar');
				

				if($this->Setting_model->send_broadcast($nama, $msg, $sendto, $time)){
					$data['nama'] = $nama;
					$data['msg'] = $msg;
					$data['sendto'] = $sendto;
					$data['gambar'] = $gambar;
					$data['time'] = $time;
					$data['status'] = 'success';
					return $this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($data));		
				}else{
					$data['status'] = 'error';
					return $this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($data));
				}
			

		}
	}

	
}