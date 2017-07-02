<?php
class scaff_conf 
{
	VAR $_PATH;
	VAR $_ERROR=false;
	VAR $_NAME;
	
	function __construct($conf,$opts=array())
	{
		GLOBAL $_BASEDIR;
		$this->_NAME=$conf;
		def_options(array('conf_dir'=>'conf','rewrite'=>false), $opts);
					
		$this->_PATH = url_seg_add($_BASEDIR,$opts['conf_dir'],$conf);
		
		if(file_exists($this->_PATH) && !$opts['rewrite'] )
			return;
		//mul_dbg(url_seg_add($this->_PATH,'views'));
		
		x_mkdir(url_seg_add($this->_PATH,'views'));
		//GLOBAL $_MUL_DBG_WORK;
		//$_MUL_DBG_WORK=false;
		
		x_mkdir(url_seg_add($this->_PATH,'frontend','views'));		
		x_mkdir(url_seg_add($this->_PATH,'frontend','hmvc'));
		file_put_contents_ifne(url_seg_add($this->_PATH,'frontend','config.php'), '<?php
		
?>');
		x_mkdir(url_seg_add($this->_PATH,'backend','views'));
		x_mkdir(url_seg_add($this->_PATH,'backend','hmvc'));
		file_put_contents_ifne(url_seg_add($this->_PATH,'backend','config.php'), '<?php
$conf = array(
	"sess_user_descriptor"=>"admin",
);
?>');
		x_mkdir(url_seg_add($this->_PATH,'install','views'));
		x_mkdir(url_seg_add($this->_PATH,'install','hmvc'));
		file_put_contents_ifne(url_seg_add($this->_PATH,'install','config.php'), '<?php
		
?>');
		x_mkdir(url_seg_add($this->_PATH,'rest','views'));
		x_mkdir(url_seg_add($this->_PATH,'rest','hmvc'));
		file_put_contents_ifne(url_seg_add($this->_PATH,'rest','config.php'), '<?php
		
?>');
		file_put_contents_ifne(url_seg_add($this->_PATH,'config.php'), '<?php
require_once __DIR__."/dbconf.php";
//$_CACHE_JS=true;
//$_CACHE_CSS=true;


$_MODULES=array(
		"db"=>array(
				"family"=>"mysql",
				"host"=>$_db_server,
				"user"=>$_db_user,
				"passw"=>$_db_passw,
				"dbname"=>$_db_name,
				"prefix"=>$_db_prefix,
				"charset"=>$_db_charset,
				"dbkey"=>"main",
		),		
)
				
?>');
		
		file_put_contents_ifne(url_seg_add($this->_PATH,'dbconf.php'), '<?php 
$_db_server = "localhost";
$_db_user = "root";
$_db_passw = "123456";
$_db_name = "tms2";
$_db_prefix = "crm_";
//$_db_charset = "cp1251_general_ci";
$_db_charset = "utf8_bin";//
?>');
		$this->add_basic_layouts();
	}
	
	function add_basic_layouts()
	{
		$_std_files = get_files_in_folder(url_seg_add(__DIR__,'phpt/std_layouts'));
		$_eps=array('frontend','backend');
		foreach ($_std_files as $idx => $the_std_view )
		{
			foreach ($_eps as $idx2 => $ep)
			{
				$thepath = url_seg_add($this->_PATH, $ep, 'views', basename($the_std_view,".phpt").".php");
				x_file_put_contents($thepath, file_get_contents($the_std_view) );
			}
		}
		
		$backend_views_dir= url_seg_add($this->_PATH,'backend/views');
		x_file_put_contents(url_seg_add($backend_views_dir,'basic_layout.php'), parse_code_template( url_seg_add(__DIR__,'phpt/backend/layout.phpt'),array() ));
		
		$frontend_views_dir= url_seg_add($this->_PATH,'frontend/views');
		x_file_put_contents(url_seg_add($frontend_views_dir,'basic_layout.php'), parse_code_template( url_seg_add(__DIR__,'phpt/basic_layout.phpt'),array()  ));
	
	}
	
	function connect_db_if_exists($controller)
	{
		GLOBAL $_BASEDIR;
		try
		{
			$conffile=url_seg_add($this->_PATH,"config.php");
		//	mul_dbg($conffile);
		
			include $conffile;				
		//	mul_dbg($_MODULES);
			
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