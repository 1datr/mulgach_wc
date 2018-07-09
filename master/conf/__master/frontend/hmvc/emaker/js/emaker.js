

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

function get_field_list()
{
	var trs = $('#fields_block > .items').find('tr.multiform_block');
	var fields=new Array();
	var login_fld = $('[name="entity[auth_fld_login]"]');
	var email_fld = $('[name="entity[auth_fld_email]"]');
	var passw_fld = $('[name="entity[auth_fld_passw]"]');
	var hash_fld = $('[name="entity[auth_fld_hash]"]');
	
	$(login_fld).empty();
	$(email_fld).empty();
	$(passw_fld).empty();
	$(hash_fld).empty();
	
	for(i=0;i<trs.length;i++)
	{
		selector='[name="entity[fieldlist]['+i+'][fldname]"]';
		var newfld = $(selector).val();
		//fields.push(newfld);
		$(login_fld).append( $('<option value="'+newfld+'">'+newfld+'</option>') );
		$(email_fld).append( $('<option value="'+newfld+'">'+newfld+'</option>') );
		$(passw_fld).append( $('<option value="'+newfld+'">'+newfld+'</option>') );
		$(hash_fld).append( $('<option value="'+newfld+'">'+newfld+'</option>') );
	}
}

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
	
	load_ajax_block(el_fldinfo,"/master/emaker/typeinfo/"+cfg+"/"+fldtype+"/"+fld_name+"/"+entity_name);//+"/"+nameroot);
	
}

function on_entity_change(type_el)
{
	var cfg = $('[name="entity[cfg]"').val();
	var fldtype = $(type_el).val(); 
	var fld_name = $(type_el).attr('name');
	var entity_to = $('._entity_to').val();
	var el_fld_to = $(type_el).parents('._eref').one().find('._fld_to');
	
	el_fld_to.html("");
	
	var the_url = "/master/emaker/efields/"+cfg+"/"+entity_to;
	$.getJSON( the_url, function( data ) {
		  el_fld_to.html("");
		  $.each( data.items, function( key, val ) {
			  el_fld_to.append($('<option value="'+val+'">'+val+"</option>"));
		  });
	}).fail(function( jqxhr, textStatus, error ) {
	    var err = textStatus + ", " + error;
	    console.log(textStatus);	  
	    $('body').append('<div class="error_box">'+jqxhr.responseText+"</div>");
	});
}