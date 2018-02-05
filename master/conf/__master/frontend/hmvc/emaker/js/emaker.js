$( document ).ready(function() 
{
	
});

function on_sel_file(el)
{
	if($(el).prop('checked'))
		$(el).parents('.fielditem').one().find('.filetype_div').show()
	else
		$(el).parents('.fielditem').one().find('.filetype_div').hide()
}