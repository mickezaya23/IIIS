
<!-- students' index page -->

		<div id="student-content" class="span4 main-content">	<!-- start of main-content area -->
			
			<div id="student-dashboard" >
				<button type="button" id="addStudBtn" class="addStudBtn" data-toggle="modal" data-target="#student-modal">Add Student </button>
				<button type="button" id="studProfBtn" class="studProfBtn" >Student Profile</button>
			</div>
			<div id="student-stats">
			
			</div>
			<div id="student-list">
				<div id="studlist-header">
					<form action="post" name="sample"> 
					<input type="text" name="studSearch" id="studSearch" class="rt-search"> 	
					<select id="studSearchFilter" class="rt-sfilter">
						<option value="name">Name</option>
						<option value="id">ID Number</option>
					</select>
					</form>
				</div>
				<table id="studListTable" class="defaultTable">
					<!-- Student data   -->
				</table>
			</div>

		<!-- start of student modal -->
		<div id="student-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="studLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close close-stud-modal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="studLabel">Add Student</h4>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<label for="idnum" class="control-label">ID No.</label>
								<input type="text" id="idnum" name="idnum" class="form-control stud-info required" required>
							</div>
							<div class="form-group">
								<label for="lname" class="control-label">Last Name</label>
								<input type="text" id="lname"name="lname" class="form-control stud-info required">
							</div>
							<div class="form-group">
								<label for="fname" class="control-label">First Name</label>
								<input type="text" id="fname"name="fname" class="form-control stud-info required" >
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
								<select class="form-control stud-info" id="gender" name="gender">
									<option>M</option>
									<option>F</option>
								</select>
							</div>
							<div class="form-group">
								<button type="button" class="btn btn-primary" id="saveStudBtn"  >Save</button>
							</div>
						</form>
				</div>
			</div>
		</div>
	</div>
		<!-- end of add student modal -->

		<!-- start of alert modal -->
			<div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="alertModal">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close close-stud-modal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="alert-title">Successful.</h4>
						</div>
						<div id="alert-msg" class="modal-body">Sample Content. </div>
					</div>
				</div>
			</div>
		<!-- end of alert modal -->

	</div> 
	<!-- end of main-content area -->

