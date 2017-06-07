<?php 
class HmvcController extends BaseController
{
		
	private function ConnectDBIfExists($cfg)
	{
		GLOBAL $_BASEDIR;
		$conffile=url_seg_add($_BASEDIR,"conf",$cfg,"config.php");
		include $conffile;
		
		if(!empty($_MODULES['db']))	// конфа подключена к базе
		{
			
			$this->connect_db($_MODULES['db']);
			
			return $_MODULES['db'];
		}
		return NULL;
	}
	
	public function ActionIndex($cfg='main',$ep='frontend')
	{
		$this->_TITLE="HMVC";
		$this->add_css($this->get_current_dir()."/css/style.css");
		
		$this->add_block('BASE_MENU', 'site', 'menu');
		$this->add_keyword('xxx');
		
		$dbparams = $this->ConnectDBIfExists($cfg);
		if($dbparams!=NULL)	// конфа подключена к базе
		{

			$tables = $this->_ENV['_CONNECTION']->get_tables();
			
			$this->out_view('tables',array('tables'=>$tables,'config'=>$cfg));
		}	
		else 
		{
			$this->out_view('index',array());
		}		
		
		
	}
	
	public function ActionFields($cfg='main',$table)
	{
		$dbparams = $this->ConnectDBIfExists($cfg);
		if($dbparams!=NULL)	// конфа подключена к базе
		{		
			$fields = $this->_ENV['_CONNECTION']->get_table_fields($table);
			$this->out_json($fields);
		}
	}
		
	public function ActionMake($step=1)
	{
		$this->add_block('BASE_MENU', 'site', 'menu');
		
		switch($step){
		case 1: {
					$_SESSION['makeinfo']=array();
				
					$_SESSION['makeinfo'] = array_merge($_SESSION['makeinfo'],$_POST);
					
					$dbparams = $this->ConnectDBIfExists($_POST['conf']);
					
					$fields = $this->_ENV['_CONNECTION']->get_table_fields($_POST['table']);
					$tables = $this->_ENV['_CONNECTION']->get_tables();
					$this->add_js('#js/constraints.js');
					$this->out_view('constraints',array('fields'=>$fields,'tables'=>$tables));
				};break;
		case 2: {
					$_SESSION['makeinfo'] = array_merge($_SESSION['makeinfo'],$_POST);
					$this->make_hmvc();
				};break;
		}
		/*
		 ALTER TABLE crm_projects 
ADD CONSTRAINT `fk_worker` 
FOREIGN KEY (`creator_id`)
REFERENCES `crm_workers` (`id`)
ON DELETE SET NULL
ON UPDATE SET NULL;
		 * */
	}
	
	
	private function make_hmvc()
	{
		GLOBAL $_BASEDIR;
		$conf_dir= url_seg_add($_BASEDIR,"conf");
		
		$dbparams = $this->ConnectDBIfExists($_POST['conf']);
		
		foreach($_POST['ep'] as $ep => $offon)
		{
			$hmvc_dir=url_seg_add($conf_dir,$_POST['conf'],$ep,'hmvc',$_POST['table']);
			//создаем папку триады
			if(!file_exists($hmvc_dir) || !is_dir($hmvc_dir))
			{
				mkdir($hmvc_dir);
			}
			// Контроллер
			$file_controller = url_seg_add( $hmvc_dir,'controller.php'); 
			if(!file_exists($file_controller))
			{
				$vars=array();
				$vars['table_uc_first']=UcaseFirst($_POST['table']);
				$vars['TABLE_UC']=strtoupper($_POST['table']);
				file_put_contents($file_controller, $this->parse_code_template('controller',$vars));
			}
			// Модель
			$file_model = url_seg_add( $hmvc_dir,'model.php');
			if(!file_exists($file_model))
			{
				$vars=array();
				$vars['table_uc_first']=UcaseFirst($_POST['table']);
				$vars['TABLE_UC']=strtoupper($_POST['table']);
				file_put_contents($file_model, $this->parse_code_template('model',$vars));
			}
			// Файлик
			$file_baseinfo= url_seg_add( $hmvc_dir,'baseinfo.php');			
				
				$vars=array();
				$vars['table']=$_POST['table'];
				$tbl_fields = $this->_ENV['_CONNECTION']->get_table_fields($_POST['table']);
			//	print_r($tbl_fields);
				$vars['array_fields']='array('.ximplode(',', array_keys($tbl_fields), "'", "'").')';
				$vars['array_constraints']='array()';
				$vars['array_rules']='array()';
				$_primary = $this->_ENV['_CONNECTION']->get_primary($tbl_fields);
				$vars['primary']=$_primary;
				file_put_contents($file_baseinfo, $this->parse_code_template('baseinfo',$vars));
			
		}
	}
	
	function get_constraints($table)
	{
		$res = $this->_ENV['_CONNECTION']->query(" SELECT * FROM USER_CONSTRAINTS WHERE TABLE_NAME = \"@+{$table}\"");
		$arr=array();
		while($col = $this->_ENV['_CONNECTION']->get_row($res)){
			//	print_r($col);
			
			$arr[$col['Field']]=$col;
			//print_r($col); print "<br>\n";
		}
		return $arr;
	}
	
	function get_primary($var)
	{
		if(is_string($var))
		{
			$var = get_table_fields($var);
		}
		
		foreach($var as $fld => $fld_info )
		{
			if($fld_info['Key']=="PRI")
			{
				return $fld;
			}
		}
	}
	
	function parse_code_template($tpl,$var_array)
	{
		$tpl_file= url_seg_add(__DIR__,"../../phpt",$tpl).".phpt";
		$code = file_get_contents($tpl_file);
		$var_array2=array();
		foreach ($var_array as $var => $val)
		{
			$var_array2['{'.$var.'}']=$val;
		}
		return strtr($code,$var_array2);
	}
	
}
?>