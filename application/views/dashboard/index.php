


		<div id="main-content" class="span4 main-content">	<!-- start of main-content area -->
			<div id="bulletin-board" >
			
			</div>
			<div id="active-classes">
			
			</div>
			<div id="active-class-record">
			
			</div>
		</div> <!-- end of main-content area -->

		<script type="text/javascript">
			$(document).ready(function(){
				var controllerName = "dashboard";

				$.ajax({
					url: controllerName + "/get_tweets",
					method: "GET",
					success: function(response){
						//response2 = JSON.parse(response[0]);
						//var tweets = "";
						//foreach(x in response){
						//	tweets += response[x] + "\n";
						//}
						//$("#bulletin-board").text(tweets);
						var tweets = "";
						for(var x=0;x<response.length; x++){
							tweets += response[x].text + "\n";
						}
						$("#bulletin-board").text(tweets);
						console.log(tweets);
					}
				})
				
			});

		</script>