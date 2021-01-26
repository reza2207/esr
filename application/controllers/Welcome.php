<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Welcome extends CI_Controller {

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
		
		
		$this->load->helper(array('form', 'url', 'terbilang_helper','tanggal_helper'));

		require APPPATH.'libraries/phpmailer/src/Exception.php';
        require APPPATH.'libraries/phpmailer/src/PHPMailer.php';
        require APPPATH.'libraries/phpmailer/src/SMTP.php';
        $this->load->model('Persekot_model');

	}	
	public function index()
	{
		$this->load->helper('form');
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Welcome '.$_SESSION['nama'].'!';
			$data->page = 'ESR';
			$data->reminder = $this->Persekot_model->get_reminder()->num_rows();
			$data->exp = $this->Persekot_model->get_exp()->num_rows();
			$year = date('Y');
			$data->role = $_SESSION['role'];
			$data->year = $year;
			
			
			$this->load->view('header', $data);
			$this->load->view('index');
		
		}else{
            
            $this->load->view('header_login');
			$this->load->view('login');
		
		}

	}

	public function get_announcement()
	{
		$data = new stdClass();
		$data->sort_by = $sort_by;
		$data->role = $_SESSION['role'];
		 //konfigurasi pagination
        $config['base_url'] = base_url('pks/page/'); //site url
        $config['total_rows'] = $this->db->count_all('pks'); //total row
        $config['per_page'] = 5;  //show record per halaman
        $config["uri_segment"] = 3;  // uri parameter
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
 		$config['use_page_numbers'] = TRUE;
 		$config['attributes']['rel'] = FALSE;
 		$config['reuse_query_string'] = TRUE;
 		//$config['suffix'] = '/sort_by/'.$sort_by;
 		$config['first_url'] = base_url('pks');
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
        $data->page = ($this->uri->segment(3)) ? ($this->uri->segment(3)-1)*$config['per_page'] : 0;
 
        //panggil function list_perusahaan di model. 
        $data->data = $this->Pengumuman_model->list_pks($config["per_page"], $data->page, $sort_by);           
 
        $data->pagination = $this->pagination->create_links();
			
	}

	public function send_email()
	{
	    // PHPMailer object
         $response = false;
         $mail = new PHPMailer();
       

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'bnimail.bni.com'; //sesuaikan sesuai nama domain hosting/server yang digunakan
        $mail->SMTPAuth = true;
        $mail->Username = 'muhamad.reza@bni.co.id'; // user email
        $mail->Password = 'reza'; // password email
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;;
        $mail->Port     = 110;

        $mail->setFrom('muhamad.reza@bni.co.id', ''); // user email
        $mail->addReplyTo('muhamad.reza@bni.co.id', ''); //user email

        // Add a recipient
        $mail->addAddress('haridiana.iswandani@bni.co.id'); //email tujuan pengiriman email

        // Email subject
        $mail->Subject = 'SMTP Codeigniter'; //subject email

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "&lt;h1>SMTP Codeigniterr&lt;/h1>
            &lt;p>Laporan email SMTP Codeigniter.&lt;/p>"; // isi email
        $mail->Body = $mailContent;

        // Send email
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            echo 'Message has been sent';
        }
        
	}

    public function belajar()
    {
        $this->load->view('belajar');
    }

}
