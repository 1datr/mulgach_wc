<?php
// модуль архивация
require_once url_seg_add(__DIR__,"trait_arcplg.php");

class mul_archive extends mul_Module 
{
	function __construct($_PARAMS)
	{
		
	}
	
	static function use_archive_plg($plg,$params=[])
	{
		$plg = find_module(self::st_get_mod_name())->use_plugin($plg,$params);
		if($plg!=NULL)
			return $plg->get_arc_man($params);
		
		return NULL;
	}
}