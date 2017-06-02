// filter for {fld} (lookup)
if(!empty($_REQUEST['filter']['{fld}']))
{
	if(count($_REQUEST['filter']['{fld}'])>0)
	{
		$_FILTER = $_FILTER." AND `{table}`.`{fld}` in (".ximplode(',',$_REQUEST['filter']['{fld}'],"'","'").")";
	}
}
		 