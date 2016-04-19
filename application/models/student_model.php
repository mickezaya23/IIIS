<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Student_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
	}

	public function loadStuds(){
		$query = $this->db->query("SELECT * FROM student");
		return $query->result();
	}

	public function addStud(){

	}
	
}

?>