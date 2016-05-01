
$(document).ready({
	
	$(".rt-search").on({
		keydown: searchRT
	})

	function searchRT(){
		var toSearch = $(".rt-search").value;
		var searchT = $(".rt-sfilter").value;

		searchStud(toSearch,searchT)

	}


})
