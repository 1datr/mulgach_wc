<?php
require_once url_seg_add(__DIR__,"widget.php");

class BaseController
{
	VAR $_JS=array();
	VAR $_CSS=array();
	VAR $_BLOCKS=array();
	VAR $_TITLE="";
	VAR $_LAYOUT='basic_layout.php';
	VAR $_META=array();
	VAR $_INLINE_SCRIPT='';
	VAR $_INLINE_STYLE='';
	VAR $_RESULT_TYPE="text/html";
	VAR $_CONTROLLER_DIR=NULL; // директория контроллера (заполняется из модуля page)
	VAR $_ENV;
	VAR $_MODEL;
	VAR $_HEADERS=NULL;
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
	
	public function UseModel($model_settings=array())
	{
		$model_env = $this->_ENV;
		$model_env['_CONTROLLER']=$this;		
		$_model = new BaseModel($this->_CONTROLLER_DIR,$model_env);
		$_model->_SETTINGS=$model_settings;
		$this->_MODEL = $_model;
		return $this->_MODEL;
	}
	
	public function Rules()
	{
		return array(	
		);
	}
	
	function CallEvent($eventname, $eparams=[])
	{
		$res = $this->_ENV['page_module']->call_event($eventname, $eparams,['src'=>'controller']);
		return $res;
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
	
	function get_image($img)
	{
		$controller_dir = $this->get_current_dir();
		return filepath2url(url_seg_add($controller_dir,$img));
	}
	
	function get_current_dir()
	{
		GLOBAL $_EP, $_CONTROLLER, $_ACTION, $_CONFIG, $_BASEDIR;
		//return url_seg_add($_BASEDIR, url_seg_add("conf", url_seg_add($_CONFIG, $_EP)));
		return $this->_CONTROLLER_DIR;
	}
	
	function get_ep_param($key)
	{
		return $this->_ENV['page_module']->get_ep_conf_param($key);
	}
	
	function get_user_descriptor()
	{
		return $this->get_ep_param('sess_user_descriptor');
	}
	
	function get_user_info($param=NULL)
	{
		$descr = $this->get_user_descriptor();
		if(isset($_SESSION[$descr]))
		{
			if($param==NULL)
				return $_SESSION[$descr];
			else 
			{
				if(isset($_SESSION[$descr][$param]))
					return $_SESSION[$descr][$param];
				
				return NULL;
			}
		}
		return NULL;
	}
	
	function logout()
	{
		$userinfo = $_SESSION[$this->get_user_descriptor()];
		$this->BeforeLogout($userinfo);
		unset($_SESSION[$this->get_user_descriptor()]);
		$this->AfterLogout($userinfo);
	}
	
	function BeforeAction(&$params)
	{

	}
	
	function AfterAction(&$params)
	{
	
	}
	
	function BeforeLogout($userinfo)
	{
	
	}
	
	function AfterLogout($userinfo)
	{
		
	}
	
	function add_block($area,$controller,$action=NULL,$args=array())
	{
		if(empty($this->_BLOCKS[$area]))
		{
			$this->_BLOCKS[$area]=array();
		}
		
		if($action==NULL)
			$this->_BLOCKS[$area][]=array($controller);
		else
			$this->_BLOCKS[$area][]=array('controller'=>$controller,'action'=>$action,'args'=>$args);
	}
	
	function IsActionEnable($_action,$user=NULL)
	{
		if($_action=='error')
			return true;
		$res = true;
		$rules=$this->Rules();
		if(!empty($rules['action_access']))
		{
			foreach ($rules['action_access'] as $idx => $rule)
			{
				$rule_res = $rule->calc_for($this,$_action);
				$res = $res && $rule_res;
			}
		}
		return $res;
	}
	
	public function getActions()
	{
		$methods = get_class_methods(get_class($this));
		$methodlist=array();
		$method_not_to_include=array('validate','error');
		foreach($methods as $method)
		{
			$matches = array();
			preg_match_all('/^Action(.+)$/Uis', $method, $matches);
			$newmethod = mb_strtolower($matches[1][0]);
			if(($newmethod=='') || ( in_array($newmethod,$method_not_to_include)))
				continue;
			if(!in_array($newmethod,$methodlist))
				{
					$methodlist[]=$newmethod;
				}
	
		}
		return $methodlist;
	}
	
	public function ActionError($ErrorNo)
	{
		$this->use_layout('error_layout');
		$this->_TITLE = "#{ERROR} ".$ErrorNo;
		$this->out_view('error'.$ErrorNo,array());
		//echo "<h3>".Lang::__t('Error').' '.$ErrorNo."</h3>";
	}
	
	public function ActionUploadfile()
	{
		$filemap = $this->_MODEL->UploadfilesTemp();
		$this->out_json($filemap);
		//mul_dbg($_FILES);
		//mul_dbg($_POST);
		
	}
	
	public function ActionGetprogress()
	{
		
	}
	
	public function ActionStopupload()
	{
	
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
	
	function _POST($key)
	{
		if($_POST[$key])
			return $_POST[$key];
		else 
			return NULL;
	}
	
	function ActionValidate()
	{				
		$res = array();
		if(!empty($this->_MODEL))
		{	
			// валидуем по модели
			$therow = $_POST[$this->_MODEL->_TABLE];
			$this->CallEvent('BeforeValidate', ['controller'=>$this,'row'=>$therow,'res'=>&$res]);
			$res = $this->_MODEL->validate($_POST);
			$this->CallEvent('AfterValidate', ['controller'=>$this,'row'=>$therow,'res'=>&$res]);
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
	
	// переключить лейаут
	function use_layout($newlayout)
	{
		//echo url_seg_add(__DIR__,'../../views',"{$newlayout}.php");
		if( file_exists(url_seg_add($this->get_current_dir(),'../../views',"{$newlayout}.php")) )
			$this->_LAYOUT=$newlayout.'.php';
	}
	
	function out_view($view,$vars=array())
	{
		foreach ($vars as $var => $val)
		{
			$$var = $val;
		}
		
		$_view_path = $this->get_view_path($view);
		if($this->get_ep_param('print_template_path'))
		echo "<!-- {$_view_path} -->";
		include $_view_path;
		//url_seg_add($this->get_current_dir(),url_seg_add("/views/",$view)).".php";
				
	}
	
	function x_out_view($view,$vars=array())
	{
		foreach ($vars as $var => $val)
		{
			$$var = $val;
		}
	
		$_view_path = $this->get_view_path($view);
		if(!file_exists($_view_path))
			x_file_put_contents($_view_path, '
');
		include $_view_path;
		//url_seg_add($this->get_current_dir(),url_seg_add("/views/",$view)).".php";
	
	}
	
	function out_json($object,$json_opts=JSON_UNESCAPED_UNICODE)
	{
		$this->_RESULT_TYPE="application/json";
		echo json_encode($object);
	}
		
	function out_ajax_block($view,$vars=array())
	{
		foreach ($vars as $var => $val)
		{
			$$var = $val;
		}
	
		$_view_path = $this->get_view_path($view);
		if($this->get_ep_param('print_template_path'))
			echo "<!-- {$_view_path} -->";
		
		ob_start();
		include $_view_path;
		$str = ob_get_clean();
		
		$obj_json = array('html'=>$str,'js'=>$this->_JS,'css'=>$this->_CSS);
			//url_seg_add($this->get_current_dir(),url_seg_add("/views/",$view)).".php";
		$this->_RESULT_TYPE="application/json";
		echo json_encode($obj_json);
	}
	
	function draw_controller_request($req)
	{
		$this->_JS = array_merge($this->_JS,$req['js']);
		$this->_CSS = array_merge($this->_JS,$req['css']);
		$this->_META = array_merge($this->_JS,$req['meta']);
		echo $req['content'];
	}
	
	function getRequest()
	{
		return $this->_ENV['page_module']->_REQUEST;
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
	//	echo ">>{$path_from_theme} {$view} >>";
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
	
	// для блоб-полей
	public function ActionGetblob($primary_id,$blobfld)
	{
		
	}
	
	
}

class AuthController extends BaseController 
{
	
	public function ActionLogin()
	{
		$this->_TITLE=Lang::__t('Authorization');
		$this->use_layout('layout_login');
		$this->out_view('login',array());
	}
	
	public function ActionAuth()
	{
		$auth_res = $this->_MODEL->auth($_POST['login'],$_POST['passw']);
		if($auth_res!=false)
		{
			$user_descr = $this->get_ep_param('sess_user_descriptor');
			$_SESSION[$user_descr] = $auth_res;
			$this->redirect('?r=workers/');
		}
		else 
		{
			echo "#{BAD AUTORIZATION}";
		}
	}
	
	public function ActionLogout()
	{
		$user_descr = $this->get_ep_param('sess_user_descriptor');
		unset($_SESSION[$user_descr]);
		$this->redirect_back();
	}
}
