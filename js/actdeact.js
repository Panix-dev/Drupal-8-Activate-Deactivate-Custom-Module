(function($) {

$(document).on('click','.trigger-class',function(e) {
	e.preventDefault();
	var btn = $(this);
	var current_id = $('article.node--type-listing').attr('data-history-node-id');

	btn.text('Loading...');

	$.ajax({
	    url: '/activate-deactivate?current_id='+current_id,
	    type:"GET",
	    contentType:"application/json; charset=utf-8",
	    dataType:"json",
	    success: function(response) {
	        // console.log(response);
	        if(response == 'u') {
	        	btn.html('<i class="fas fa-dot-circle"></i> Activate');
	        } else if(response == 'p') {
	        	btn.html('<i class="far fa-dot-circle"></i> Deactivate');
	        } else {
	        	btn.text('Try Again');
	        }
	    }
	});
});

})(jQuery);
