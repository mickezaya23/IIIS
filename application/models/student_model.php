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

	public function addStudent($studInfo){
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
		$query = $this->db->query($sql);	
		if($query->num_rows() > 0){
			return $query;
		}else{
			return 0;
		}
	}

	public function searchById($studId){
		$sql = "SELECT * FROM student
				WHERE id='$studId'";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function editStudent($studInfo,$studOrigId){
		$sql = "UPDATE student 
				SET id='$studInfo[0]',last_name='$studInfo[1]',
				first_name='$studInfo[2]',middle_name='$studInfo[3]',
				age=$studInfo[4],gender='$studInfo[5]'
				WHERE id='$studOrigId'";
		$this->db->query($sql);		
		echo $sql;
	}

	public function addByCsv($csvFile){

	}
	
	public function deleteStudent($studId){
		$sql = "DELETE FROM student
			WHERE id='".$studId."'";
		$query = $this->db->query($sql);
		return $query;
	}
}

?>