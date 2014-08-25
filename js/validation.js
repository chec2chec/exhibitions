jQuery(document).ready(function( $ ) {
	$('#minor-publishing').hide();
	
	var showHide = function()
	{
		var type = '';
		type = $('input[name="boj_mbe_type"]:checked').val();
		if(type == 'false')
		{
			$('tr#boj_mbe_type').hide();
		}
		
		type = $('input[name="boj_mbe_type"]:checked').val();
		if(type == 'true')
		{
			$('tr#boj_mbe_type').show();
			$('span#boj_mbe_depth').hide();
		}
		else
		{
			$('tr#boj_mbe_type').hide();
			$('span#boj_mbe_depth').show();
		}
	}
	
	showHide();
	$('input[name="boj_mbe_type"]').change(function(){
		showHide();
	});
});