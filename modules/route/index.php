<?php
// модуль маршрутизатор
define('__request_descr__', 'r');


class owl_route extends owl_Module 
{
	VAR $_DIR_CONFIG;
	VAR $_DIR_EP;
	VAR $_THEME;
	VAR $CFG_INFO;
	VAR $_ENV_INFO=array();
	
	function __construct($_PARAMS)
	{
		
	}
	
	function page_before_out(&$args)	// принимает аргументы  из r
	{
		if(!empty($_REQUEST[__request_descr__]))
		{
			$req = $_REQUEST[__request_descr__];
			
			$_REQUEST=array();
			
			$def_controller='site';
			$def_action='index';
			$req_slices = explode('/', $req);
			$argidx=0;
			$str_varval="";
			foreach ($req_slices as $idx => $slice)
			{
				if(empty($slice)) 
					continue;
				list($varname,$varval)=explode(':',$slice);
				if(empty($varval))
				{
					if($idx==0)
					{
						$_REQUEST['controller']=$slice;
					}
					elseif($idx==1)
					{
						$_REQUEST['action']=$slice;
					}
					else 
					{
						$_REQUEST['args'][$argidx]=$slice;
						$argidx++;
					}
				}
				else 
				{
					if($str_varval!="")
						$str_varval=$str_varval."&";
					$str_varval=$str_varval."{$varname}={$varval}";
					//$_REQUEST[$varname] = $varval;
				}
				//echo "$varname : $varval |";
			}

			if(!empty($str_varval))
			{
				$parsed = array();
				parse_str($str_varval,$parsed);
				$_REQUEST = array_merge($_REQUEST,$parsed);
				//foreach ($parsed as $varname => $varval){}
			}

		}
	}
	
	static function make_url($to_change=array(),$to_delete=array())
	{
		$str = $_REQUEST['controller'];
		if($_REQUEST['action'])
		{
			if($_REQUEST['action']!='index')
				$str = url_seg_add($str,$_REQUEST['action']);
		}
		if(!empty($_REQUEST['args'] ))
		{
			foreach ($_REQUEST['args'] as $arg)
			{
				$str=url_seg_add($str,$arg);
			}
		}
		foreach ($_REQUEST as $key => $var)
		{
			if(!in_array($key, array('controller','action','args')))
			{
				if(!empty($to_change[$key]))
				{
					$val = $to_change[$key]; 
					$str = url_seg_add($str,"$key:$val");
				}
				else 
					$str = url_seg_add($str,"$key:$var");
			}
		}
		return $str;
	}
		
}