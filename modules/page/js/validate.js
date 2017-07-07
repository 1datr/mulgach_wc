$( document ).ready(function() 
{
			//		$('#items_block').jqStructBlock();
			//		$('#fields_block').jqStructBlock();
	$(document).on("submit",".mul_form", function(e, submit)
		{
		
				that_form = $(this);
				if(that_form.attr('validated')=="true") // форма отвалидована
				{
					// отправляем файлы если есть и не отправлены
					if( ( that_form.attr("files_loaded") !== typeof undefined) && (that_form.find('input[type=file]').length > 0) )
					{
						// отправляем файлы
						form_action_upload = that_form.attr('action');
						form_action_upload = form_action_upload+"/action:uploadfile";
						e.preventDefault();
						var the_data = new FormData(that_form[0]);
						$.ajax({
						        url: form_action_upload,
						        type: 'POST',
						        data: the_data,
						        mimeType:"multipart/form-data",
						        contentType: false,
						        cache: false,
						        processData:false,
						        dataType: 'json',
						    success: function(data, textStatus, jqXHR)
						    {
						    	that_form.attr("files_loaded",'true');
						    	// заменяем на полученные значения
						    	for (var key in data) {
						    		file_field = that_form.find('input[name="'+key+'"][type=file]').first();
						    		file_field.attr('type','hidden');
						    		file_field.val(data[key]);
						    	}
						    	that_form.submit();
						    },
						    error: function(jqXHR, textStatus, errorThrown) 
						    {
						    	 console.log(textStatus);
						    }
						    
						    });
								
					}
					
					return true;
				}
				
				e.preventDefault();
				form_action_base = e.target.action;
				form_action = form_action_base + "/action:validate";
		
				// перед отправкой на валидацию чтобы сериализовать создаем клон где вместо файла текст с путем к файлу
				cloned_form=$(this).clone();
				cloned_form_files = $(cloned_form).find('input[type=file]');
				$(this).find('input[type=file]').each(function( i, el ) 
					{
						original_src = $(el).val();
						file_in_copy = cloned_form_files.get(i);
						$(file_in_copy).attr('type','text');
						$(file_in_copy).val(original_src);
					}
				);
				
				cloned_form_selects = $(cloned_form).find('select');
				$(that_form).find('select').each(function( i, el ) 
					{
						original_src = $(el).val();
						file_in_copy = cloned_form_selects.get(i);						
						$(file_in_copy).val(original_src);
					}
				);
				
				m_data=$(cloned_form).serialize();
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
						if(XMLHttpRequest.responseText!='')
							{
								$('body').append('<p>'+XMLHttpRequest.responseText+'</p>');
							}
						console.log(textStatus);
						console.log(errorThrown);
					}
				});
				
			});
});								
