
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
					<label>Search:</label><input type="text" name="studSearch" id="studSearch" class="rt-search" placeholder="Enter Name or ID.."> 	
					<label>Sort by:</label><select id="resultsOrder">
						<option value="id">ID Number</option>
						<option value="last_name">Name</option>
						<option value="date_added">Date Added</option>
					</select>
					<select id="orderPattern">
						<option value="ASC">Ascending</option>
						<option value="DESC">Descending</option>
					</select>
				</div>
				<table id="studListTable" class="defaultTable table table-bordered table-hover">
					<!-- Student data   -->
				</table>
				<div id="tblLinks"><!-- Table pagination --> </div>
			</div>

		<!-- start of student modal -->
		<div id="student-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="studLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close close-stud-modal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="studLabel">Add Student</h4>
						<button type="button" class="btn import-csv" style="display:none">Import CSV File</button>
						<input id="csvfile" type="file" name="csvfile" style="display:none" />
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

		<!-- start of confirm modal -->
			<div id="confirm-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmModal">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close close-stud-modal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="confirm-title">Sample Title</h4>
						</div>
						<div id="confirm-msg" class="modal-body">
							<h4>Sample</h4>
							<button type="button" class="btn btn-primary yes-btn">Yes</button>
							<button type="button" class="btn btn-primary no-btn">No</button>
						</div>
					</div>
				</div>
			</div>
		<!-- end of confirm modal -->

	</div> 
	<!-- end of main-content area -->

