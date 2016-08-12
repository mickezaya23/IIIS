<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends CI_Controller {

	private $default_results_limit = null;

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('student_model');

		$this->default_results_limit = 15;
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('student/index');
		$this->load->view('footer'); 
	}

	/*public function loadStuds(){
		
		$data['results'] = $this->student_model->loadStuds();

		echo json_encode($data);
	}*/

	public function loadStuds(){
		$startPos = $this->input->post('startPos');
		$order = $this->input->post('orderBy');
		$orderPattern = $this->input->post('orderPattern');
		$limit = $this->default_results_limit;
		$data['results'] = $this->student_model->loadStuds($startPos,$limit,$order,$orderPattern);
		echo json_encode($data);
	}

	public function getStudCount(){
		$data['studCount'] = $this->student_model->getCount();
		echo json_encode($data);
	}

	public function addStudent($_studInfo){
		$studInfo = $this->input->post('studentInfo');
		$result = $this->student_model->addStudent($studInfo);	
		if($result != 1){
			return 0;
		}else{
			return $result;
		}
	}

	public function aj_searchById(){
		$studId = $this->input->post('studId');
		$startPos = $this->input->post('startPos');
		$order = $this->input->post('orderBy');
		$orderPattern = $this->input->post('orderPattern');
		$queryResult = $this->searchById($studId,$startPos,$order,$orderPattern);

		echo json_encode($queryResult);
	}

	public function searchById($studId,$startPos=0,$order="id",$orderPattern="ASC"){
		$limit = $this->default_results_limit;
		$queryResult = $this->student_model->searchById($studId,$startPos,$order,$orderPattern,$limit);
		return $queryResult;
	}

	public function aj_searchIndivId(){
		$studId = $this->input->post('studId');
		$queryResult = $this->searchIndivId($studId);
		$data['results'] = $queryResult;
		echo json_encode($data);
	}

	public function searchIndivId($studId){
		$queryResult = $this->student_model->searchIndivId($studId);
		return $queryResult;
	}

	public function editStudent(){
		$studInfo = $this->input->post('studentInfo');
		$studOrigId = $this->input->post('studOrigId');
		
		$result = $this->student_model->editStudent($studInfo,$studOrigId);
		echo $result;
	}

	public function deleteStudent(){
		$studId = $this->input->post('studId');
		$result = $this->student_model->deleteStudent($studId);
		echo $result;
	}

	public function addByCsv(){
		
		$csvFile = $_FILES['file']['tmp_name'];

		if(!file_exists($csvFile)){
			echo "File not found.";
			exit;
		}
		
		$file = fopen($csvFile,"r");
		if(!$file){
			echo "Error opening data file. \n";
			exit;
		}

		$errFlag = false;
		$rowCount = 0;
		$rowAdded = array();
		$rowSkipped = array();
		$query = "";

		while(($row = fgetcsv($file,"500",","))){
			if($rowCount > 0){
				$id = $row[0];		//student ID
				$searchResult = $this->searchIndivId($id);
		
				if(empty($searchResult)){
					$age = $row[2]; $gender = $row[3];
					$explodeName = explode(",",$row[1]);	// 
					$lastName = $explodeName[0];
					$explodeName2 = preg_split('" "',$explodeName[1]);	//explode first name and middle name
					$len = count($explodeName2);
					$middleName = $explodeName2[$len-1];

					/* extracting first name from exploded first+middle name string */
					$firstName = "";
					for($x=1;$x<=($len-2);$x++){
						$firstName .= $explodeName2[$x];
						if($x != ($len-2))
							$firstName .= " ";
					}

					$studInfo = array(
						'id' => $id,
						'last_name' => $lastName,
						'first_name' => $firstName,
						'middle_name' => $middleName,
						'age' => $age,
						'gender' => $gender
					);
					$this->db->insert('student',$studInfo);
					//$this->student_model->addStudent($studInfo);
					array_push($rowAdded,$studInfo);
				}else{
					array_push($rowSkipped,$searchResult[0]);
					continue;
				}
				
			}
			$rowCount++;
		}

		$data['rowAdded'] = $rowAdded; $data['rowSkipped'] = $rowSkipped;

		echo json_encode($data); 

	}
}

/* End of file students.php */
/* Location: ./application/controllers/students.php */

?>