<script>
	$(document).ready(function(){
		
		/* global array that holds student information */
		var students = [];
		var tempStudId = -1;

		/* load students info from DB and present them in tabular form */
		ui_loadStudsTbl();
		/* dynamically attach event handlers to some elements */
		attachHandlers();
	
	/* start of function definitions */

	function attachHandlers(){
		$("#addStudBtn").on({
			click: ui_addStudent
		});
		$(".close-stud-modal").on({
			click: ui_clearModal
		})
		$(".rt-search").on({
			keyup: ui_searchStud,	
		})
	}

	function attachTblHandlers(){
		$(".editStudLink").on({
			click: ui_editStudent
		})
	}

	function loadStuds(){
		$.ajax({
			url: "students/loadStuds",
			method: "GET",
			cache: false,
			async: false
		}).done(function(result){
			students = JSON.parse(result);
			students = students['results'];
		})
	}

	function saveStudData(){
		//var result = validateForm();
		//console.log(result);
		if(validateForm()){
			var studInfo = document.getElementsByClassName("stud-info");   
			var studInfoArr = [];
			for(var x=0;x<studInfo.length;x++){
				studInfoArr.push(studInfo[x].value);
			}
			
			$.ajax({
				url: "students/addStudent",	
				method: "POST",
				data: { studentInfo: studInfoArr },
				success: function(result){
					ui_loadStudsTbl();
					ui_alert(1,"Success");
				},
				error: function(result){
					ui_alert(0,"Internal Server Error");
				}
			});
		}	
	}

	function validateForm(){
		var reqStudInfo = document.getElementsByClassName("stud-info required")
		var valid = true;
		for(var x=0;x<reqStudInfo.length;x++){
			console.log($(reqStudInfo[x]).val());
			if($(reqStudInfo[x]).val() == ""){
				$(reqStudInfo[x]).attr("placeholder","Required");
				valid = false;
			}
		}
		return valid;
	}

	function ui_alert(type,msg){
		$("#alert-msg").html(msg);
		if(type == 0){
			$("#alert-title").text("Failed.");
		}else{
			$("#alert-title").text("Successful.");
		}
		$("#alert-modal").show();
	}

	function editStudData(){
		var studInfo = document.getElementsByClassName("stud-info");   
		var studInfoArr = [];
		for(var x=0;x<studInfo.length;x++){
			studInfoArr.push(studInfo[x].value);
		}

		$.ajax({
			url: "students/editStudent",	
			method: "POST",
			data: { 
				studentInfo: studInfoArr,
				studOrigId: tempStudId 
			}

		}).done(function(result){
			alert(result);
		});
	}

	function searchStudId(studId){
		var studData = -1;
		for(var x=0;x<students.length;x++){
			if(students[x].id == studId){
				studData = students[x];
				break;
			}
		}
		return studData;
	}

	function searchStudName(studName){
		var studData = -1;
		for(var x=0;x<students.length;x++){
			if(students[x].last_name == studId){
				studData = students[x];
				break;
			}
		}
		return studData;
	}

	function ui_addStudent(){
		$("#studLabel").text("Add Student");
		$("#saveStudBtn").unbind('click');
		$("#saveStudBtn").on({
			click: saveStudData
		})
	}

	function ui_editStudent(){
		var studId = $(this).attr("id");
		tempStudId = studId;
		console.log(tempStudId);
		var studData = searchStudId(studId);
		var studDataArr = [];

		/* extract studData object to array for convenient use 
		in automatically populating stud-info input boxes */
		for(var x in studData){
			studDataArr.push(studData[x]);
		}

		/* populate stud-info input boxes w/ student data  */
		var studInfoInput = document.getElementsByClassName("stud-info");
		for(var x=0;x<studInfoInput.length;x++){
			studInfoInput[x].value = studDataArr[x];
			console.log(studDataArr[x]);
		}

		$("#studLabel").text("Edit Student Info");
		$("#saveStudBtn").unbind('click');
		$("#saveStudBtn").on({
			click: editStudData
		})
	}

	function ui_searchStud(){
		var toSearch = $(".rt-search").val();
		var searchT = $(".rt-sfilter").val();

		if(toSearch == ""){
			ui_loadStudsTbl();
		}else{
			var tRow = ui_loadStudTbl(searchStudId(toSearch));
			ui_resetStudsTbl();
			$("#studListTable").append(tRow);
			attachTblHandlers();
		}
	}

	function ui_loadStudTbl(student){
		var tRow = "<tr>";
		tRow += "<td>" + student.id + "</td>";
		tRow += "<td>" + student.last_name + "</tds>";
		tRow += "<td>" + student.first_name + "</td>";
		tRow += "<td>" + student.middle_name + "</td>";
		tRow += "<td>" + student.gender + "</td>";
		tRow += ui_attachActions(student.id);
		tRow += "</tr>";
		return tRow;
	}

	function ui_loadStudsTbl(){
		loadStuds();
		ui_resetStudsTbl();
		var tbl = $("#studListTable");
		for(var x=0; x<students.length; x++){
			var tRow = ui_loadStudTbl(students[x]);
			tbl.append(tRow);
		}
		attachTblHandlers();
	} 

	function ui_resetStudsTbl(){
		$("#studListTable").html(" ");
		attachTblHeader();
	}

	function attachTblHeader(){
		var tbl = $("#studListTable");
		var tblHeaders = ["ID No.","Last Name","First Name","Middle Name","Gender","Action"];
		var tRow = $("<tr></tr>");
		for(var x=0;x<tblHeaders.length;x++){
			var header = $("<th></th>").text(tblHeaders[x]);
			tRow.append(header);
		}
		tbl.append(tRow);
	}
	
	function ui_attachActions(studId){
		var tData = "<td>";
		tData +=
			"<div class='inline-div actions-menu'><a href='' class='editStudLink' data-toggle='modal' data-target='#student-modal' id='"+studId+"'>Edit</a></div>" +
			"<div class='inline-div actions-menu'><a href=''id='deleteStudLink'>Delete</a></div>";
		tData += "</td>";

		return tData;
	}

	function ui_clearModal(){
		var studInfoInput = document.getElementsByClassName("stud-info");
		for(var x=0;x<studInfoInput.length;x++){
			studInfoInput[x].value = '';
		}
	}

	

});
 </script>