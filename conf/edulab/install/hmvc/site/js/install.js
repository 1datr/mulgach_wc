function call_install_table(baseurl,idx=0)
{
	$.ajax({
	   	type: "POST",                 
	   	url: baseurl+"/"+hmvcs[idx],
		dataType: "json",
	   	success: function(res) {   
										
			$("#install_console").html($("#install_console").html()+"<div class='message'>"+res.message+"</div>");	
			if(idx+1<=hmvcs.length-1)
			{
				call_install_table(baseurl,idx+1);
			}
	 		else
			{
			
			}
	   	}
	});
}