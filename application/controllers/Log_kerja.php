<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_kerja extends CI_Controller {

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
		
		$this->load->model('Log_kerja_model');
		$this->load->helper('terbilang_helper');
		$this->load->helper('tanggal_helper');
		$this->load->helper('form');
		$this->load->model('Kelompok_model');
		$this->load->model('User_model');
		date_default_timezone_set("Asia/Bangkok");

	}	
	public function index()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Log Kerja';
			$data->page = 'umum';
            $data->role = $_SESSION['role'];
			$data->user = $_SESSION['username'];
            $data->kelompok = $this->Kelompok_model->get_data()->result();
			$this->load->view('header', $data);
			$this->load->view('log_kerja', $data);
		}else{
			$this->load->helper('form');
			$this->load->view('login	');
		}
	}

	public function get_data()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$list = $this->Log_kerja_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				$no++;
				$row = array();
                $row['no'] = $no;
                $d = strtotime($field->tanggal);
				$row['tanggal'] = hari($field->tanggal).', '.tgl_indo($field->tanggal);
				$row['nama'] = $field->nama;
				$row['kelompok'] = $field->kelompok;
				$row['keterangan'] = $field->keterangan;
				$row['pic'] = $field->pic;
				$row['status'] = $field->status;
				$row['tgl_done'] = tgl_indo($field->tgl_done);
				$row['jam'] = $field->jam_input;
				$row['created'] = tgl_indo($field->date_created);
				$row['id'] = $field->id_log;
				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Log_kerja_model->count_all(),
				"recordsFiltered"=>$this->Log_kerja_model->count_filtered(),
				"data"=>$data,
			);
			echo json_encode($output);
		}else{
			$this->load->helper('form');
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
				$this->form_validation->set_rules('tanggal', 'Tanggal', 'required',
		        array(
		                'required'      => 'You have not provided %s.',
		                //'is_unique'     => 'This %s already exists.'
		        ));
		        $this->form_validation->set_rules('nama', 'Nama', 'required');
		        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
		        
		        if ($this->form_validation->run() == FALSE){

		        	$errors = validation_errors();
		            $respons_ajax['type'] = 'error';
		            $respons_ajax['message'] = $errors;
		            echo json_encode($respons_ajax);

		        }else{

                    $nama = $this->input->post('nama');
                    $tanggal = tanggal1($this->input->post('tanggal'));
                    $kelompok = $this->input->post('kelompok');
                    $keterangan = $this->input->post('keterangan');
                    $hari = hari($tanggal);
                    $pic = $_SESSION['nama'];
                    $status = 'On Process';

					
					if($this->Log_kerja_model->store($nama, $hari, $tanggal, $kelompok, $keterangan, $pic, $status))
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

	public function delete()
	{

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			if($this->input->post(null)){
				$id = $this->input->post('id');
				$data = new stdClass();
				if($this->Log_kerja_jhw_model->delete($id))
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


	public function get_pdf($id)
	{
		
		$file = 'file_pks/'.$this->file_pdf($id)->row()->file;//		
		
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
	   	}else{
	   		echo "Sorry file doesn't exist... :(";
	   	}
	}


	private function file_pdf($id = NULL)
	{
		return $this->Pks_model->get_file($id);
	}

	public function my_log($id = NULL)
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			if($this->User_model->get_user($id)->num_rows() == 0){
				
				echo 'Sorry User Not Found';
			}else{
				
				//paginasi

				$this->load->library('pagination');
			
				$data = new stdClass();
				$data->title = 'Log Kerja: '.$this->User_model->get_user($id)->row('nama');
				//$data->sort_by = $sort_by;
				$data->role = $_SESSION['role'];
				$data->nama = $this->User_model->get_user($id)->row('nama');
				 //konfigurasi pagination
				$config['base_url'] = base_url("log_kerja/my_log/$id/p/"); //site url
				$config['total_rows'] = $this->Log_kerja_model->count_by_id($id); //total row
				$config['per_page'] = 50;  //show record per halaman
				$config["uri_segment"] = 5;  // uri parameter
				$choice = $config["total_rows"] / $config["per_page"];
				$config["num_links"] = floor($choice);
				 $config['use_page_numbers'] = TRUE;
				 $config['attributes']['rel'] = FALSE;
				 $config['reuse_query_string'] = TRUE;
				 //$config['suffix'] = '/sort_by/'.$sort_by;
				 $config['first_url'] = base_url("log_kerja/my_log/$id");;
				// Membuat Style pagination untuk Materialize
				  $config['first_link']       = 'First';
				$config['last_link']        = 'Last';
				$config['next_link']        = 'Next';
				$config['prev_link']        = 'Prev';
				$config['full_tag_open']    = '<div class="col push-l3 l9 s12 center"><ul class="pagination">';
				$config['full_tag_close']   = '</li></ul></div>';
				$config['num_tag_open']     = '<li class="waves-effect">';
				$config['num_tag_close']    = '</li>';
				$config['cur_tag_open']     = '<li class="active"><a>';
				$config['cur_tag_close']    = '</a></li>';
				$config['next_tag_open']    = '<li class="waves-effect">';
				$config['next_tagl_close']  = '&raquo;</li>';
				$config['prev_tag_open']    = '<li class="waves-effect">';
				$config['prev_tagl_close']  = 'Next</li>';
				$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
				$config['first_tagl_close'] = '</span></li>';
				$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
				$config['last_tagl_close']  = '</span></li>';
				
				$this->pagination->initialize($config);
				$data->page = ($this->uri->segment(5)) ? 
				($this->uri->segment(5)) : 0;
				$data->no = $data->page == 0 ? $data->page * $config['per_page']+1 : ($data->page-1) * $config['per_page']+1;

				//panggil function list_perusahaan di model. 
				$data->data = $this->Log_kerja_model->list_log($config["per_page"], $data->page, $id);           
				$data->pending = $this->Log_kerja_model->list_log_pending($id);           
				$data->pagination = $this->pagination->create_links();
				
				$this->load->view('my_log', $data);
			}

			
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}


}
