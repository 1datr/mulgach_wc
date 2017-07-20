<?php
session_start();
// модуль страница
$inc_files = get_files_in_folder( url_seg_add(__DIR__,'/inc/'));
foreach ($inc_files as $inc_module)
{
	require_once $inc_module;
}

$_EP_PATH = NULL;



class mul_page extends mul_Module 
{
	VAR $_DIR_CONFIG;
	VAR $_DIR_EP;
	VAR $_THEME;
	VAR $CFG_INFO;
	VAR $_ENV_INFO=array();
	
	VAR $CONF_BASE=array();
	VAR $CONF_EP=array();
	VAR $theme_obj;
	VAR $_REQUEST=NULL;
	
	
	function __construct($_PARAMS)
	{
		
	}
	
	function get_actions()
	{
		return array('draw');
	}
	// инфо о том где лежит текущий контроллер
	function controller_info($_CONTROLLER=NULL, $_ACTION=NULL)
	{
		GLOBAL $_EP;
		if($_CONTROLLER==NULL)
		{
			GLOBAL $_CONTROLLER;
		}
		if($_ACTION==NULL)
		{
			GLOBAL $_ACTION;
		}
		GLOBAL $_CONFIGS_AREA, $_CONFIG, $_BASEDIR;
		
		$res = array(
			'_DIR_CONFIG' => dir_dotted(url_seg_add($_CONFIGS_AREA,$_CONFIG)),
			'_ACTION_NAME' => $_ACTION,
		);
				
		$_CONTROLLER_SLICES=explode('.', $_CONTROLLER);
		
		if(count($_CONTROLLER_SLICES)>1)	// секция
		{
			$_CONTROLLER=strtr($_CONTROLLER,array('.'=>'/'));
			$res['_DIR_EP'] = dir_dotted(url_seg_add($res['_DIR_CONFIG'], $_EP));
			$res['_DIR_SECTION'] = dir_dotted(url_seg_add($res['_DIR_CONFIG'], url_seg_add( url_seg_add('sections',$_CONTROLLER_SLICES[0]),$_EP)));
			$res['_CONTROLLER_NAME']=$_CONTROLLER_SLICES[1];
			$res['_DIR_CONTROLLER'] = dir_dotted(url_seg_add($res['_DIR_SECTION'],"/hmvc/".$res['_CONTROLLER_NAME']));
			
		}
		else 				// 
		{
			$res['_DIR_EP'] = dir_dotted(url_seg_add($res['_DIR_CONFIG'], $_EP));
			$res['_CONTROLLER_NAME']=$_CONTROLLER;
			$res['_DIR_CONTROLLER'] = dir_dotted(url_seg_add($res['_DIR_EP'],"/hmvc/{$_CONTROLLER}"));
		}
		$res['_CONTROLLER_CLASS'] = strtoupper(substr($res['_CONTROLLER_NAME'],0,1)).substr($res['_CONTROLLER_NAME'],1,strlen($res['_CONTROLLER_NAME'])-1)."Controller";
		$res['_CONTROLLER_FILE']=url_seg_add( $res['_DIR_CONTROLLER'],"controller.php");
		$res['_ACTION'] = "Action".strtoupper(substr($_ACTION,0,1)).substr($_ACTION,1,strlen($_ACTION)-1);	
		
	//	print_r($res);
		
		return $res;
	}
	
