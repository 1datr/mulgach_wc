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
		file_put_contents_ifne(url_seg_add($this->_PATH,'frontend','views/basic_layout.php'), parse_code_template(  url_seg_add(__DIR__,'/phpt/views/basic_layout.phpt') , []) );
		file_put_contents_ifne(url_seg_add($this->_PATH,'frontend','views/error_layout.php'), parse_code_template(  url_seg_add(__DIR__,'/phpt/views/error_layout.phpt') , []) );
		file_put_contents_ifne(url_seg_add($this->_PATH,'frontend','views/layout_login.php'), parse_code_template(  url_seg_add(__DIR__,'/phpt/views/layout_login.phpt') , []) );
		
		x_mkdir(url_seg_add($this->_PATH,'frontend','hmvc'));
		file_put_contents_ifne(url_seg_add($this->_PATH,'frontend','config.php'), '<?php
		
?>');
		
		x_mkdir(url_seg_add($this->_PATH,'backend','views'));
		file_put_contents_ifne(url_seg_add($this->_PATH,'backend','views/basic_layout.php'), parse_code_template(  url_seg_add(__DIR__,'/phpt/views/basic_layout.phpt') , []) );
		file_put_contents_ifne(url_seg_add($this->_PATH,'backend','views/error_layout.php'), parse_code_template(  url_seg_add(__DIR__,'/phpt/views/error_layout.phpt') , []) );
		file_put_contents_ifne(url_seg_add($this->_PATH,'backend','views/layout_login.php'), parse_code_template(  url_seg_add(__DIR__,'/phpt/views/layout_login.phpt') , []) );
		
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
		file_put_contents_ifne(url_seg_add($this->_PATH,'install','views/basic_layout.php'), parse_code_template(  url_seg_add(__DIR__,'/phpt/install/view/basic_layout.phpt') , []) );
		file_put_contents_ifne(url_seg_add($this->_PATH,'install','views/error_layout.php'), parse_code_template(  url_seg_add(__DIR__,'/phpt/views/error_layout.phpt') , []) );
		
		x_mkdir(url_seg_add($this->_PATH,'rest','hmvc'));
		file_put_contents_ifne(url_seg_add($this->_PATH,'rest','config.php'), '<?php
		
?>');
		file_put_contents_ifne(url_seg_add($this->_PATH,'config.php'), 
			parse_code_template( url_seg_add(__DIR__,'phpt/config.phpt'),array() ) );		
		$this->add_basic_layouts();
		
		$this->make_def_controller();
	}
	
	public function get_config_code()
	{
		$conf_file = url_seg_add($this->_PATH,'config.php');
		if(file_exists($conf_file))
			return file_get_contents($conf_file);
		return "";
	}
	
	public function get_db_conf_code()
	{
		$conf_file = url_seg_add($this->_PATH,'dbconf.php');
		if(file_exists($conf_file))
			return file_get_contents($conf_file);
			return "";
	}
	
	function get_triads($_the_ep=NULL)
	{		
		$eps=array('frontend','backend','install','rest');
		$res=array();
		foreach ($eps as $_ep)
		{
			if( ($_the_ep==NULL) || ($_ep===$_the_ep))
			{
				$ep_dir=url_seg_add($this->_PATH,$_ep,'hmvc');					
				
				if(file_exists($ep_dir))
				{
					
					$hmvcs = get_files_in_folder($ep_dir,array('dirs'=>true,'basename'=>true));
					
					$res[$_ep]=$hmvcs;
				}
			}
		}
		if($_the_ep!=NULL)
		{
			return $res[$_the_ep];
		}
		return $res;
	}
	
	public function set_db_conf_code($code)
	{
		$conf_file = url_seg_add($this->_PATH,'dbconf.php');
		file_put_contents($conf_file,$code);
		
	}
	
	function make_def_controller()
	{
		$tr = $this->get_triada('frontend', 'site');
		if($tr==NULL)
		{
			$site_controller = $this->create_triada('frontend', 'site');
			$site_controller->make_base();
		}
		
		$tr = $this->get_triada('backend', 'site');
		if($tr==NULL)
		{
			$site_controller = $this->create_triada('backend', 'site');
			$site_controller->make_base();
		}
		
		$tr = $this->get_triada('install', 'site');
		if($tr==NULL)
		{
			$site_controller = $this->create_triada('install', 'site');
			$site_controller->make_base();
		}
		
		$tr = $this->get_triada('rest', 'site');
		if($tr==NULL)
		{
			$site_controller = $this->create_triada('rest', 'site');
			$site_controller->make_base();
		}
	}
	
	static function set_current_cfg($_cfg)
	{
		global $_BASEDIR;
		$conf_file= url_seg_add($_BASEDIR,'config.php');
		$conf_content = file_get_contents($conf_file);
		$preg_expr = <<<'EOT'
#\$_CONFIG\s*=\s*(\'.+\')|(\".+\")#
EOT;
		$_matches=[];
		preg_match_all($preg_expr, $conf_content, $_matches);
		$cfg_str = "\$_CONFIG ='$_cfg'";		
EOT;
		$conf_content = preg_replace($preg_expr, $cfg_str, $conf_content);
		file_put_contents($conf_file, $conf_content);
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
			//mul_dbg($conffile);
		
			include $conffile;				
		//	
			
			if(isset($_MODULES['db']))	// конфа подключена к базе
			{
				$result = $controller->connect_db($_MODULES['db']);
				
				//GLOBAL $_MUL_DBG_WORK;
				//print_r($_MODULES['db']);
				
				return $_MODULES['db'];
			}
			
			return null;
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