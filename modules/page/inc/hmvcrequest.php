<?php
class HMVCRequest
{
	VAR $_controller='site';
	VAR $_action='index';
	VAR $_args=array();
	VAR $_fun_map=array();

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
					$req_pieces[]=array('value'=>$varname);
				}
				else
				{
					$req_pieces[$varname]=array('value'=>$varval);
				}
		}

		if(key_exists('controller',$req_pieces))
		{
			$this->_controller = $req_pieces['controller']['value'];
			unset($req_pieces['controller']);
		}
		else
		{
			if(!empty($req_pieces[0]))
			{
				$this->_controller = $req_pieces[0]['value'];
				unset($req_pieces[0]);
			}
		}

		if(key_exists('action',$req_pieces))
		{
			$this->_action= $req_pieces['action']['value'];
			unset($req_pieces['action']);
		}
		else
		{
			if(!empty($req_pieces[1]))
			{
				$this->_action = $req_pieces[1]['value'];
				unset($req_pieces[1]);
			}
		}

		$strparams='';
		foreach($req_pieces as $idx => $val)
		{
			if(is_string($idx))
			{
				$val=$val['value'];
				if($strparams=='')
					$strparams="$idx=$val";
					else
						$strparams=$strparams."&{$idx}={$val}";
						unset($req_pieces[$idx]);
			}
		}


		if(!empty($strparams))
		{
			$parsed = array();
			parse_str($strparams,$parsed);			
			$_result= array_merge($_result,$parsed);
		//	var_dump($_result);
		}
		else
		{
			$_result = array();
			foreach ($req_pieces as $idx => $piece)
			{
				$_result[]=$piece['value'];
			}
			//$_result = $req_pieces;
		}


		$this->_args = array_order_num($_result);
	}
	
	function setmap($map)
	{
		$this->_fun_map=$map;
	}

	function get_alternative()
	{
		$newargs=$this->_args;
		array_insert($newargs, 0, array($this->_action));
		$newreq = new HMVCRequest($this->_controller,'index',$newargs);
		return $newreq;
	}
	
	function delete_arg($argidx)
	{
		if(!empty($this->_args[$argidx]))
		{
			unset($this->_args[$argidx]);
		}
	}

	function url_modified($args_change,$args_delete=array(),$_controller=null,$_action=null)
	{
		if($_controller!=null)
		{
			$newstr=$_controller;
		}
		else
			$newstr=$this->_controller;
		if($this->_action!='index')
		{
			$newstr=url_seg_add($newstr,$this->_action);
		}
		else 
		{
			$newstr=url_seg_add($newstr,$_action);
		}
		
		$newargs=array();
		foreach ($this->_args as $idx => $arg)
		{
			if(!empty($args_delete[$idx]))
				continue;
			if(!empty($args_change[$idx]))
				$newargs[$idx] = $args_change[$idx];
			else 
				$newargs[$idx] = $arg;
		}
		
		//print_r($newargs);
				
		foreach ($this->_fun_map as $fmidx => $fld)
		{
			$newstr=url_seg_add($newstr,$newargs[$fld]);
			unset($newargs[$fld]);
		}
		
		foreach ($newargs as $argidx => $argval)
		{			
			if(is_int($argidx))
			{
				$newstr=url_seg_add($newstr,$argval);
			}
			else 
			{
				$newstr=url_seg_add($newstr,$argidx.":".$argval);
			}
		}
		
		return $newstr;
	}
}