	function out_map($js_arr,$map_file)
	{
		$code=$this->get_assoc_array_code($js_arr);
		$code ="<?php
		\$_cache_files = {$code}
		?>";
		file_put_contents($map_file, $code);
	}
	// вывести javascript
	function draw_js($block)
	{
		GLOBAL $_EP, $_CONTROLLER, $_ACTION, $_THEME;
		GLOBAL $_CONFIGS_AREA, $_CONFIG, $_BASEDIR;
		
		$cache_dir = url_seg_add(__DIR__,"cache/js");
		$map_file = url_seg_add($cache_dir, "map.php");
		if(!file_exists($map_file))		// нет карты - создаем
		{
			$newfile_path=time().".js";
			$arr=array($block=>$newfile_path);
			$this->out_map($arr,$map_file);
			
		}
		
		include $map_file;
		if(empty($_cache_files[$block]))	// добавляем ссылку на файл в карту
		{
			$newfile_path=time().".js";
			$arr=array($block=>$newfile_path);
			$this->out_map($arr,$map_file);
			include $map_file;
		}

		$filename= url_seg_add( $cache_dir, $_cache_files[$block]);
		
		if(!file_exists($filename))	// файла нет
		{
			$files=explode(";", $block);
			$str="";
			foreach ($files as $thefile)
			{
				$str=$str."
".file_get_contents( dir_dotted($thefile));
			}
			file_put_contents($filename, $str);
		}
		
		header("Content-Type: script/javascript");
		echo file_get_contents($filename);
	}
	
	function get_assoc_array_code($arr)
	{
		$code="array(";
		foreach ($arr as $idx => $val )
		{
			if(is_string($idx))
			{
				$newstr="'$idx'=>'$val',";
			}
			else 
			{
				$newstr="$idx=>'$val',";
			}
			$code=$code.$newstr;
		}
		$code=$code.")";
		return $code;
	}
	// вывести css	
	function draw_css($block)
	{
		GLOBAL $_EP, $_CONTROLLER, $_ACTION, $_THEME;
		GLOBAL $_CONFIGS_AREA, $_CONFIG, $_BASEDIR;
		
		$cache_dir = url_seg_add(__DIR__,"cache/css");
		$map_file = url_seg_add($cache_dir, "map.php");
		if(!file_exists($map_file))		// нет карты - создаем
		{
			$newfile_path=time().".css";
			$arr=array($block=>$newfile_path);
			$this->out_map($arr,$map_file);
			
		}
		
		include $map_file;
		if(empty($_cache_files[$block]))	// добавляем ссылку на файл в карту
		{
			$newfile_path=time().".css";
			$arr=array($block=>$newfile_path);
			$this->out_map($arr,$map_file);
			include $map_file;
		}

		$filename= url_seg_add( $cache_dir, $_cache_files[$block]);
		
		if(!file_exists($filename))	// файла нет
		{
			$files=explode(";", $block);
			$str="";
			foreach ($files as $thefile)
			{
				$str=$str."
".file_get_contents( dir_dotted($thefile));
			}
			file_put_contents($filename, $str);
		}
		
		header("Content-type: text/css");
		echo file_get_contents($filename);
		
	}
	
	function get_ep_conf_param($param)
	{
		if(isset($this->CONF_EP[$param]))
		{
			return $this->CONF_EP[$param];
		}
		return NULL;
	}
	
