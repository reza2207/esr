<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rek_persekot extends CI_Controller {

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
			$data->title = 'Rekening Persekot';
			$data->page = 'persekot';
			$data->role = $_SESSION['role'];
			$data->rek = $this->Rek_persekot_model->get_data()->result();
			$this->load->view('header', $data);
			$this->load->view('rek_persekot', $data);
		}else{
			$this->load->helper('form');
			$this->load->view('header_login');
			$this->load->view('login');
		}
	}

	public function get_data()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$list = $this->Rek_persekot_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				$no++;
				$row = array();
                $row['no'] = $no;
                $row['id'] = $field->id;
               
				$row['nama_rek'] = $field->nama_rekening;
				$row['no_rek'] = $field->no_rek;
				$row['date_created'] = $field->date_created;
				$row['date_deleted'] = $field->deleted_at;
				$row['created_by'] = $field->created_by;
				
				
				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Rek_persekot_model->count_all(),
				"recordsFiltered"=>$this->Rek_persekot_model->count_filtered(),
				"data"=>$data,
			);
			echo json_encode($output);
		}else{
			$this->load->helper('form');
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
				$this->form_validation->set_rules('nama_rek', 'Nama Rekening', 'required');
		        $this->form_validation->set_rules('no_rek', 'Nomor Rekening', 'required');
		        
				
		        if ($this->form_validation->run() == FALSE){

		        	$errors = validation_errors();
		            $respons_ajax['type'] = 'error';
		            $respons_ajax['message'] = $errors;
		            echo json_encode($respons_ajax);

		        }else{

                    $norek = $this->input->post('no_rek');
					$namarek = $this->input->post('nama_rek');
                    $pic = $_SESSION['nama'];

					
					if($this->Rek_persekot_model->store($norek, $namarek, $pic))
					{
						
						$data = new stdClass();
						$data->type = 'success';
						$data->message = 'Success!';
						echo json_encode($data);
					}else{

						$data = new stdClass();
						$data->type = 'error';
						$data->message = 'Failed!';
						echo json_encode($data);
					}
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
				if($this->Rek_persekot_model->get_detail($id)){
					$data = new stdClass();
					$data = $this->Rek_persekot_model->get_detail($id)->row();
					return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($data));
				
						
				}
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
				$this->form_validation->set_rules('nama_rek', 'Nama Rekening', 'required');
		        $this->form_validation->set_rules('no_rek', 'Nomor Rekening', 'required|is_unique[rekening_persekot.no_rek]');
		        
		        if ($this->form_validation->run() == FALSE){

		        	$errors = validation_errors();
		            $respons_ajax['type'] = 'error';
		            $respons_ajax['message'] = $errors;
		            return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($respons_ajax));

		        }else{

					$id = $this->input->post('id');
					$norek = $this->input->post('no_rek');
					$namarek = $this->input->post('nama_rek');
					$data = new stdClass();
					if($this->Rek_persekot_model->update($id, $norek, $namarek))
					{
						$data->type = 'success';
						$data->message = 'Success';
						
					}else{

						$data->type = 'error';
						$data->message = 'Failed';
						
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

	public function delete()
	{

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			if($this->input->post(null)){
				$id = $this->input->post('id');
				$data = new stdClass();
				if($this->Rek_persekot_model->delete($id))
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
}
