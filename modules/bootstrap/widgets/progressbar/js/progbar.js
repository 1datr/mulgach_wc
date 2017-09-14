function pb_set_procent(pbid,proc)
{
	$('#'+pbid+'_inside').css('width',proc+'%');
	$('#'+pbid+'_inside').html(proc+'%');
}

function pb_show(pbid)
{
	$('#'+pbid).show();
} 

function pb_hide(pbid)
{
	$('#'+pbid).hide();
} 