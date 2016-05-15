<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Course extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('course_model');
	}

	public function index(){
		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('course/index');
		$this->load->view('utilities/alert-modals');
		$this->load->view('footer');
	}


	public function loadCourses(){
		
		$data['results'] = $this->course_model->loadCourses();

		echo json_encode($data);
	}

	public function addCourse(){
		$courseInfo = $this->input->post('courseInfo');
		$result = $this->course_model->addCourse($courseInfo);	
		if($result != 1){
			return 0;
		}else{
			return $result;
		}
	}

	public function editCourse(){
		$courseInfo = $this->input->post('courseInfo');
		$courseOrigId = $this->input->post('courseOrigId');
		$result = $this->course_model->editCourse($courseInfo,$courseOrigId);
		echo $sql;
	}

	public function deleteCourse(){
		$courseId = $this->input->post('courseId');
		$result = $this->course_model->deleteCourse($courseId);
		echo $result;
	}

}