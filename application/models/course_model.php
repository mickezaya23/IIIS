<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Course_model extends CI_Model{

	public function __construct(){
		parent:: __construct();
		$this->load->helper('url');
		$this->load->database();
	}


	public function loadCourses(){
		$query = $this->db->query("SELECT * FROM course");
		return $query->result();
	}

	public function addCourse($courseInfo){
		$sql = "INSERT INTO course VALUES(";
		$arrLen = count($courseInfo);
		$str = "";
		for($x=0;$x<$arrLen;$x++){
			if($x == $arrLen-1){
				$str .= "'" .$courseInfo[$x]. "'";
			}else{
				if($x == $arrLen-2){
					$str .= '"' .$courseInfo[$x] . '",';
				}else{
					$str .= '"' .$courseInfo[$x] . '",';
				}
				
			}
		}
		$sql .= $str . ")";
		$query = $this->db->query($sql);	
		if($query->num_rows() > 0){
			return $query;
		}else{
			return 0;
		}
	}
	
	public function editCourse($courseInfo,$courseOrigId){
		$sql = "UPDATE course 
				SET id='$courseInfo[0]',name='$courseInfo[1]',
				alias='$courseInfo[2]' 
				WHERE id='$courseOrigId'";
		$query = $this->db->query($sql);		
		return $query;
	}

	public function deleteCourse($courseId){
		$sql = "DELETE FROM course
			WHERE id='".$courseId."'";
		$query = $this->db->query($sql);
		return $query;
	}

}