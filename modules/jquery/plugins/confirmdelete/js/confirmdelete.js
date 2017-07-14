$( document ).ready(function() {
  // Handler for .ready() called.
	$('.ref_delete').click(function()
		{
			attr_confirm = $(this).attr('conf_message');
			if(attr_confirm==undefined)
				attr_confirm="Delete this object?";
			if(confirm(attr_confirm))
			{
				return true;
			}
			return false;
		});
});