	function inc_ep_config($conf_info)
	{
		include url_seg_add($conf_info['_DIR_EP'],"/config.php");
			
		$this->CONF_EP = $conf;
		
		def_options(array(
				'_HTML_CHARSET'=>'utf-8',
				'_FAVICO'=>'favico.ico',
				'_FAVICO_FORMAT'=>"image/x-icon",
				'_APPLE_TOUCH_ICONS'=>array(),
				'sess_user_descriptor'=>'user',
				'_URL_FORMAT'=>'folder_like',
				'print_template_path'=>false,
		), $this->CONF_EP);
		
		// фавико привязать к директории
		GLOBAL $_BASEDIR;
		
		//include url_seg_add($this->_DIR_EP,"/config.php");
			
		$conf_url =	url_seg_add($_BASEDIR,$_CONFIGS_AREA);
		
		$ico_file_path = url_seg_add($this->_DIR_EP,$this->CONF_EP['_FAVICO']);
		$ico_file_ref = filepath2url($ico_file_path);
		if(file_exists($ico_file_path))
			$this->CONF_EP['_FAVICO']=$ico_file_ref;
		
		if(empty($this->CONF_EP['_APPLE_TOUCH_ICONS']))
			$this->CONF_EP['_APPLE_TOUCH_ICONS']=array($this->CONF_EP['_FAVICO']);
		
		if(!empty($this->CONF_EP['_THEME']))
		{
			$this->_THEME=$this->CONF_EP['_THEME'];
			$this->theme_obj = $this->get_theme($this->_THEME);
			
			if(!empty($this->theme_obj->_CONFIG['_FAVICO']))
			{
				$this->CONF_EP['_FAVICO'] = url_seg_add("/",$this->theme_obj->_CONFIG['_FAVICO']);
			}
			
			if(!empty($this->theme_obj->_CONFIG['_FAVICO_FORMAT']))
			{
				$this->CONF_EP['_FAVICO_FORMAT'] = $this->theme_obj->_CONFIG['_FAVICO_FORMAT'];
			}
			
			$this->CONF_EP['_APPLE_TOUCH_ICONS'] = $this->theme_obj->_CONFIG['_APPLE_TOUCH_ICONS'];
			if(empty($this->CONF_EP['_APPLE_TOUCH_ICONS']))
				$this->CONF_EP['_APPLE_TOUCH_ICONS'] = array($this->CONF_EP['_FAVICO']);
		}			
				
	}
	
	function draw()
	{
		$event_res = array();
		// вызвать событие в модулях
		$res = call_modules($this->get_mod_name(),'before_out',$event_res);
		
		if(!empty($_REQUEST['jsblock']))	// блок js-файлов
		{
			$this->draw_js($_REQUEST['jsblock']);
			die();	
		}
		
		if(!empty($_GET['post_ser']))
		{
			$_POST = get_ser($_GET['post_ser']);
			unset($_GET['post_ser']);
		}
		
		if(!empty($_REQUEST['cssblock']))	// блок css-файлов
		{
			$this->draw_css($_REQUEST['cssblock']);
			die();
		}
		
		GLOBAL $_EP, $_CONTROLLER, $_ACTION, $_THEME;
		GLOBAL $_CONFIGS_AREA, $_CONFIG, $_BASEDIR;
		if(empty($_EP))
			$_EP="frontend";	
		
		/*		CSRF CONTROL
		if(!empty($_POST))
		{
			if(! mulForm::check_form($_POST))
			{
				echo ":: ERRORR :::";
				$this->Error(403);
			}
		}
		*/
			
		$this->_DIR_CONFIG = url_seg_add($_CONFIGS_AREA,$_CONFIG); // директория конфигурации		
		
		$this->_DIR_EP = url_seg_add($this->_DIR_CONFIG, $_EP);	// директория точки входа
			
		//echo $this->_DIR_EP;
		
		GLOBAL $_EP_PATH; 
		$_EP_PATH = $this->_DIR_EP;
		
		$conf_info = $this->controller_info();
		$this->CFG_INFO = $conf_info;

		$this->inc_ep_config($conf_info);
		
		if(isset($_REQUEST['srv'])) 
			return;
			
		if(empty($_REQUEST['r'])) $_REQUEST['r']='';
		
		$info = $this->hmvc_request($_REQUEST['r']);

		//$info = $this->call_action($conf_info,$_REQUEST['args']);
		if(!$info['ok'])
		{
			//print_r($info);
			$this->Error($info['error']);
		}
		else 
		{
			$_MODE_HTML = true;
			if($info['_RESULT_TYPE']=='text/html')
			{
				$this->draw_html($info);
			}
			else 
			{
				header("Content-type: ".$info['_RESULT_TYPE']);
				echo $info['content'];
			}
		}
	}
	
