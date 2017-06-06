<?php 
class HmvcController extends BaseController
{
		
	public function ActionIndex($cfg='main',$ep='frontend')
	{
		$this->_TITLE="HMVC";
		$this->add_css($this->get_current_dir()."/css/style.css");
		
		$this->add_block('BASE_MENU', 'site', 'menu');
		$this->add_keyword('xxx');
		
//		print_r($this->_ENV);
		GLOBAL $_BASEDIR;
		$conffile=url_seg_add($_BASEDIR,"conf",$cfg,"config.php");
		//echo $conffile;
		include $conffile;
		if(!empty($_MODULES['db']))	// конфа подключена к базе
		{
			//print_r($_MODULES);
			$this->connect_db($_MODULES['db']);
			$tables = $this->get_All_tables($_MODULES['db']);
			$this->out_view('tables',array('tables'=>$tables,'config'=>$cfg));
		}	
		else 
		{
			$this->out_view('index',array());
		}		
		
		
	}
	
	function get_All_tables($db_params)
	{
		$res = $this->_ENV['_CONNECTION']->query("SHOW FULL TABLES");
		$arr=array();
		while($row = $this->_ENV['_CONNECTION']->get_row($res))
		{
			$keys = array_keys($row);
			$tablename = $row[$keys[0]];
			$tablename = substr($tablename,strlen($db_params['prefix']));
			$arr[]= $tablename;
		}
		return $arr;
	}
		
	public function ActionMake()
	{
		
	}
	
}
?>