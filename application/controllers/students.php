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
		$result = $this->student_model->addStudent($studInfo);	
		if($result != 1){
			return 0;
		}else{
			return $result;
		}
	}

	public function editStudent(){
		$studInfo = $this->input->post('studentInfo');
		$studOrigId = $this->input->post('studOrigId');
		$sql = "UPDATE student 
				SET id='$studInfo[0]',first_name='$studInfo[1]',
				middle_name='$studInfo[2]',last_name='$studInfo[3]',
				age=$studInfo[4],gender='$studInfo[5]'
				WHERE id=$studOrigId";
		$this->db->query($sql);		
		echo $sql;
	}

	public function deleteStudent(){
		$studId = $this->input->post('studId');
		$result = $this->student_model->deleteStudent($studId);
		echo $result;
	}
}

/* End of file students.php */
/* Location: ./application/controllers/students.php */

?>