	function hmvc_request($reqstr)
	{
		$this->_REQUEST = new HMVCRequest($reqstr);
		//print_r($req_obj);
		$con_info = $this->controller_info($this->_REQUEST->_controller,$this->_REQUEST->_action);
		$info = $this->call_action($con_info,$this->_REQUEST);
		
	//	print_r($this->_REQUEST);
		
		if(!$info['ok'] && empty($info['notry']))
		{
			//print_r($info);
			
			$this->_REQUEST = $this->_REQUEST->get_alternative();
			
			//print_r($this->_REQUEST);
			
			$con_info= $this->controller_info($this->_REQUEST->_controller,$this->_REQUEST->_action);
			$info = $this->call_action($con_info,$this->_REQUEST);
			if(!$info['ok'])
			{
				$this->Error($info['error']);
			}
			else 
			{
				
			
			}
		//	print_r($info);
		}
		else 
		{
			//return $info;
		
		}
	//	print_r($con_info);
		return $info;
	}
	
	function draw_html($info)
	{
		$_CSS=array();
		$_JS=array(
							
		);
		$_META=array();
		
		$event_res = array();
		// вызвать событие в модулях
		$res = call_modules($this->get_mod_name(),'before_html',$event_res);
		//print_r($res);
		foreach($res as $module => $res_item)
		{
			if(!empty($res_item['CSS']))
			{
				$_CSS = merge_arrays($_CSS, $res_item['CSS']);
			}
		
			if(!empty($res_item['JS']))
			{
				$_JS = merge_arrays($_JS, $res_item['JS']);
				
				
			}
		
			if(!empty($res_item['META']))
			{
				$_META = merge_arrays($_META, $res_item['META']);
			}
		}
		ob_start();
		?>
		<html>
		<head>
		<?php 

					//$ico_file_path = url_seg_add("./",url_seg_add($this->_DIR_EP ,$_FAVICO));
					if(!empty($this->CONF_EP['_FAVICO']))
					{
						?>
						<link href="<?=$this->CONF_EP['_FAVICO']?>" rel='shortcut icon' type="<?=$this->CONF_EP['_FAVICO_FORMAT']?>"/>
						<link href="<?=$this->CONF_EP['_FAVICO']?>" rel='icon' type="<?=$this->CONF_EP['_FAVICO_FORMAT']?>"/>
						<?php 
					}
					
					//mul_dbg($this->CONF_EP);
					
					if(is_array($this->CONF_EP['_APPLE_TOUCH_ICONS']))
					{
						foreach ($this->CONF_EP['_APPLE_TOUCH_ICONS'] as $idx => $icofile)
						{
							$size_code="";
							if(is_string($idx))
							{
								$size_code="size=\"{$idx}\"";
							}
							?>
							<link rel="apple-touch-icon" <?=$size_code?>  href="<?=$icofile?>"/>
							<?php 
						}
					}
		
					$_LAYOUT_INFO = $this->get_layout($info);
			
					// ввод css
					global $_CACHE_CSS;
					if(empty($_CACHE_CSS)) $_CACHE_CSS = false;
					$_CSS=merge_arrays($_CSS, $info['css']);
					$_CSS=merge_arrays($_CSS,$_LAYOUT_INFO['css']);
					$_CSS=merge_arrays($_CSS,array(filepath2url(url_seg_add(__DIR__,'css/base.css'))));
					
					$this->out_css($_CSS,$_CACHE_CSS);
					
					
					// вывод скриптов
					$_JS=merge_arrays($_JS, $info['js']);
					$_JS=merge_arrays($_JS,$_LAYOUT_INFO['js']);
					$_JS=merge_arrays($_JS,array(filepath2url(url_seg_add(__DIR__,'js/validate.js'))));
					
					global $_CACHE_JS;
					if(empty($_CACHE_JS)) $_CACHE_JS = false;
					$this->out_js($_JS,$_CACHE_JS);
					
					if(!empty($info['title']))
					{
						?><TITLE><?=$info['title']?></TITLE><?php 
					}
					
					$_BODY_MAIN=$info['content'];
					// блоки 
					if(!empty($info['_BLOCKS']))
					{
						foreach($info['_BLOCKS'] as $position => $items)
						{
							//print_r($items);
							foreach ($items as $item )
							{
								$varname="_BLOCK_".$position;
								if(is_array($item))
								{
									$block_con_info=$this->controller_info($item['controller'], $item['action']);
									$block_req = new HMVCRequest($item['controller'], $item['action'], $item['args']);
									$_info=$this->call_action($block_con_info,$block_req);
									
								}
								else 
								{
									$_info=$this->hmvc_request($item);
								}
								$$varname=$$varname.$_info['content'];
							}
						}
					}
												
					?>
					<meta http-equiv="Content-Type" content="text/html; charset=<?=$this->CONF_EP['_HTML_CHARSET']?>" />
					<?php 
					$_META=merge_arrays($_META, $info['meta']);
					
					foreach($_META as $meta)
					{
						echo "<meta ";
						foreach ($meta as $key => $val)
						{
							echo " $key=\"$val\"";
						}
						echo " />";
					}
		
					if(!empty($info['_INLINE_SCRIPT']))
					{
						?>
						<script  type="text/javascript" >
						<?=$info['_INLINE_SCRIPT']?>
						</script>
						<?php 
					}
					
					if(!empty($info['_INLINE_CSS']))
					{
						?>
						<style  type="text/css" >
						<?=$info['_INLINE_CSS']?>
						</style>
						<?php 
					}
					?>
		</head>
		<body>
		<?php 
					
		include $_LAYOUT_INFO['basic_layout'];
		?>
		</body>
		</html>
		<?php 
		$the_content = ob_get_clean();
		$the_content =	Lang::translate_str($the_content);
		echo $the_content;
	}
	
