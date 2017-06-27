<?php
class scaff_conf 
{
	VAR $_PATH;
	VAR $_ERROR=false;
	
	function __construct($conf,$opts=array())
	{
		GLOBAL $_BASEDIR;
		def_options(array('conf_dir'=>'conf','rewrite'=>true), $opts);
		$this->_PATH = url_seg_add($_BASEDIR,$opts['conf_dir'],$conf);
		
		if(!file_exists($this->_PATH))
		{
			if($opts['rewrite'])
				x_mkdir($this->_PATH);
		}
		
		if(!file_exists( url_seg_add($this->_PATH,"views") ))
		{
			if($opts['rewrite'])
				x_mkdir(url_seg_add($this->_PATH,"views"));
		}
	}
	
	function connect_db_if_exists($controller)
	{
		GLOBAL $_BASEDIR;
		try
		{
			$conffile=url_seg_add($this->_PATH,"config.php");
			include $conffile;
				
			if(!empty($_MODULES['db']))	// конфа подключена к базе
			{
		
				$controller->connect_db($_MODULES['db']);
		
				return $_MODULES['db'];
			}
			
			return TRUE;
		}
		catch (Exception $exc)
		{
		//	echo "<h4>This configuration does not exists</h4>";
			//die();
			return false;
		}
		return false;
	}
	
	function get_triada($ep,$hmvc)
	{
		if(scaff_triada::exists($this, $ep, $hmvc))
		{
			$triada = new scaff_triada($this,$ep,$hmvc);
			return $triada;
		}
		return null;
	}
	
	function create_triada($ep,$hmvc)
	{
		$tr = $this->get_triada($ep, $hmvc);
		if($tr !=null)
		{
			return $tr;
		}
		else 
		{
			$new_tr = new scaff_triada($this, $ep, $hmvc);
			return $new_tr;
		}
	}
}