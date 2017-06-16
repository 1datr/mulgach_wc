function load_fields(select_element)
{
	//var table_to_select = $(this).parent('div.multiform_block').find('select.table_to_select');
	var selected_table = $(select_element).val();
	var config = $('#config').val();
	var url_to_ajax = "\?r=hmvc/fields/"+config+"/"+selected_table;
	$.ajax({
	    url: url_to_ajax,
	    dataType: 'json',
	    type: 'post',
	    contentType: 'application/json',
	  //  data: JSON.stringify( { "first-name": $('#first-name').val(), "last-name": $('#last-name').val() } ),
	    processData: false,
	    success: function( data, textStatus, jQxhr ){
	       // $('#response pre').html( JSON.stringify( data ) );
	    	//var fields_to_element = $(select_element).parent('div.multiform_block').find('select.fld_to_select');
	    	var fields_to_element = $(select_element).parent().find('select.fld_to_select');
	    	fields_to_element.html('');
	    	for (var key in data) 
	    	{
	    		fields_to_element.append('<option value="' + key + '">' + key + '</option>')
	    	}
	    },
	    error: function( jqXhr, textStatus, errorThrown ){
	        console.log( errorThrown );
	        $('#console').html(errorThrown.message);
	    }
	});
	
}

function check_required(el)
{
	field = $(el).val();
	if($('#field_'+field+'_required').is(':checked'))//.attr('checked')=='checked')
	{
		cb_req = $(el).parent().find('.cb_required');
		cb_req.attr('checked',true);
		$(cb_req).bind("click",function()
			{
				return false;
			});
	}
	else
	{
		cb_req.off('click');
	}
}


$( document ).ready(function() {
	
  //  $('.drg_view').draggable({cursor: 'crosshair'});
    
   // $('#bindings').jqDynaForm();
});