	function get_theme($theme)
	{
		$found=false;
		
		//	echo ":: $_THEME ::";		
		$themes = XTheme::find($theme,$this->CFG_INFO['_DIR_CONFIG']);
		if(count($themes)>0)
		{
			return new XTheme($themes[0]);				
		}				
		
		return NULL;
					
	}
	
	function get_template_from_theme($page_path)
	{
		if(empty($this->theme_obj))
			return $this->theme_obj;
		return $this->theme_obj->get_view($page_path);
	}
	
	function get_layout($info)
	{
		GLOBAL $_THEME;
		$layout_info=array();
		$found=false;
		if(!empty($this->theme_obj))
		{
			$thefile = url_seg_add($this->theme_obj->_PATH,$info['basic_layout']);
			if(file_exists($thefile))
			{
				$layout_info['basic_layout']= $thefile;
				$layout_info['css']=$theme->_CONFIG['css'];
				$layout_info['js']=$theme->_CONFIG['js'];
				$found=true;
			}
		}		
		
		if($found==false)
		{								
			$_BASE_LAYOUT= url_seg_add($this->_DIR_EP,"/views/",$info['basic_layout']);
		/*	if(empty($info['basic_layout']))
			{*/
			$layout_info['basic_layout']=$_BASE_LAYOUT;
			//}
		}
				
		return $layout_info;
	}
	
	// вывести javascript
	function out_css($_CSS,$cachemode=true)
	{
		GLOBAL $_BASEDIR;
	
		if(!$cachemode)
		{
			foreach ($_CSS as $css)
			{
				?>				
				<link rel="stylesheet" type="text/css" href="<?=as_uri($css)?>">
				<?php 
				}
			}
			else 
			{
				$css_args=implode(";",$_CSS);
				?>
				<link rel="stylesheet" type="text/css" href="/index.php?cssblock=<?=$css_args?>">
				<?php 
			}
		}
	
