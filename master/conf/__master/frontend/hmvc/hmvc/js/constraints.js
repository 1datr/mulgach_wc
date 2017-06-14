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

function add_block()
{
	block_one_sel = '.multiform_block';
	block_list_sel = '#items_block';
	new_data_block = $(block_one_sel).first().clone();
	new_data_block.css('visibility', 'visible' );
	
	var nb_html = new_data_block.html();
	// сколько элементов в списке 
	var childs = $(block_list_sel+" "+block_one_sel);
	
	nb_html = nb_html.replace(/{idx}/g, childs.length.toString());

	$(block_list_sel).append(nb_html);
	//$('#constraints_block').append(new_data_block);
} 

function drop_block(this_button)
{
	$(this_button).parent(".multiform_block").remove();
}

$( document ).ready(function() {
	
    $('.drg_view').draggable({cursor: 'crosshair'});
    
   // $('#bindings').jqDynaForm();
});


