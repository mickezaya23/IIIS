
<!-- students' index page -->

		<div id="student-content" class="span4 main-content">	<!-- start of main-content area -->
			
			<div id="student-dashboard" >
				<button type="button" id="addStudBtn" class="addStudBtn" data-toggle="modal" data-target="#add-student-modal">Add Student </button>
				<button type="button" id="studProfBtn" class="studProfBtn">Student Profile</button>
			</div>
			<div id="student-stats">
			
			</div>
			<div id="student-list">
				<div id="studlist-header"> 
					<input type="text" name="studSearch"> 	
					<select id="studSearchFilter">
						<option value="name">Name</option>
						<option value="id">ID Number</option>
					</select>
				</div>
				<table id="studListTable" class="defaultTable">
					<tr>
						<th>ID No.</th>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Middle Name</th>
						<th>Gender</th>
					</tr>
				</table>
			</div>
		</div> 
		<!-- end of main-content area -->

		<!-- start of add student modal -->
		<div id="add-student-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addStudLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="addStudLabel">Add Student</h4>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<label for="idnum" class="control-label">ID No.</label>
								<input type="text" id="idnum"name="idnum" class="form-control stud-info">
							</div>
							<div class="form-group">
								<label for="lname" class="control-label">Last Name</label>
								<input type="text" id="lname"name="lname" class="form-control stud-info">
							</div>
							<div class="form-group">
								<label for="fname" class="control-label">First Name</label>
								<input type="text" id="fname"name="fname" class="form-control stud-info">
							</div>
							<div class="form-group">
								<label for="mname" class="control-label">Middle Name</label>
								<input type="text" id="mname"name="mname" class="form-control stud-info">
							</div>
							<div class="form-group">
								<label for="age" class="control-label">Age</label>
								<input type="text" id="gender"name="age" class="form-control stud-info">
							</div>
							<div class="form-group">
								<label for="gender" class="control-label">Gender</label>
								<input type="text" id="gender"name="gender" class="form-control stud-info">
							</div>
							<div class="form-group">
								<button type="button" class="btn btn-primary" id="saveStudBtn">Save</button>
							</div>
						</form>
				</div>
			</div>
		</div>
		<!-- end of add student modal -->

<script>
	$(document).ready(function(){
		loadStuds();
		attachHandlers();
	});

	function attachHandlers(){
		$("#addStudBtn").on({
			click: addStudent
		});
		$("#saveStudBtn").on({
			click: saveStudData
		});
	}

	function loadStuds(){
		$.ajax({
			url: "students/loadStuds",
			method: "GET",
			cache: false	
		}).done(function(result){
			var stud = JSON.parse(result);
			stud = stud['results'];
			for(var x=0; x<stud.length; x++){
				var tbl = $("#studListTable");
				var tRow = "<tr>";
				tRow += "<td>" + stud[x].id + "</td>";
				tRow += "<td>" + stud[x].last_name + "</td>";
				tRow += "<td>" + stud[x].first_name + "</td>";
				tRow += "<td>" + stud[x].middle_name + "</td>";
				tRow += "<td>" + stud[x].gender + "</td>";
				tRow += "</tr>";
				tbl.append(tRow);
			}
		});
	} 

	function addStudent(){
		$("#add-student-modal").show();
	}

	function saveStudData(){
		var studInfo = document.getElementsByClassName("stud-info");
		var studInfoArr = [];
		for(var x=0;x<studInfo.length;x++){
			studInfoArr.push(studInfo[x].value);
		}

		$.ajax({
			url: "students/addStudent",	
			method: "POST",
			data: { studentInfo: studInfoArr }

		}).done(function(result){
			alert(result);
		});
	}
 </script>