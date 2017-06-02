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
			foreach ($req_slices as $idx => $slice)
			{
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
						$_REQUEST['arg'.$argidx]=$slice;
						$argidx++;
					}
				}
				else 
				{
					$_REQUEST[$varname] = $varval;
				}
				//echo "$varname : $varval |";
			}
		//	print_r($_REQUEST);
		}
	}
	/*
	function get_actions()
	{
		return array('draw');
	}
	*/
}