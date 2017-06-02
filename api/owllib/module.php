<?php 
function module_exists($modname)
{
	global $_MOD_CLASSES;
	foreach ($_MOD_CLASSES as $idx => $mod)
	{
		if($mod->get_mod_name()==$modname)
			return true;
	}			
	return false;
}

function call_modules($module,$eventname)
{
	$args=array();
	global $_MOD_CLASSES;
	$called_list=array();
	foreach ($_MOD_CLASSES as $idx => $mod)
	{
		if(($mod->get_mod_name()!=$module)&&(!in_array($mod,$called_list)))
		{
			call_event($mod,$eventname,$module,$called_list,$args);
		}
	}
	return $args;
}

function call_event($mod,$eventname,$event_src,&$called_list,&$res_of_module)
{
	$waits = $mod->wait_events();
	if(count($waits))
	{
		foreach($waits as $w)
		{
			if(is_array($w))
			{
				if($w['event']==$eventname)
				{
					$req_mod = find_module($w['module']);
				}
			}
			else 
			{
				$req_mod = find_module($w);
			}
			if(!in_array($req_mod, $called_list))
			{
				
				call_event($req_mod, $eventname,$event_src,$called_list,$res_of_module); // вызвать событие от модуля
				
				$called_list[]=$req_mod;
			}
		}
	}
	
	$metodname = "{$event_src}_{$eventname}";
	
	if(method_exists($mod, $metodname))
	{		
		$mod_res=array();
		$mod->$metodname($mod_res);
		$res_of_module[$mod->get_mod_name()]=$mod_res; // записали полученный от модуля результат
		
		$args[$mod->get_mod_name()]=$res_of_module;
		$called_list[]=$mod;
	}
}

function make_event_queue($event,$module_from)
{
	$queue=array();
	foreach ($_MOD_CLASSES as $idx => $mod)
	{
		$waits = $mod->wait_events();
		foreach($waits as $w)
		{
			if(is_array($w))
			{
				if($w['event']==$event)
				{
					$queue[]=$idx;					
				}
			}
			else 
			{
				
			}
		}
	}
}

function find_module($modname)
{
	GLOBAL $_MOD_CLASSES;
	foreach ($_MOD_CLASSES as $idx => $mod)
	{
		if($mod->get_mod_name()==$modname)
		{
			return $mod;
		}
	}
	return null;
}


?>