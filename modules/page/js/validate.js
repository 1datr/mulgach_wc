$( document ).ready(function() 
{
			//		$('#items_block').jqStructBlock();
			//		$('#fields_block').jqStructBlock();
	$(document).on("submit",".mul_form", function(e, submit)
		{
				that_form = $(this);
				if(that_form.attr('validated')=="true")
				{
					return true;
				}
				
				e.preventDefault();
				form_action_base = e.target.action;
				form_action = form_action_base + "/action:validate";
							 
				 m_data=$(this).serialize();
				 res_check=true;
				 $.ajax({
					url: form_action, // 
					type: $(this).attr('method'), // 
					data: m_data,
					dataType: 'json',
					success: function(json){
						$(".error").text("");
						var counter = 0;
						for (var key in json) {
							// ...
							var full_str='';
							var ctr=0; 
							for(var idx in json[key])
							{
								if(ctr)
									full_str = full_str+'<br />'+json[key][idx];
								else
									full_str = full_str+json[key][idx];
								ctr++;
							}
							$("#err_"+key).html(full_str);
							counter++;
						}
						
						if(counter>0)
						{
							return;
						}
												
						that_form.attr('validated',"true");
						that_form.submit();

					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						console.log(XMLHttpRequest.statusText);
						console.log(textStatus);
						console.log(errorThrown);
					}
				});
				
			});
});								
