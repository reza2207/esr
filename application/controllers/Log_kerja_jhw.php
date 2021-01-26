<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_kerja_jhw extends CI_Controller {

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
		
		$this->load->model('Log_kerja_jhw_model');
		$this->load->helper('terbilang_helper');
		$this->load->helper('tanggal_helper');
		$this->load->helper('form');
		$this->load->model('Kelompok_model');
		date_default_timezone_set("Asia/Bangkok");

	}	
	public function index()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Log Kerja JarHW';
			$data->page = 'jarhw';
            $data->role = $_SESSION['role'];
            $data->kelompok = $this->Kelompok_model->get_data()->result();
			$this->load->view('header', $data);
			$this->load->view('log_kerja_jarhw', $data);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function get_data()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$list = $this->Log_kerja_jhw_model->get_datatables();
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
				"recordsTotal" =>$this->Log_kerja_jhw_model->count_all(),
				"recordsFiltered"=>$this->Log_kerja_jhw_model->count_filtered(),
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

					
					if($this->Log_kerja_jhw_model->store($nama, $hari, $tanggal, $kelompok, $keterangan, $pic, $status))
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

	protected function _get_id($year)
	{
		if($this->Pks_model->last_id($year)->num_rows() > 0){
			$lastid = $this->Pks_model->last_id($year)->row('id_pks');
			$uniq = explode('-', $lastid);
			return 'PKS-'.$year.'-'.str_pad((int) $uniq[2]+1,3,"0",STR_PAD_LEFT);
		}else{
			return 'PKS-'.$year.'-001';
		}
	}

	public function get_detail()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			if($this->input->post(null)){
				$id = $this->input->post('id');
				if($this->Pks_model->get_detail($id)){
					$data = new stdClass();
					$data->pks = $this->Pks_model->get_detail($id)->row();
					$data->comment = $this->get_comment($id);
					$data->reminder = $this->Pks_model->data_reminder($id)->result();
					echo json_encode($data);
						
				}
			}
		}else{
			show_404();
		}
			
	}

	private function get_comment($id)
	{
		return $data = $this->Pks_model->get_comment($id)->result();
		
	}

	public function get_comm()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			if($this->input->post(null)){
				$id = $this->input->post('id');
				$data = $this->Pks_model->get_comment($id)->result();
				echo json_encode($data);
			}
		}
	}

	public function add_comment()
	{	
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			if($this->input->post(null)){
				$id_pks = $this->input->post('id');
				$comment = $this->input->post('comment');
				$comment_date = date('Y-m-d H:i:s');
				$comment_by = $_SESSION['username'];
				$comment_name = $_SESSION['nama'];

				//$comment_id = $this->Comment_model->get_id_comment($nopenunjukan);
				
				if($this->Pks_model->get_id_comment($id_pks)->num_rows() > 0){

					$idlast = $this->Pks_model->get_id_comment($id_pks)->row()->id_comment;
					$id = explode("_", $idlast);
					$id = "comm_".$id_pks.'_'.STR_PAD((int) $id[2]+1, 3, "0", STR_PAD_LEFT);
					//echo json_encode($id);

				}else{

					$id = "comm_".$id_pks.'_001';
				}

				
				if($this->Pks_model->input_comment($id, $id_pks, $comment, $comment_by, $comment_date))
				{	
					$data = new stdClass();
					$data->comment = $comment;
					$data->comment_date = $comment_date;
					$data->nama = $comment_name;
					$data->type = 'success';
					$data->message = 'Berhasil';
					$data->comment_id = $id;
					echo json_encode($data);
				}else{

					$data->type = 'error';
					$data->message = 'Gagal';
					echo json_encode($data);
				}
			}else{
				show_404();
			}
		
		}else{
			show_404();
		} //cek session
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

	public function update_pks()
	{

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			if($this->input->post(null)){
			//$id = $this->input->post('id');
				$id = $this->input->post('id_pks');
				$nopenunjukan = $this->input->post("no_srt_penunjukan");
				$tglminta = tanggal1($this->input->post("tgl_minta"));
				$nousulan = $this->input->post("no_usulan");
				$idtdr = $this->input->post("id_tdr");
				$perihal = $this->input->post("perihal");
				$tglawal = tanggal1($this->input->post("tgl_awal"));
				$tglakhir = tanggal1($this->input->post("tgl_akhir"));
				$nominalrp = $this->input->post("nominal_rp");
				$nominalusd = $this->input->post("nominal_usd");
				$bankgaransi = $this->input->post("bank_garansi");
				$tgldraftdarilegal = tanggal1($this->input->post("tgl_draft_dari_legal"));
				$tgldraftkeuser = tanggal1($this->input->post("tgl_draft_ke_user"));
				$tgldraftkevendor = tanggal1($this->input->post("tgl_draft_ke_vendor"));
				$tglreviewkelegal = tanggal1($this->input->post("tgl_review_ke_legal"));
				$tglttdkevendor = tanggal1($this->input->post("tgl_ttd_ke_vendor"));
				$tglttdkepemimpin = tanggal1($this->input->post("tgl_ttd_ke_pemimpin"));
				$tglserahterimapks = tanggal1($this->input->post("tgl_serahterima_pks"));
				$tglpks = tanggal1($this->input->post("tgl_pks"));
				$nopks = $this->input->post("no_pks");
				$file = $this->input->post("file");
				$data = new stdClass();

				//if($this->Pks_model->)
				if($this->Pks_model->update_pks($id, $nopenunjukan, $tglminta, $nousulan, $idtdr, $perihal, $tglawal, $tglakhir, $nominalrp, $nominalusd, $bankgaransi,$tgldraftdarilegal, $tgldraftkeuser,$tgldraftkevendor,$tglreviewkelegal,$tglttdkevendor,$tglttdkepemimpin,$tglserahterimapks, $tglpks, $nopks, $file))
				{	
					$data->type = 'success';
					$data->message = 'Berhasil';
					echo json_encode($data);
					
				}else{
				
					$data->type = 'error';
					$data->message = 'Gagal';
					echo json_encode($data);
				}
			}else{
				show_404();
			}

			
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function proses_pks()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			//echo json_encode($this->input->post());
			
			if($this->input->post(null)){
				$id = $this->input->post('id');
				$tgldraftdarilegal = tanggal1($this->input->post('tgl_draft_dari_legal'));
				$tgldraftkeuser = tanggal1($this->input->post('tgl_draft_ke_user'));
				$tgldraftkevendor = tanggal1($this->input->post('tgl_draft_ke_vendor'));
				$tglreviewkelegal = tanggal1($this->input->post('tgl_review_ke_legal'));
				$tglttdkevendor = tanggal1($this->input->post('tgl_ttd_ke_vendor'));
				$tglttdkepemimpin = tanggal1($this->input->post('tgl_ttd_ke_pemimpin'));
				$tglserahterimapks = tanggal1($this->input->post('tgl_serahterima_pks'));
				$nopks = $this->input->post('no_pks');
				$tglpks = tanggal1($this->input->post('tgl_pks'));

				if($this->Pks_model->proses_pks($id,$tgldraftdarilegal,$tgldraftkeuser,$tgldraftkevendor,$tglreviewkelegal,$tglttdkevendor,$tglttdkepemimpin,$tglserahterimapks,$nopks,$tglpks))
				{
					$data = new stdClass();
					$data->type = 'success';
					$data->message = 'Berhasil';
					echo json_encode($data);
				}else{
					$data = new stdClass();
					$data->type = 'error';
					$data->message = 'Gagal';
					echo json_encode($data);
				}
			}else{
				show_404();
			}

			
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function print_form_pks()
	{
		$this->load->view('print_form_pks');
	}
	public function submit_reminder()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{
			if($this->input->post(null)){
				$data = new stdClass();
				$this->load->library('form_validation');
 				$this->form_validation->set_rules('no', 'No. Surat', 'required');
 				$this->form_validation->set_rules('tgl', 'Tgl. Surat', 'required');
 				$this->form_validation->set_rules('perihal', 'Perihal', 'required');
 				//$this->form_validation->set_rules('file', 'file', 'required');
 				if ($this->form_validation->run() == FALSE){

		        	$errors = validation_errors();
		            $respons_ajax['type'] = 'error';
		            $respons_ajax['message'] = $errors;
		            echo json_encode($respons_ajax);

		        }else{

					$no = $this->input->post('no');
					$idpks = $this->input->post('idpks');
					$tgl = tanggal1($this->input->post('tgl'));
					$perihal = $this->input->post('perihal');
					$file = $this->input->post('file');
					$id = uniqid();

					if($this->Pks_model->add_reminder($id, $idpks, $no, $tgl, $perihal, $file))
					{
						
						$data->type = 'success';
						$data->message = 'Berhasil';
						
					}else{
						
						$data->type = 'error';
						$data->message = 'Gagal';
						
					}
					echo json_encode($data);
				}

			}
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


	private function file_pdf($id)
	{
		return $this->Pks_model->get_file($id);
	}




}
