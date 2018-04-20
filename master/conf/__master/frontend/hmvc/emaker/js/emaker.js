$( document ).ready(function() 
{
	$('.ref_delete').click(function(obj) 
    		{
    			if(confirm($(obj).attr('conf_message')))
    			{
    				return true;
    			}
    			return false;
    		});
});

function on_sel_file(el)
{
	if($(el).prop('checked'))
		$(el).parents('.fielditem').one().find('.filetype_div').show()
	else
		$(el).parents('.fielditem').one().find('.filetype_div').hide()
}

function on_type_change(type_el)
{
	var cfg = $('[name="entity[cfg]"').val();
	var fldtype = $(type_el).val(); 
	var fld_name = $(type_el).attr('name');
	var entity_name = $('[name="entity[ename]"]').val();
	var el_fldinfo = $(type_el).parents('.fielditem').one().find('.fldinfo');
	
	load_ajax_block(el_fldinfo,"/master/emaker/typeinfo/"+cfg+"/"+fldtype+"/"+fld_name+"/"+entity_name);
	
}

function on_entity_change(type_el)
{
	var cfg = $('[name="entity[cfg]"').val();
	var fldtype = $(type_el).val(); 
	var fld_name = $(type_el).attr('name');
	var entity_name = $('name="entity[ename]"').val();
	var el_fldinfo = $(type_el).parents('.fielditem').one().find('.fldname');
	
	var the_url = "/master/emaker/efields/"+cfg+"/"+entity_name;
	$.getJSON( the_url, function( data ) {
		  fields_sel =$(this).parents('.').find();		  
		  $.each( data.items, function( key, val ) {
		    
		  });
	});
}