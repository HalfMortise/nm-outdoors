$(document).ready(function () {
	$(".btn-primary").click(function () {
		$("#list").toggleClass("collapsed");
		$("#map").toggleClass("col-md-12 col-md-9");

		return false;
	});
});