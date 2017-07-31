function clone_form(form_selector)
{
	form_obj = $(form_selector)[0];
	newfrm = $('<form></form>');
	/* Копируем все свойства формы */	
	for (var key in form_obj.attributes) {
		$(newfrm).attr(form_obj.attributes[key].name,form_obj.attributes[key].value);
	}
	
	$(form_obj).find('input, select, submit').each(function(i,el)
		{
			el_cloned = $(el).clone();
			$(newfrm).append(el_cloned);
		});
		
	return newfrm;
}

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
					if( ( that_form.attr("files_loaded") == undefined) && (that_form.find('input[type=file]').length > 0) )
					{
						// отправляем файлы
						form_action_upload = that_form.attr('action');
						form_action_upload = form_action_upload+"/action:uploadfile";
						e.preventDefault();
						var the_data = new FormData(that_form[0]);
						progressbar = $(that_form).find('#mul_form_progress');
						
						$(that_form).find('#mul_form_progress').show();
						if( (that_form).find('#mul_form_progress .progress-bar').length>0 )
						{
							show_procent_timer = setInterval(function()
					            	{
					            		$(that_form).find('#mul_form_progress .progress-bar').text($(that_form).find('#mul_form_progress').text()+"+");
					            	}, 10);
						}					
			            					
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
						    	progressbar.hide();
						    	that_form.attr("files_loaded",'true');
						    	// заменяем на полученные значения
						    	for (var key in data) {
						    		file_field = that_form.find('input[name="'+key+'"][type=hidden]').first();
						    		if(file_field.length==0)
						    			{
						    			file_field=$('<input name="'+key+'" type="hidden" />');
						    			file_field.val(data[key]);
						    			that_form.append(file_field);
						    			}
						    		else
						    			{
						    			file_field.attr('type','hidden');
						    			file_field.val(data[key]);
						    			}
						    		$(that_form).find('input[type=file][name="'+key+'"]').remove();
						    	}
						    	if(typeof show_procent_timer !='undefined')
						    		clearTimeout(show_procent_timer);
						    	that_form.submit();
						    },
						    error: function(jqXHR, textStatus, errorThrown) 
						    {
						    	progressbar.hide();
						    	console.log(textStatus);
						    	if(typeof show_procent_timer !='undefined')
						    		clearTimeout(show_procent_timer);
						    },
						  
						    
						    });
								
					}
					
					return true;
				}
				
				e.preventDefault();
				form_action_base = e.target.action;
				form_action = form_action_base + "/action:validate";
		
				// перед отправкой на валидацию чтобы сериализовать создаем клон где вместо файла текст с путем к файлу
				//cloned_form=$(this).clone(false);
				
				cloned_form = clone_form(this);
				
				cloned_form_files = $(cloned_form).find('input[type=file]');
				$(this).find('input[type=file]').each(function( i, el ) 
					{
						original_src = $(el).val();
						if(original_src=='')
						{
						// взять из хиддена	
							allready_uploaded = $(that_form).find('input[type=hidden][name="'+$(el).attr('name')+'"]').first();
							if(allready_uploaded!== typeof undefined)
							{
								original_src = $(allready_uploaded).val();
							}
						}
						file_in_copy = cloned_form_files.get(i);
						$(file_in_copy).attr('type','text');
						$(file_in_copy).val(original_src);
						// удалить хидден из клона если он есть
						$(cloned_form).find('input[type=hidden][name="'+$(el).attr('name')+'"]').remove();
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
							if(Array.isArray(json[key]))
							{							
								for(var idx in json[key])
								{
									if(ctr)
										full_str = full_str+'<br />'+json[key][idx];
									else
										full_str = full_str+json[key][idx];
									ctr++;
								}
							}
							else
								full_str = full_str+json[key];
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

function clear_file(table,fld)
{
	$('#file_source_'+fld).css('text-decoration','line-through');
	$('input[type=hidden][name="'+table+'['+fld+']"]').val('');
	$('input[type=file][name="'+table+'['+fld+']"]').val('');
	return false; 
}

