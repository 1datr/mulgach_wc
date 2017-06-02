// code for order 
if(!empty($_REQUEST['ord_{fld}']))
{
	if($_ORDER=="")
	{
		$_ORDER="ORDER BY `{table}`.`{fld}` ".$_REQUEST['ord_{fld}'];
	}
	else	
		$_ORDER=$_ORDER.",`{table}`.`{fld}` ".$_REQUEST['ord_{fld}'];
}