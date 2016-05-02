<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
	
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('dashboard/index');
		$this->load->view('footer'); 
	}

	
	public function menu_selector(){
		
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
?>