<script>


	$(document).ready(function(){
		
		/* globals declaration*/
		var studCountTotal = 0;
		var tempStudId = -1;
		var controllerName = "student";

		/* load students info from DB and present them in tabular form */
		loadStuds();
		/* dynamically attach event handlers to some elements */
		attachHandlers();
	

	/* start of function definitions */

	function attachHandlers(){
		$("#addStudBtn").on({
			click: ui_addStudent
		})
		$(".close-stud-modal").on({
			click: ui_clearModal
		})
		$(".rt-search").on({
			keyup: ui_searchStud,
			focus: function(){
				if($(".rt-search").val() != ""){
					ui_searchStud();
				}
			}	
		})
		$("#resultsOrder").on({
			change: function(){
				if($(".rt-search").val() === ""){
					loadStuds();	
				}else{
					ui_searchStud();
				}
			}
		})
		$("#orderPattern").on({
			change: function(){
				if($(".rt-search").val() === ""){
					loadStuds();	
				}else{
					ui_searchStud();
				}
			}
		})
		$(".import-csv").on({
			click: ui_importCsv
		})
		$("#csvfile").on({
			change: importCsv
		})
		$(".modal").on('hide.bs.modal',ui_clearModal)
	}

	function attachTblHandlers(){
		$(".editStudLink").on({
			click: ui_editStudent
		})
		$(".deleteStudLink").on({
			click: ui_deleteStudent
		})
	}

	function importCsv(){
		var file_data = $("#csvfile").prop('files')[0];
		var form_data = new FormData();
		form_data.append('file', file_data);

		$.ajax({
			url: controllerName + '/addByCsv',
			method: "POST",
			data:  form_data,
			cache: "false",
			contentType: false,
			dataType: 'text',
			processData: false,
			success: function(response){
				loadStuds();
				var results = JSON.parse(response);
				var rowAdded = results['rowAdded'];
				var rowSkipped = results['rowSkipped'];
				var rowsAddedStr = "";
					for(var x=0;x<rowAdded.length;x++){
						rowsAddedStr += rowAdded[x].id + "\t";
						rowsAddedStr += rowAdded[x].last_name + "<br/>";
					}
				var rowsSkippedStr = "";
					for(var x=0;x<rowSkipped.length;x++){
						rowsSkippedStr += rowSkipped[x].id + "\t";
						rowsSkippedStr += rowSkipped[x].last_name + "<br/>";
					}
				var resultMsg = "No. of records added: " + rowAdded.length + 
								"<br/>" + rowsAddedStr + 
								"<br/>"  + "No. of duplicate records skipped: " + rowSkipped.length +
								"<br/>" + rowsSkippedStr;
				ui_alert(1,resultMsg);
			},
			error:function(response){
				ui_alert(0,response);
				console.log("\n" + response.responseText);
			}
		})
	}

	function ui_importCsv(){

		$("#csvfile").click();
	}

	function saveStudData(){
		if(validateForm()){
			var studInfo = document.getElementsByClassName("stud-info");   
			var studInfoArr = [];
			for(var x=0;x<studInfo.length;x++){
				studInfoArr.push(studInfo[x].value);
			}
			
			$.ajax({
				url: controllerName + "/addStudent",	
				method: "POST",
				data: { studentInfo: studInfoArr },
				success: function(result){
					loadStuds();
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
		$("#alert-modal").modal('show');
		setTimeout(function(){
			$("#alert-modal").modal('hide');
		},"150000");
	}

	function editStudData(){
		if(validateForm()){
			var studInfo = document.getElementsByClassName("stud-info");   
			var studInfoArr = [];
			for(var x=0;x<studInfo.length;x++){
				studInfoArr.push(studInfo[x].value);
			}

			$.ajax({
				url: controllerName + "/editStudent",	
				method: "POST",
				data: { 
					studentInfo: studInfoArr,
					studOrigId: tempStudId 
				},
				success: function(response){
					loadStuds();
					$(".modal").modal('hide');
					ui_alert(1,"Student record successfully updated.");
				}
			}).done(function(result){
				
			});
		}
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
		}

		$("#studLabel").text("Edit Student Info");
		$(".import-csv").attr("style","display:none");
		$("#saveStudBtn").unbind('click');
		$("#saveStudBtn").on({
			click: editStudData
		}) 
	}

	function searchStudId(studId){  
		var studData = -1;

		$.ajax({
			url: controllerName + "/aj_searchIndivId",
			method: "POST",
			async: false,
			data:{
				studId: studId
			},
			success: function(response){
				var data = JSON.parse(response);
				studData = data['results'];
				studData = studData[0];
				
			}
		})
		
		return studData;
	}

	function ui_searchStud(){
		var toSearch = $(".rt-search").val();
		var searchT = $(".rt-sfilter").val();
		var orderBy = $("#resultsOrder").val();
		var orderPattern = $("#orderPattern").val();
		var tRow = "";

		if(toSearch == ""){
			loadStuds();
		}else{
			var searchDetail = {
				'sKey': toSearch,
				'sType': searchT,
				'orderBy': orderBy,
				'orderPattern': orderPattern
			}
			searchStud(searchDetail);
		}
	}

/*	function searchStud(sKey,sType){
		var studData = -1;
		var resultSet = [];
		var studProps = ["id","last_name","first_name","middle_name"];
		var startPos = (sType == "name") ? 1 : 0;
		var endPos = (sType == "name") ? 4 : 1;
		
		for(var x=0;x<students.length;x++){
			var studObj = students[x];
			for(var y=startPos; y<endPos; y++){
				var substrProp = studObj[studProps[y]].substring(0,sKey.length);
				if(substrProp.toUpperCase() == sKey.toUpperCase())
					resultSet.push(studObj);
			}
		}
		return resultSet;
	}
*/
	
/*	function searchStudName(studName){
		var studData = -1;
		var resultSet = [];
		for(var x=0;x<students.length;x++){
			var subLname = students[x].last_name.substring(0,studName.length);
			var subFname = students[x].first_name.substring(0,studName.length);
			var subMname = students[x].middle_name.substring(0,studName.length);
			if( subMname == studName || subFname == studName || subLname == studName){
				studData = students[x];
				resultSet.push(studData);
			}
		}
		return resultSet;
	} */

	function deleteStudent(){
		var studId = $(this).attr("id");
		$.ajax({
			url: controllerName + "/deleteStudent",
			method: "POST",
			data: {
				studId: studId
			},
			success: function(response){
				loadStuds();
				$("#confirm-modal").modal('hide');
				ui_alert(1,"Student record successfully deleted.");
			}
		}).done(function(result){
			
		});
	}

	function ui_addStudent(){
		$("#studLabel").text("Add Student");
		$(".import-csv").attr("style","display:block");
		$("#saveStudBtn").unbind('click');
		$("#saveStudBtn").on({
			click: saveStudData
		})
	}

	function ui_deleteStudent(){
		var studId = $(this).attr("id");
		var msg="Are you sure you want to delete this student record?";
		var title="Confirm Deletion";
		$("#confirm-title").text(title);
		$("#confirm-msg > h4").text(msg);

		$(".yes-btn").attr("id",studId);
		$(".yes-btn").on({
			click: deleteStudent
		})

		$("#confirm-modal").modal('show');

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

	function loadStuds(startPos=0,orderBy="id",orderPattern="ASC"){

		getStudCount();
		var orderBy = $("#resultsOrder").val();
		var orderPattern = $("#orderPattern").val();

		$.ajax({
			url: controllerName + "/loadStuds",
			method: "POST",
			async: false,
			data: {
				startPos: startPos,
				orderBy: orderBy,
				orderPattern: orderPattern
			},
			success: function(response){
				var students = JSON.parse(response);
				students = students['results'];
				ui_loadStudsTbl(students,"loadStuds");
				//ui_buildTblLinks();
			},
			error: function(response){
				ui_alert(0,response.responseText);
				console.log(response);
			}
		}).done(function(result){
			
		})
	}

	function searchStud(searchDetail){
		if(!(searchDetail.hasOwnProperty("startPos"))){
			searchDetail['startPos'] = 0;
		}else{
			searchDetail['sKey'] = $(".rt-search").val();
			searchDetail['sType'] = $(".rt-sfilter").val();
			searchDetail['orderBy'] = $("#resultsOrder").val();
			searchDetail['orderPattern'] = $("#orderPattern").val();
		}
		$.ajax({
			url: controllerName + "/aj_searchById",
			data:{
				studId: searchDetail.sKey,
				startPos: searchDetail.startPos,
				orderBy: searchDetail.orderBy,
				orderPattern: searchDetail.orderPattern 
			},
			method: "POST",
			async: false,
			success: function(response){
				var results = JSON.parse(response);
				students = results['limitedRows'];
				studCountTotal = results['totalRows'];
				ui_loadStudsTbl(students,"searchStud");
				console.log(response);
			},
			error: function(response){
				ui_alert(0,response.responseText);
				console.log(response);
			}
		})
	}
	
	function ui_buildTblLinks(page,callbackFunc){
		
		var tblLinks = $("#tblLinks");
		var dataPerPage = 15;
		
		if(typeof(page) === "object"){
			var startPos = $(page).attr("data");
			page = page.text;
			if(page.toUpperCase() === "PREV"){
				startPos = parseInt($("#tblLinks .curr-tbl-link").attr("data")) - dataPerPage;
				page = parseInt($("#tblLinks .curr-tbl-link").text()) - 1;
			}else if(page.toUpperCase() === "NEXT"){
				startPos = parseInt($("#tblLinks .curr-tbl-link").attr("data")) + dataPerPage;
				page = parseInt($("#tblLinks .curr-tbl-link").text()) + 1;
			}

			if(callbackFunc === "loadStuds"){
				loadStuds(startPos);	
			}else{
				var searchDetail = {
					'startPos': startPos
				};
				searchStud(searchDetail);
			}
		}

		$("#tblLinks").html(" ");
		var pageCount = Math.floor(studCountTotal / dataPerPage);
			if(pageCount % dataPerPage != 0)
				pageCount++;

		if(pageCount > 1){

			if(page > 1){
				var prev = $("<a class='tblLink' style='cursor:pointer;' data='prev'>Prev</a>");
				tblLinks.append(prev);
			}
			var startPos = 0;		

			for(var x=1; x<=pageCount; x++){
				var link;
				if(x == page){
					link = $("<a class='tblLink curr-tbl-link " + callbackFunc + "' style='cursor:pointer;' data='"+startPos+"'>" +x+ "</a>");
				}else{
					link = $("<a class='tblLink " + callbackFunc + "' style='cursor:pointer;' data='"+startPos+"'>" +x+ "</a>");
				}

				startPos += dataPerPage;
				tblLinks.append(link);
			}

			if(page < pageCount){
				var next = $("<a class='tblLink' style='cursor:pointer;' data='next'>Next</a>");
				tblLinks.append(next);
			}
			$(".tblLink").on({
				click: function(){
					ui_buildTblLinks(this,callbackFunc);
				}
			})
		}

	}

	function ui_loadStudsTbl(students,callbackFunc){
		ui_resetStudsTbl();
		var tbl = $("#studListTable");
		for(var x=0; x<students.length; x++){
			var tRow = ui_loadStudTbl(students[x]);
			tbl.append(tRow);
		}
		attachTblHandlers();
		ui_buildTblLinks(1,callbackFunc)
	} 

	function getStudCount(){
		$.ajax({
			url: controllerName + "/getStudCount",
			method: "GET",
			cache: false,
			async: false,
			success: function(response){
				studCountTotal = JSON.parse(response)
				studCountTotal = studCountTotal['studCount'];
			},
			error: function(response){
				ui_alert(0,response.responseText);
			}
		})
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
			"<div class='inline-div actions-menu'><a href='' id='"+studId+"' class='deleteStudLink' data-toggle='modal'>Delete</a></div>";
		tData += "</td>";

		return tData;
	}

	function ui_clearModal(){
		var studInfoInput = document.getElementsByClassName("stud-info");
		for(var x=0;x<studInfoInput.length;x++){
			studInfoInput[x].value = '';
			studInfoInput[x].placeholder = '';
		}
	}

	

});
 </script>