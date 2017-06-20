<?php
require_once url_seg_add(__DIR__,"widget.php");

class BaseController
{
	VAR $_JS=array();
	VAR $_CSS=array();
	VAR $_BLOCKS=array();
	VAR $_TITLE="";
	VAR $_LAYOUT;
	VAR $_META=array();
	VAR $_INLINE_SCRIPT='';
	VAR $_INLINE_STYLE='';
	VAR $_RESULT_TYPE="text/html";
	VAR $_CONTROLLER_DIR=NULL; // директория контроллера (заполняется из модуля page)
	VAR $_ENV;
	VAR $_MODEL;
	VAR $_CONNECTION;
	
	function __construct($_env_info=array())
	{
		$this->_CONTROLLER_DIR = $_env_info['_CONTROLLER_DIR'];
		$this->_ENV = $_env_info['_ENV'];
		
		$conn = get_connection();
		if(!empty($conn))
		{
			$this->_CONNECTION = $conn;
			$this->_ENV['_CONNECTION']=$this->_CONNECTION;
		}

		$model_file = url_seg_add($this->get_current_dir(),"model.php");
		if(file_exists($model_file))
		{
			require_once $model_file;
			$thename = $this->get_this_name();
			//echo $thename;
			$model_class_name = "Model".ucfirst(strtolower($thename));
			$model_env = $this->_ENV;
			$model_env['_CONTROLLER']=$this;
			$this->_MODEL = new $model_class_name($this->_CONTROLLER_DIR,$model_env);
		}
	}
	
	public function Rules()
	{
		return array(	
		);
	}
	
	function connect_db($dbparams)
	{
		$res = connect_db($dbparams);
		if(!empty($res))
		{
			$this->_ENV['_CONNECTION']=$res;
		}
	}
	
	function get_this_name()// имя текущего контроллера
	{
		$myclassname = get_class($this);
		$matches=array();
		preg_match("/(.*)Controller/", $myclassname, $matches, PREG_OFFSET_CAPTURE);
		//print_r($matches);
		return $matches[1][0];
	}
	
	function get_current_dir()
	{
		GLOBAL $_EP, $_CONTROLLER, $_ACTION, $_CONFIG, $_BASEDIR;
		//return url_seg_add($_BASEDIR, url_seg_add("conf", url_seg_add($_CONFIG, $_EP)));
		return $this->_CONTROLLER_DIR;
	}
	
	function add_block($area,$controller,$action)
	{
		if(empty($this->_BLOCKS[$area]))
		{
			$this->_BLOCKS[$area]=array();
		}
		
		$this->_BLOCKS[$area][]=array('controller'=>$controller,'action'=>$action);
	}
	
	function getinfo($infodescr)
	{
		$_DATA=NULL;
		$path = url_seg_add($this->_CONTROLLER_DIR,url_seg_add('/../..',"/info/$infodescr.php"));
		if(file_exists($path))
		{
			include $path;
		}
		return $_DATA;
	}
	
	function ActionValidate()
	{
		$res = array();
		if(!empty($this->_MODEL))
		{	
			// валидуем по модели
			$res = $this->_MODEL->validate($_POST);
		}
		$this->out_json($res);
	}
	
	function inline_script($script)
	{
		$this->_INLINE_SCRIPT=$this->_INLINE_SCRIPT.$script;
	}
	
	function inline_css($css)
	{
		$this->_INLINE_STYLE=$this->_INLINE_STYLE.$css;
	}
	
	protected function file_if_relative(&$thefile_name)
	{
		if(substr($thefile_name,0,1)=='#')
		{
			$thefile_name = url_seg_add($this->_CONTROLLER_DIR,strtr($thefile_name,array('#'=>'/')));
		}
	}
	
	function add_js($js)
	{
		$this->file_if_relative($js);
		$this->_JS[]=$js;
	}
		
	// add css
	function add_css($css)
	{
		$this->file_if_relative($css);
		$this->_CSS[]=$css;
	}
	
	// add meta tag
	function add_meta($meta)
	{
		$this->_META[]=$meta;
	}
	
	// add keyword meta
	function add_keyword($kwd)
	{
		foreach ($this->_META as $meta)
		{
			if($meta['name']=='keywords')
			{
				$meta['content']=$meta['content'].",$kwd";
				return ;
			}
		}		
		$this->_META[]=array('name'=>'keywords','content'=>"$kwd");		
	}
	
	function use_plugin($plug)
	{
		
	}
	
	function out_view($view,$vars=array())
	{
		foreach ($vars as $var => $val)
		{
			$$var = $val;
		}
		
		$_view_path = $this->get_view_path($view);
		include $_view_path;
		//url_seg_add($this->get_current_dir(),url_seg_add("/views/",$view)).".php";
				
	}
	
	function out_json($object,$json_opts=JSON_UNESCAPED_UNICODE)
	{
		$this->_RESULT_TYPE="application/json";
		echo json_encode($object);
	}
	
	function draw_controller_request($req)
	{
		$this->_JS = array_merge($this->_JS,$req['js']);
		$this->_CSS = array_merge($this->_JS,$req['css']);
		$this->_META = array_merge($this->_JS,$req['meta']);
		echo $req['content'];
	}
	
	function usewidget($wid_object,$params=array())
	{
	//	ob_start();
		$wid_object->out($params);
	//	$html = ob_end_clean();
		
		$this->_JS = array_merge($this->_JS,$wid_object->_JS);
		$this->_CSS = array_merge($this->_CSS,$wid_object->_CSS);
		$this->_META = array_merge($this->_META,$wid_object->_META);
	//	echo $html;
	}
	
	function redirect($url)
	{
		?>
		<script type="text/javascript">
<!--
	document.location="<?=$url?>";
//-->
</script>
		<?php 
	}
	
	function redirect_back()
	{
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	function get_view_path($view)
	{
		$path_from_theme = $this->_ENV['page_module']->get_template_from_theme($view);
		//echo $path_from_theme;
		if($path_from_theme==NULL)
		{
			$path_native = url_seg_add($this->get_current_dir(),url_seg_add("/views/",$view)).".php";
			return $path_native;
		}
		return $path_from_theme;
	}
	
	function query($controller,$method,$args=array())
	{
		return $this->_ENV['page_module']->controller_request(
				array(
						'controller'=>$controller,
						'method'=>$method,
						'args'=>$args,
					)
				);
	}
	
	function get_controller($controller)
	{
		return $this->_ENV['page_module']->get_controller($controller);
	}
}

