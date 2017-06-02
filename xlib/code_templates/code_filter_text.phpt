// filter for {fld}
if(!empty($_REQUEST['filter']['{fld}']))
	$_FILTER = $_FILTER." AND `{table}`.`{fld}` like '%".$_REQUEST['filter']['{fld}']."%'";	 