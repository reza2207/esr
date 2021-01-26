<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persekot extends CI_Controller {

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
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){

		parent::__construct();
		
		$this->load->model('Persekot_model');
		$this->load->helper('terbilang_helper');
		$this->load->helper('tanggal_helper');
		$this->load->helper('form');
		$this->load->model('Rek_persekot_model');
		date_default_timezone_set("Asia/Bangkok");

	}	
	public function index()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Persekot';
			$data->page = 'persekot';
			$data->role = $_SESSION['role'];
			$data->rek = $this->Rek_persekot_model->get_data()->result();
			$data->reminder = $this->Persekot_model->get_reminder()->num_rows();
			$data->exp = $this->Persekot_model->get_exp()->num_rows();
			$this->load->view('header', $data);
			$this->load->view('persekot', $data);
		}else{
			
			$this->load->view('header_login');
			$this->load->view('login');
		}
	}

	public function get_data()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$list = $this->Persekot_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				$no++;
				$row = array();
                $row['no'] = $no;
                $row['id'] = $field->id;
               
				$row['tgl_minta'] = tgl_indo($field->tgl_permintaan);
				$row['no_rek'] = $field->no_rekening_pskt;
				$row['nama_rek'] = $field->nama_rekening_pskt;
				$row['user'] = $field->user;
                $row['perihal'] = $field->perihal;
                $row['nominal'] = titik($field->nominal);
				$row['tgl_proses'] = tgl_indo($field->tgl_proses);
				$row['tgl_penyelesaian'] = tgl_indo($field->tgl_penyelesaian);
				$row['sli'] = $field->sli;
				$row['berjalan'] = $field->berjalan;
				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Persekot_model->count_all(),
				"recordsFiltered"=>$this->Persekot_model->count_filtered(),
				"data"=>$data,
			);
			echo json_encode($output);
		}else{
			
			$this->load->view('header_login');
			$this->load->view('login');
		}
	}

	public function add_data()
	{	
        
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			if($this->input->post(null)){   
				//$data = $this->input->post();
				
				$this->load->library('form_validation');
				
				//validasi
				$this->form_validation->set_rules('tanggal_minta', 'Tanggal Permintaan', 'required');
		        $this->form_validation->set_rules('rek_persekot', 'Rekening Persekot', 'required');
		        $this->form_validation->set_rules('user', 'Kelompok/Divisi/User', 'required');
				$this->form_validation->set_rules('perihal', 'Perihal', 'required');
				$this->form_validation->set_rules('nominal', 'Nominal', 'required');
				$this->form_validation->set_rules('tgl_proses', 'Tgl. Proses', 'required');
				
		        if ($this->form_validation->run() == FALSE){

		        	$errors = validation_errors();
		            $respons_ajax['type'] = 'error';
		            $respons_ajax['message'] = $errors;
		            echo json_encode($respons_ajax);

		        }else{

                    $tgl_minta = tanggal1($this->input->post('tanggal_minta'));
                    $rek = $this->input->post('rek_persekot');
					$user = $this->input->post('user');
					$perihal = $this->input->post('perihal');
					$nominal = $this->input->post('nominal');
					$tgl_proses = tanggal1($this->input->post('tgl_proses'));
					$nama_rek = $this->Rek_persekot_model->cek_rek($rek)->row('nama_rekening');

                   
                    $pic = $_SESSION['nama'];
                    $status = 'On Process';

					
					if($this->Persekot_model->store($tgl_minta, $rek, $nama_rek, $user, $perihal, $nominal, $tgl_proses, $pic))
					{
						
						$data = new stdClass();
						$data->type = 'success';
						$data->message = 'Success!';
						$data->rem1 = $this->Persekot_model->get_reminder()->num_rows();
						$data->rem2 = $this->Persekot_model->get_exp()->num_rows();
						
						
					}else{

						$data = new stdClass();
						$data->type = 'error';
						$data->message = 'Failed!';
						
					}

					echo json_encode($data);
				}
				
				
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	

	public function get_detail()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			if($this->input->post(null)){
				$id = $this->input->post('id');
				if($this->Persekot_model->get_detail($id)){
					$data = new stdClass();
					$data = $this->Persekot_model->get_detail($id)->row();
					echo json_encode($data);
						
				}
			}
		}else{
			show_404();
		}
			
	}
	

	public function delete()
	{

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			if($this->input->post(null)){
				$id = $this->input->post('id');
				$data = new stdClass();
				if($this->Persekot_model->delete($id))
				{	
					$data->type = 'success';
					$data->message = 'Berhasil';
					
				}else{
				
					$data->type = 'error';
					$data->message = 'Gagal';
					
				}
				echo json_encode($data);
			}else{
				show_404();
			}

		}else{
			show_404();
		}
	}

	public function update()
	{

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			if($this->input->post(null)){
				//$id = $this->input->post('id');
				
				$this->load->library('form_validation');
				
				//validasi
				$this->form_validation->set_rules('tanggal_minta', 'Tanggal Permintaan', 'required');
		        $this->form_validation->set_rules('rek_persekot', 'Rekening Persekot', 'required');
		        $this->form_validation->set_rules('user', 'Kelompok/Divisi/User', 'required');
				$this->form_validation->set_rules('perihal', 'Perihal', 'required');
				$this->form_validation->set_rules('nominal', 'Nominal', 'required');
				$this->form_validation->set_rules('tgl_proses', 'Tgl. Proses', 'required');
				
		        if ($this->form_validation->run() == FALSE){

		        	$errors = validation_errors();
		            $respons_ajax['type'] = 'error';
		            $respons_ajax['message'] = $errors;
		            return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($respons_ajax));

		        }else{

				
					$id = $this->input->post('id');
					$tgl_mnt = tanggal1($this->input->post('tanggal_minta'));
					$rek = $this->input->post('rek_persekot');
					$user = $this->input->post('user');
					$perihal = $this->input->post('perihal');
					$nominal = $this->input->post('nominal');
					$tgl_proses = tanggal1($this->input->post('tgl_proses'));
					$tgl_selesai = tanggal1($this->input->post('tgl_selesai'));
					$nama_rek = $this->Rek_persekot_model->cek_rek($rek)->row('nama_rekening');
					$by = $_SESSION['nama'];

					$data = new stdClass();

					//update to model
					if($this->Persekot_model->update($id, $tgl_mnt, $rek,$user, $perihal, $nominal, $tgl_proses, $tgl_selesai, $nama_rek, $by))
					{	
						$data->type = 'success';
						$data->message = 'Berhasil';
						
						
					}else{
					
						$data->type = 'error';
						$data->message = 'Gagal';
						
					}
					
					return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($data));
				
				}
				
			}else{
				show_404();
			}

			
		}else{
			$this->load->helper('form');
			$this->load->view('header_login');
			$this->load->view('login');
		}
	}

	public function proses()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			//echo json_encode($this->input->post());
			
			if($this->input->post(null)){
				$id = $this->input->post('id');
				$tgl = tanggal1($this->input->post('tanggal'));

				if($this->Persekot_model->proses($id, $tgl))
				{
					$data = new stdClass();
					$data->type = 'success';
					$data->message = 'Berhasil';
					
				}else{
					$data = new stdClass();
					$data->type = 'error';
					$data->message = 'Gagal';
					
				}

				echo json_encode($data);
				
			}else{
				show_404();
			}

			
		}else{
			
			show_404();
		}
	}

	


}