	// вывести javascript
	function out_js($_JS,$cachemode=false)
	{
		GLOBAL $_BASEDIR;	
	
		if(!$cachemode)
		{
			foreach ($_JS as $js)
			{
			?>
			<script src="<?=as_uri($js)?>"></script>
			<?php 
			}
		}
		else 
		{
			$js_args=implode(";",$_JS);
			?>			
			<script src="/index.php?jsblock=<?=$js_args?>"></script>
			<?php			
		}
	}	
	// имя файла кэша js
	function make_cache_filename($_JS,$domen)
	{
		
		$js_total_file="";
		foreach ($_JS as $js)
		{
			$js_total_file=$js_total_file.md5($js);
		}
		//$js_total_file="vasya.js";
		return dir_dotted(url_seg_add(url_seg_add($this->get_module_dir(),url_seg_add("/cache/",$domen)),$js_total_file).".$domen");
	}
	// файл кэша js
	function make_cache_file($_JS,$js_cache_file,$domen)
	{
		$js_total_file="";
		foreach ($_JS as $js)
		{
			$js_total_file=$js_total_file."
".file_get_contents(dir_dotted($js));				
//".file_get_contents(url_seg_add("./",$js));
		}
		file_put_contents(dir_dotted($js_cache_file), $js_total_file);
	}
	
	function controller_request($req)
	{
		$_info = $this->controller_info($req['controller'],$req['method']);
		$req_obj = new HMVCRequest($req['controller'],$req['method'],$req['args']);
		$res = $this->call_action($_info,$req_obj);
		return $res;
	}
	
	function Error($errno=404)
	{
	
		$res = $this->controller_request(
				array(
						'controller'=>'site',
						'method'=>'error',
						'args'=>array($errno),
				)
				);
		$this->draw_html($res);
		die('');
		
	}
	
