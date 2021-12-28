<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penomoran_bsk extends CI_Controller {

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
		
		$this->load->model('Penomoran_bsk_model');
		$this->load->helper('terbilang_helper');
		$this->load->helper('tanggal_helper');
		$this->load->helper('form');
		$this->load->helper('download');
		date_default_timezone_set("Asia/Bangkok");

	}	
	public function index()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Penomoran BSK';
			$data->page = 'Penomoran';
			$data->role = $_SESSION['role'];
			$data->url = $this->Penomoran_bsk_model->get_url()->result();
			$this->load->view('header', $data);
			$this->load->view('penomoran_bsk', $data);
		}else{
			
			$this->load->view('header_login');
			$this->load->view('login');
		}
	}

	public function get_data()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$list = $this->Berkas_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				$no++;
				$row = array();
                $row['no'] = $no;
                $row['id'] = $field->id;
				$row['nama_file'] = $field->nama_file;
				$row['tgl_surat'] = tgl_indo($field->tgl_surat);
				$row['no_surat'] = $field->no_surat;
				$row['perihal'] = $field->perihal;
				$row['url'] = $field->url;
				$row['dari'] = $field->dari;
				$row['kepada'] = $field->kepada;
                $row['date_created'] = $field->date_created;
                $row['created_by'] = $field->created_by;
				$row['deleted_at'] = $field->deleted_at;
				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Berkas_model->count_all(),
				"recordsFiltered"=>$this->Berkas_model->count_filtered(),
				"data"=>$data,
			);
			return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($output));
		}else{
			
			show_404();
		}
	}

	public function add_data()
	{	
        
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			if($this->input->post(null)){   
				//$data = $this->input->post();
								
				$tgl = tanggal1($this->input->post('tgl'));
				$rubrik = $this->input->post('rubrik');
				$nm = $this->input->post('nm');
				$tujuan = $this->input->post('tujuan');
				$perihal = $this->input->post('perihal');
				
				$created = $_SESSION['nama'];
				$date = explode("-",$tgl);
				$y = $date[2];
				$no = $this->no($y);
				
				if($this->Penomoran_bsk_model->store($tgl, $no, $rubrik, $nm, $tujuan, $perihal))
				{
					$data = new stdClass();
					$data->type = 'success';
					$data->message = 'Success!';
					
				}else{

					$data = new stdClass();
					$data->type = 'error';
					$data->message = 'Failed!';
					
				}
				

				return $this->output
					->set_content_type('application/json')
					->set_output(json_encode($data));
			
			
				
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	private function no($y){
		$no = $this->Penomoran_bsk_model->get_last_num($y)->row('no');
		return $no;
	}

	public function get_detail()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			if($this->input->post(null)){
				$id = $this->input->post('id');
				if($this->Persekot_model->get_detail($id)){
					$data = new stdClass();
					$data = $this->Persekot_model->get_detail($id)->row();
					return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($data));
						
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
				if($this->Berkas_model->delete($id))
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

	public function download($id)
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$row = $this->Berkas_model->get_data_id($id)->row();
			$file = $row->url.'/'.$row->nama_file;
			
			if(file_exists($file)){
				$this->Berkas_model->add_count_download($id, $_SESSION['nama']);
				$data2=file_get_contents($file);
				$name= uniqid(true).safename($row->nama_file);//ok
				force_download($name,$data2);//ok
				//print_r($file);
				
			}else{
				echo "Sorry file doesn't exist... :(";
			}

		}else{


			show_404();
		}
	}

	public function look($id)
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$row = $this->Berkas_model->get_data_id($id)->row();
			$file = $row->url.'/'.$row->nama_file;
			$data2=file_get_contents($file);
			if(file_exists($file)){
				$pdf = file_get_contents($file);
				header('Content-Type: application/pdf');
				header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
				header('Pragma: public');
				header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
				header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
				header('Content-Length: '.strlen($pdf));
				header('Content-Disposition: inline; filename="'.basename($file).'";');
				ob_clean(); 
				flush(); 
				echo $pdf;
				$this->Berkas_model->add_count_look($id, $_SESSION['nama']);
			}else{
				echo "Sorry file doesn't exist... :(";
			}

		}
	}

}