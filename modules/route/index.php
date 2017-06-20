<?php
// модуль маршрутизатор
define('__request_descr__', 'r');


class HMVCRequest 
{
	VAR $_controller='site';
	VAR $_action='index';
	VAR $_args=array();
	
	function __construct($req_str,$action=NULL,$args=NULL)
	{
		if(($action==NULL)&&($args==NULL))
			$this->from_str($req_str);
		else
		{
			$this->_controller=$req_str;
			$this->_action=$action;
			$this->_args=$args;
		}
			
	}
	
	function from_str($req_str)
	{
		$_result=array();
		
		$def_controller='site';
		$def_action='index';
		$req_slices = explode('/', $req_str);
		$argidx=0;
		$str_varval="";
		
		$req_pieces=array();
		foreach ($req_slices as $idx => $slice)
		{
			if(empty($slice))
				continue;
			list($varname,$varval)=explode(':',$slice);
			if(empty($varval))
			{
				$req_pieces[]=$varname;
			}
			else 
			{
				$req_pieces[$varname]=$varval;
			}
		}
				
		if(key_exists('controller',$req_pieces))
		{
			$this->_controller = $req_pieces['controller'];
			unset($req_pieces['controller']);
		}
		else 
		{
			if(!empty($req_pieces[0]))
			{
				$this->_controller = $req_pieces[0];
				unset($req_pieces[0]);
			}
		}
		
		if(key_exists('action',$req_pieces))
		{
			$this->_action= $req_pieces['action'];
			unset($req_pieces['action']);
		}
		else
		{
			if(!empty($req_pieces[1]))
			{
				$this->_action = $req_pieces[1];
				unset($req_pieces[1]);
			}
		}
		
		$strparams='';
		foreach($req_pieces as $idx => $val)
		{
			if(is_string($idx))
			{
				if($strparams=='')
					$strparams="$idx=$val";
				else
					$strparams=$strparams."&{$idx}={$val}";
				unset($req_pieces[idx]);
			}
		}
	
		
		if(!empty($strparams))
		{
			$parsed = array();
			parse_str($strparams,$parsed);
			$_result= array_merge($_result,$parsed);
		}
		else 
		{
			$_result = $req_pieces;
		}
		
		
		$this->_args = $_result;
	}

	function get_alternative()
	{
		$newargs=$this->_args;
		array_insert($newargs, 0, array($this->_action));
		$newreq = new HMVCRequest($this->_controller,'index',$newargs);
		return $newreq;
	}
}

class mul_route extends mul_Module 
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
		
	}
	
	static function get_alternative_request($req_obj)
	{
		
	}
	
	static function parse_request($req_str)
	{

		$_result=array();
			
		$def_controller='site';
		$def_action='index';
		$req_slices = explode('/', $req_str);
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
							$_result['controller']=$slice;
						}
						elseif($idx==1)
						{
							$_result['action']=$slice;
						}
						else
						{
							$_result['args'][$argidx]=$slice;
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
			$_result= array_merge($_result,$parsed);
		}
		
		return $_result;
	}
	
	static function make_url($_query_hash,$to_change=array(),$to_delete=array())
	{
		$str = $_query_hash['controller'];
		if($_query_hash['action'])
		{
			if($_query_hash['action']!='index')
				$str = url_seg_add($str,$_REQUEST['action']);
		}
		if(!empty($_query_hash['args'] ))
		{
			foreach ($_query_hash['args'] as $arg)
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