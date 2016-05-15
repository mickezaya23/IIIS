
<!-- courses's index page -->

		<div id="course-content" class="span4 main-content">	<!-- start of main-content area -->
			
			<div id="course-dashboard" >
				<button type="button" id="addCourseBtn" class="addCourseBtn" data-toggle="modal" data-target="#course-modal">Add course </button>
				<button type="button" id="courseProfBtn" class="courseProfBtn" >Course Profile</button>
			</div>
			<div id="course-stats">
			
			</div>
			<div id="course-list">
				<div id="courselist-header">
					<form action="post" name="sample"> 
					<input type="text" name="courseSearch" id="courseSearch" class="rt-search"> 	
					<select id="courseSearchFilter" class="rt-sfilter">
						<option value="name">Name</option>
						<option value="id">ID Number</option>
					</select>
					</form>
				</div>
				<table id="courseListTable" class="defaultTable">
						<!-- course data   -->
				</table>
			</div>

			<!-- start of course modal -->
		<div id="course-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="courseLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close close-course-modal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="courseLabel">Add course</h4>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<label for="idnum" class="control-label">Course ID</label>
								<input type="text" id="idnum" name="idnum" class="form-control course-info required" required>
							</div>
							<div class="form-group">
								<label for="lname" class="control-label">Course Name</label>
								<input type="text" id="name"name="name" class="form-control course-info required">
							</div>
							<div class="form-group">
								<label for="fname" class="control-label">Alias</label>
								<input type="text" id="alias"name="alias" class="form-control course-info required" >
							</div>
			
							<div class="form-group">
								<button type="button" class="btn btn-primary" id="saveCourseBtn"  >Save</button>
							</div>
						</form>
				</div>
			</div>
		</div>
	</div>
		<!-- end of add course modal -->
	</div> 
	<!-- end of main-content area -->