	function make_args($controller_name,$controller_object,$_action_name,&$request)
	{
		$class = new ReflectionClass($controller_name);
		$method = $class->getMethod($_action_name);
		$method_params = $method->getParameters();
		$method_args=array();
		
		// Проход по параметрам
		$idx_in_req_args=0;
		
		$_RULES = $controller_object->Rules();
		$arg_info = array();
		if(!empty($_RULES['action_args']))
		{
			$arg_info = $_RULES['action_args'][$request->_action];
		}
		
		//print_r($arg_info);
		
		$_fun_map = array();
		foreach ($method_params as $idx => $arg)
		{
		//	print_r($arg);
			$_fun_map[]=$arg->name;
			if(isset($request->_args[$arg->name]))
			{
				$_val = $request->_args[$arg->name];
				if(!empty($arg_info[$arg->name]))
				{
				//	echo '$_val=('.$arg_info[$arg->name].')$request->_args[$arg->name];';
					eval('$_val=('.$arg_info[$arg->name].')$request->_args[$arg->name];');
				}
				else
				{
					$_val=$request->_args[$arg->name];
				}
				$method_args[] = $_val;
			}
			elseif(isset($request->_args[$idx_in_req_args]))
			{
			//	echo "+ $idx_in_req_args +";
				
				if(isset($arg_info[$arg->name]))
				{
				//	echo '$request->_args[$arg->name]=('.$arg_info[$arg->name].')$request->_args[$idx_in_req_args];';
					eval('$request->_args[$arg->name]=('.$arg_info[$arg->name].')$request->_args[$idx_in_req_args];');
				}
				else
				{
					$request->_args[$arg->name]=$request->_args[$idx_in_req_args];
				}
				
				$request->delete_arg($idx_in_req_args);
				$method_args[$arg->name]=$request->_args[$arg->name];
			
			//	print_r($method_args);
				//getType
				$idx_in_req_args++;
			}
			else
			{
				if($arg->isDefaultValueAvailable())
				{
					$defval = $arg->getDefaultValue();
					$method_args[$arg->name]=$defval;
					$request->_args[$arg->name]=$defval;
				}
			}
		}
		
		//  print_r($method_args);
		$request->setmap($_fun_map);
		
		//print_r($request);
		if(count($method_args)!=count($method_params))
		{			
		//	echo ";;xxx;;";
			return NULL;
		}
		return $method_args;
	}
	// вызвать действие контроллера
	function call_action($con_info,$request,$_CONFIG=NULL,$_EP=NULL)
	{
		GLOBAL $_BASEDIR;
		GLOBAL $_CONFIGS_AREA;
		if($_CONFIG==NULL)
		{
			GLOBAL $_CONFIG;
		}
			
		if($_EP==NULL)
		{
			GLOBAL $_EP;
		}
		
		//print_r($request);
		
		$bad_result = array('ok'=>false);
			
		require_once "{$_BASEDIR}api/mullib/basecontroller.php";
			
		if( file_exists($con_info['_CONTROLLER_FILE']))
		{
			require_once $con_info['_CONTROLLER_FILE'];
		}
		else
		{
			return array_merge($bad_result,array('error'=>'404'));
		}
			
		$controller_name = $con_info['_CONTROLLER_CLASS'];
			
				// получить страницу из контроллера
		ob_start();
			
		$this->_ENV_INFO['page_module']=$this;
		$controller_object = new $controller_name(
						array(
								'_CONTROLLER_DIR' => $con_info['_DIR_CONTROLLER'],
								'_ENV'=>$this->_ENV_INFO,
						));
		$_action_name = $con_info['_ACTION'];
						
		// Такого метода нет в контроллере попытка 1
			
		if(!method_exists($controller_object, $_action_name))
		{
			return array_merge($bad_result,array('error'=>'404',));
		}
		//print_r($con_info);
		if(!$controller_object->IsActionEnable($con_info['_ACTION_NAME']))
		{
			return array_merge($bad_result,array('error'=>'403','notry'=>true));
		}
						
		// Параметры метода
		
		$method_args = $this->make_args($controller_name, $controller_object, $_action_name, $request);
		//print_r($method_args);
		if($method_args==NULL && !is_array($method_args) )
		{
			return array_merge($bad_result,array('error'=>'404','notry'=>true));
		}
		//print_r($method_args);
		try{
		call_user_func_array(array($controller_object,$_action_name), $method_args);
				//$controller_object->$_action_name();
			
		}
		catch (Exception $exc)
		{
			echo $exc->getMessage().' '.$exc->getCode();
		}
		$content = ob_get_contents();
		ob_end_clean();
			
			
		return array(
			'content'=>$content,
			'css'=>$controller_object->_CSS,
			'js'=>$controller_object->_JS,
			'title'=>$controller_object->_TITLE,
			'basic_layout'=>$controller_object->_LAYOUT,
			'_BLOCKS'=>$controller_object->_BLOCKS,
			'meta'=>$controller_object->_META,
			'_INLINE_SCRIPT'=>$controller_object->_INLINE_SCRIPT,
			'_INLINE_CSS'=>$controller_object->_INLINE_STYLE,
			'_RESULT_TYPE'=>$controller_object->_RESULT_TYPE,
			'_HEADERS'=>$controller_object->_HEADERS,
			'ok'=>true,
		);
	}		
			
	function get_controller($conname)
	{
		$info = $this->controller_info($conname);
		return $this->get_controller_object($info);
	}
	// вызвать действие контроллера
	function get_controller_object($con_info,$_CONFIG=NULL,$_EP=NULL)
	{
		GLOBAL $_BASEDIR;
		GLOBAL $_CONFIGS_AREA;
		if($_CONFIG==NULL)
		{
			GLOBAL $_CONFIG;
		}
	
		if($_EP==NULL)
		{
			GLOBAL $_EP;
		}
	
		require_once "{$_BASEDIR}api/mullib/basecontroller.php";
	
		require_once $con_info['_CONTROLLER_FILE'];
	
		$controller_name = $con_info['_CONTROLLER_CLASS'];
	
		// получить страницу из контроллера
	
		$this->_ENV_INFO['page_module']=$this;
		$controller_object = new $controller_name(
				array(
						'_CONTROLLER_DIR' => $con_info['_DIR_CONTROLLER'],
						'_ENV'=>$this->_ENV_INFO,
				));
	
	
		return $controller_object;
	}
	
}

