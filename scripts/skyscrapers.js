$(document).ready(function() {
	$('.sort-select').on('change', function() {
		window.location.href = $(this).val();
	});
}); 
