function pb_set_procent(pbid,proc)
{
	if($('#'+pbid+'_inside').length)
	{
		$('#'+pbid+'_inside').css('width',proc+'%');
		$('#'+pbid+'_inside').html(proc+'%');	
	}
}

function pb_show(pbid)
{
	if($('#'+pbid).length)
		$('#'+pbid).show();
} 

function pb_hide(pbid)
{
	if($('#'+pbid).length)
		$('#'+pbid).hide();
} 