<script>
	$(document).ready(function(){
		
		/* global array that holds course information */
		var courses = [];
		var tempCourseId = -1;
		var controllerName = "course";

		/* load courses info from DB and present them in tabular form */
		ui_loadCoursesTbl();
		/* dynamically attach event handlers to some elements */
		attachHandlers();
	
	/* start of function definitions */

	function attachHandlers(){
		$("#addCourseBtn").on({
			click: ui_addCourse
		})
		$(".close-course-modal").on({
			click: ui_clearModal
		})
		$(".rt-search").on({
			keyup: ui_searchCourse,	
		})
		$(".modal").on('hide.bs.modal',ui_clearModal)
	}

	function attachTblHandlers(){
		$(".editCourseLink").on({
			click: ui_editCourse
		})
		$(".deleteCourseLink").on({
			click: ui_deleteCourse
		})
	}

	function loadCourses(){
		$.ajax({
			url: controllerName + "/loadCourses",
			method: "GET",
			cache: false,
			async: false
		}).done(function(result){
			courses = JSON.parse(result);
			courses = courses['results'];
		})
	}

	function saveCourseData(){
		if(validateForm()){
			var courseInfo = document.getElementsByClassName("course-info");   
			var courseInfoArr = [];
			for(var x=0;x<courseInfo.length;x++){
				courseInfoArr.push(courseInfo[x].value);
			}
			
			$.ajax({
				url: controllerName + "/addCourse",	
				method: "POST",
				data: { courseInfo: courseInfoArr },
				success: function(result){
					ui_loadCoursesTbl();
					ui_alert(1,"Success");
				},
				error: function(result){
					ui_alert(0,result.responseText);
				}
			});
		}	
	}

	function ui_addCourse(){
		$("#courseLabel").text("Add course");
		$("#saveCourseBtn").unbind('click');
		$("#saveCourseBtn").on({
			click: saveCourseData
		})
	}

	function validateForm(){
		var reqCourseInfo = document.getElementsByClassName("course-info required")
		var valid = true;
		for(var x=0;x<reqCourseInfo.length;x++){
			if($(reqCourseInfo[x]).val() == ""){
				$(reqCourseInfo[x]).attr("placeholder","Required");
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
		$("#alert-modal").modal('show');
		setTimeout(function(){
			$("#alert-modal").modal('hide');
		},"150000");
	}

	function editCourseData(){
		if(validateForm()){
			var courseInfo = document.getElementsByClassName("course-info");   
			var courseInfoArr = [];
			for(var x=0;x<courseInfo.length;x++){
				courseInfoArr.push(courseInfo[x].value);
			}

			$.ajax({
				url: controllerName + "/editCourse",	
				method: "POST",
				data: { 
					courseInfo: courseInfoArr,
					courseOrigId: tempCourseId 
				},
				success: function(response){
					ui_loadCoursesTbl();
					$(".modal").modal('hide');
					ui_alert(1,"course record successfully updated.");
				},
				error: function(response){
					ui_alert(0,response.responseText);
				}
			}).done(function(result){
				
			});
		}
	}

	function searchCourseId(courseId){
		var courseData = -1;
		for(var x=0;x<courses.length;x++){
			if(courses[x].id == courseId){
				courseData = courses[x];
				break;
			}
		}
		return courseData;
	}

	function ui_searchCourse(){
		var toSearch = $(".rt-search").val();
		var searchT = $(".rt-sfilter").val();
		var tRow = "";

		if(toSearch == ""){
			ui_loadCoursesTbl();
		}else{
			if(searchT == "id"){
				tRow += ui_loadCourseTbl(searchCourseId(toSearch));
			}else{
				var resultSet = searchCourseName(toSearch);
				for(var x=0;x<resultSet.length;x++){
					tRow += ui_loadCourseTbl(resultSet[x]);
				}
			}
			ui_resetCoursesTbl();
			$("#courseListTable").append(tRow);
			attachTblHandlers();
		}
	}

	function searchCourseName(courseName){
		var courseData = -1;
		var resultSet = [];
		for(var x=0;x<courses.length;x++){
			var subName = courses[x].name.substring(0,courseName.length);
			var subAlias = courses[x].alias.substring(0,courseName.length);
			if( subName == courseName || subAlias == courseName){
				courseData = courses[x];
				resultSet.push(courseData);
			}
		}
		return resultSet;
	}


	function deleteCourse(){
		var courseId = $(this).attr("id");
		$.ajax({
			url: controllerName + "/deleteCourse",
			method: "POST",
			data: {
				courseId: courseId
			},
			success: function(response){
				ui_loadCoursesTbl();
				$("#confirm-modal").modal('hide');
				ui_alert(1,"course record successfully deleted.");
			}
		}).done(function(result){
			
		});
	}

	function ui_editCourse(){
		var courseId = $(this).attr("id");
		tempCourseId = courseId;
		var courseData = searchCourseId(courseId);
		var courseDataArr = [];

		/* extract courseData object to array for convenient use 
		in automatically populating course-info input boxes */
		for(var x in courseData){
			courseDataArr.push(courseData[x]);
		}

		/* populate course-info input boxes w/ course data  */
		var courseInfoInput = document.getElementsByClassName("course-info");
		for(var x=0;x<courseInfoInput.length;x++){
			courseInfoInput[x].value = courseDataArr[x];
		}

		$("#courseLabel").text("Edit course Info");
		$("#saveCourseBtn").unbind('click');
		$("#saveCourseBtn").on({
			click: editCourseData
		})
	}

	function ui_deleteCourse(){
		var courseId = $(this).attr("id");
		var msg="Are you sure you want to delete this course record?";
		var title="Confirm Deletion";
		$("#confirm-title").text(title);
		$("#confirm-msg > h4").text(msg);

		$(".yes-btn").attr("id",courseId);
		$(".yes-btn").on({
			click: deleteCourse
		})

		$("#confirm-modal").modal('show');

	}

	function ui_loadCourseTbl(course){
		var tRow = "<tr>";
		tRow += "<td>" + course.id + "</td>";
		tRow += "<td>" + course.name + "</tds>";
		tRow += "<td>" + course.alias + "</td>";
		tRow += ui_attachActions(course.id);
		tRow += "</tr>";
		return tRow;
	}

	function ui_loadCoursesTbl(){
		loadCourses();
		ui_resetCoursesTbl();
		var tbl = $("#courseListTable");
		for(var x=0; x<courses.length; x++){
			var tRow = ui_loadCourseTbl(courses[x]);
			tbl.append(tRow);
		}
		attachTblHandlers();
	} 

	function ui_resetCoursesTbl(){
		$("#courseListTable").html(" ");
		attachTblHeader();
	}

	function attachTblHeader(){
		var tbl = $("#courseListTable");
		var tblHeaders = ["Course ID.","Name","Alias","Actions"];
		var tRow = $("<tr></tr>");
		for(var x=0;x<tblHeaders.length;x++){
			var header = $("<th></th>").text(tblHeaders[x]);
			tRow.append(header);
		}
		tbl.append(tRow);
	}
	
	function ui_attachActions(courseId){
		var tData = "<td>";
		tData +=
			"<div class='inline-div actions-menu'><a href='' class='editCourseLink' data-toggle='modal' data-target='#course-modal' id='"+courseId+"'>Edit</a></div>" +
			"<div class='inline-div actions-menu'><a href='' id='"+courseId+"' class='deleteCourseLink' data-toggle='modal'>Delete</a></div>";
		tData += "</td>";

		return tData;
	}

	function ui_clearModal(){
		var courseInfoInput = document.getElementsByClassName("course-info");
		for(var x=0;x<courseInfoInput.length;x++){
			courseInfoInput[x].value = '';
			courseInfoInput[x].placeholder = '';
		}
	}

	

});
 </script>