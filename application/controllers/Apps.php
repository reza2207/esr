<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apps extends CI_Controller {

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
		
		$this->load->model('Pengadaan_model');
		$this->load->helper('terbilang_helper');
		$this->load->helper('tanggal_helper');
		$this->load->helper('form');
		$this->load->model('Pks_model');
		$this->load->model('Tdr_model');
		$this->load->model('Setting_model');
		$this->load->model('User_model');
		$this->load->model('Invoice_model');
		date_default_timezone_set("Asia/Jakarta");

	}	
	public function index()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Apps';
			$data->page = 'Apps';
			$data->role = $_SESSION['role'];
			$data->select_tdr = $this->Tdr_model->select_tdr();
			$data->tahun = $this->Pengadaan_model->get_tahun();
			$data->select_user = $this->User_model->select_user()->result();
			$data->divisi = $this->Setting_model->get_divisi()->result();
			$this->load->view('header', $data);
			$this->load->view('apps', $data);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function calendar()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			$data = new stdClass();
			$data->title = 'Apps';
			$data->page = 'Apps';

			$this->load->view('header', $data);
			$this->load->view('calendar', $data);
		}
	}
}