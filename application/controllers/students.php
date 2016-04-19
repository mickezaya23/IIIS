<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Students extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('student_model');
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('students/index');
		$this->load->view('footer'); 
	}

	public function loadStuds(){
		
		$data['results'] = $this->student_model->loadStuds();

		echo json_encode($data);
	}

	public function addStudent(){
		$studInfo = $this->input->post('studentInfo');
		$sql = "INSERT INTO student VALUES(";
		$arrLen = count($studInfo);
		$str = "";
		for($x=0;$x<$arrLen;$x++){
			if($x == $arrLen-1){
				$str .= "'" .$studInfo[$x]. "'";
			}else{
				if($x == $arrLen-2){
					$str .= $studInfo[$x] . ",";
				}else{
					$str .= '"' .$studInfo[$x] . '",';
				}
				
			}
		}
		$sql .= $str . ")";
		$this->db->query($sql);		
		//echo $this->db->affected_rows();
		echo $sql;
	}
}

/* End of file students.php */
/* Location: ./application/controllers/students.php */

?>