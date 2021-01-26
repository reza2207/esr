<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_in extends CI_Controller {

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
		
        $this->load->model('Barang_in_model');
        $this->load->model('Barang_model');
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
			$data->title = 'Barang Masuk';
			$data->page = 'barang';
			$data->role = $_SESSION['role'];
            
            $data->item = $this->Barang_model->get_data()->result();
            $data->div = $this->Barang_in_model->get_divisi()->result();
			$this->load->view('header', $data);
			$this->load->view('barang_in', $data);
		}else{
			
			$this->load->view('header_login');
			$this->load->view('login');
		}
	}

	public function get_data()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$list = $this->Barang_in_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				$no++;
				$row = array();
                $row['no'] = $no;
                $row['id'] = $field->id;
                $row['item'] = $field->item;
                $row['warna'] = $field->warna;
				$row['id_barang'] = $field->id_barang;
                $row['jumlah'] = $field->jumlah;
                $row['merk'] = $field->merk;
                $row['type'] = $field->type;
                $row['tgl_masuk'] = tgl_indo($field->tgl_masuk);
                $row['created_by'] = $field->created_by;
				$row['created_at'] = $field->created_at;
				$row['deleted_at'] = $field->deleted_at;
				$row['divisi'] = $field->divisi;
				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Barang_in_model->count_all(),
				"recordsFiltered"=>$this->Barang_in_model->count_filtered(),
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
				
				$this->load->library('form_validation');
				
				//validasi
				$this->form_validation->set_rules('id_barang', 'Barang', 'required');
		        $this->form_validation->set_rules('jml', 'Jumlah', 'required');
				$this->form_validation->set_rules('divisi', 'Divisi', 'required');
				
		        if ($this->form_validation->run() == FALSE){

		        	$errors = validation_errors();
		            $respons_ajax['type'] = 'error';
		            $respons_ajax['message'] = $errors;
		            return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($respons_ajax));

		        }else{
					
					$idbrg = $this->input->post('id_barang');
                    $jml = $this->input->post('jml');
                    $divisi = $this->input->post('divisi');

                    $created = $_SESSION['nama'];

					if($this->Barang_in_model->store($idbrg,$jml,$divisi, $created))
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
				if($this->Barang_in_model->get_detail($id)){
					$data = new stdClass();
					$data = $this->Barang_in_model->get_detail($id)->row();
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
				$this->form_validation->set_rules('id_barang', 'Barang', 'required');
		        $this->form_validation->set_rules('jml', 'Jumlah', 'required');
				$this->form_validation->set_rules('divisi', 'Divisi', 'required');
				
		        if ($this->form_validation->run() == FALSE){

		        	$errors = validation_errors();
		            $respons_ajax['type'] = 'error';
		            $respons_ajax['message'] = $errors;
		            return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($respons_ajax));

		        }else{
					
					$idbrg = $this->input->post('id_barang');
                    $jml = $this->input->post('jml');
                    $divisi = $this->input->post('divisi');

                    $created = $_SESSION['nama'];

					if($this->Barang_in_model->store($idbrg,$jml,$divisi, $created))
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


	public function cek($waybill)
	{

		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "waybill=$waybill&courier=jne",
		CURLOPT_HTTPHEADER => array(
			"content-type: application/x-www-form-urlencoded",
			"key: b074d9501b0801f8e9d56a20cc67e536"
		),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		echo "cURL Error #:" . $err;
		} else {
		echo $response;
		}
	}


}
