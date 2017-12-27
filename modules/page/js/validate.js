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

function load_ajax_block(sel,url)//,afterload=null
{
	$.getJSON(url,function(data)
	{
		$(sel).html(data.html);
		// javascripts
		for (var key in data.js) 
		{
			$('head').append($("<script src=\""+data.js[key]+"\"><\/script>")[0]);
		}
		// css
		for (var key in data.css) 
		{
			$('head').append($("<link rel=\"stylesheet\" type=\"text/css\" href=\""+data.css[key]+"\">"));

		}
		
		if(data.inline_js!="")
			res = eval(data.inline_js);
		/*
		if(afterload!=null)
			afterload();*/
		
	}).fail(function( jqxhr, textStatus, error ) {
	    var err = textStatus + ", " + error;
	    console.log( "Request Failed: " + err );
	});
}

function exe_process(pid,pwd,theform,fun_onstep=null,fun_onterminate=null)
{
	frm_data = new FormData();
	frm_data.append('pid',pid);
	frm_data.append('passw',pwd);
	
	form_action = theform.attr('action');
	
	$.ajax({
        url: form_action,
        type: 'POST',
        data: frm_data,
        mimeType:"multipart/form-data",
        contentType: false,
        cache: false,
        processData:false,
        dataType: 'json',
	    success: function(data, textStatus, jqXHR)
	    	{
	    	//	Получили идентификатор и пароль
	    	if(data.terminated)
	    		{
		    		if(fun_onterminate!=null)
	    			{
		    			fun_onterminate(data);
	    			}
		    		if(data.redirect)
		    		{
		    			document.location=data.redirect;
		    		}
	    		}	    	
	    	else
	    		{
	    		if(data.dialog)
	    			{
	    			pdata = new FormData();
	    			pdata.append('pid',pid);
	    			pdata.append('passw',pwd);
	    			show_proc_dialog(data.dialog,theform,pdata);
	    			}
	    		else
	    			{
	    				if(fun_onstep!=null)
	    				{
	    					fun_onstep(data);
	    				}
		    		
		    			exe_process(pid,pwd,theform,fun_onstep,fun_onterminate);
	    			}	    		
		    		
	    		}	    	
	    	},
	    error: function(jqXHR, textStatus, errorThrown) 
		    {	    	
		    	console.log(textStatus);	  
		    	$('#error_div').html(jqXHR.responseText);
		    },
		});
}

function proc_abort()
{
	
}

function show_proc_dialog(dlg_info,theform,pdata)
{
		
	dlg_div = $('<div></div>');
	
	if(dlg_info.settings)
	{
		if(dlg_info.settings.title)
		{
			$(dlg_div).attr('title',dlg_info.settings.title);
		}
	}
	
	$('body').append(dlg_div);
	dlg_div.html(dlg_info.html);	// html в див
	
	for (var key in dlg_info.js) 
	{
		$('head').append($("<script src=\""+dlg_info.js[key]+"\"><\/script>")[0]);
	}
	// css
	for (var key in dlg_info.css) 
	{
		$('head').append($("<link rel=\"stylesheet\" type=\"text/css\" href=\""+dlg_info.css[key]+"\">"));
	}
	
		
	if(dlg_info.inline_js!="")
		res = eval(dlg_info.inline_js);
	
	the_dialog_form = $(dlg_div).find('form');
	
	arr = $.map(theform[0].attributes, function (attribute) {
		the_dialog_form.attr(attribute.name, attribute.value);
		  });
	
	var dlg_options = { 
			height: "auto",
			width: "auto",
			resizable: false,	
			close: function () 
				{
					// signal to abort process
				
				
				form_action = theform.attr('action');
				// abort to true
				pdata.append('abort',true);
				
				$.ajax({
			        url: form_action,
			        type: 'POST',
			        data: pdata,
			        mimeType:"multipart/form-data",
			        contentType: false,
			        cache: false,
			        processData:false,
			        dataType: 'json',
				    success: function(data, textStatus, jqXHR)
				    	{
				    	
				    	}
					}
					);
		        },
			
			};
	
	if(dlg_info.settings)
		{
			for(var setting in dlg_info.settings)
			{
				dlg_options[setting]=dlg_info.settings[setting];
			}
		//dlg_options = dlg_info.settings;
		}
	
	dlg_options['modal']=true;
	//var dlg_options = dlg_info;
/*	var dlg_options = {     
    /*    buttons: {
          "Delete all items": function() {
            $( this ).dialog( "close" );
          },*/
/*          Cancel: function() {
            $( this ).dialog( "close" );
          }
      };*/
	
    $(dlg_div).dialog(dlg_options);
  //  console.log(dlgres);
}

function process_submit(that_form)
{
	pbid = $(that_form).attr('pbid');
	//alert(pbid);
	if($('#'+pbid).length)
		pb_show(pbid);
	
	$(that_form).find('#mul_form_progress').show();
	
	form_action = $(that_form).attr('action');
	var the_data = new FormData(that_form[0]);
	$.ajax({
        url: form_action,
        type: 'POST',
        data: the_data,
        mimeType:"multipart/form-data",
        contentType: false,
        cache: false,
        processData:false,
        dataType: 'json',
	    success: function(data, textStatus, jqXHR)
	    	{
	    	$(that_form).find('#mul_form_progress').hide();
	    	dialog_divs = $(that_form).parents('[role="dialog"]');
	    	
	    	
	    	//	Получили идентификатор и пароль
	    	exe_process(data.pid,data.passw,that_form,
	    			function(jsondata)
	    				{
	    					pb_set_procent(pbid,jsondata.procent);
	    				},
			    	function(jsondata)
						{
	    					if($('#'+pbid).length)
	    						pb_hide(pbid);
						}
	    			)
	    	
	    	if(dialog_divs.length>0)
	    		{
	    			//$(dialog_divs[0]).remove();	    		
	    			nested_div = $(dialog_divs[0]).children("div.ui-dialog-content")[0];
	    			$(nested_div).dialog( "close" );
	    		}
	    	
	    	},
		error: function(jqXHR, textStatus, errorThrown) 
	    {	    	
			$(that_form).find('#mul_form_progress').hide();
	    	console.log(textStatus);	    	
	    },
		});
    
	return false;
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
					
					if( $(that_form)[0].hasAttribute('process') )
		    		{
						process_submit(that_form);
						return false;
		    		}
					else
		    		{
						return true;
		    		}
				}
				else
				{
				/*	if( $(that_form)[0].hasAttribute('pbid') )	
					{
						e.preventDefault();
						return false;
					}
				*/
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
				}
				
				);
				
			}
			
			);
});	

function clear_file(table,fld)
{
	$('#file_source_'+fld).css('text-decoration','line-through');
	$('input[type=hidden][name="'+table+'['+fld+']"]').val('');
	$('input[type=file][name="'+table+'['+fld+']"]').val('');
	return false; 
}

