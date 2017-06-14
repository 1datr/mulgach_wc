<?php
// модуль страница
require_once __DIR__.'/inc/theme.php';
session_start();

class mul_page extends mul_Module 
{
	VAR $_DIR_CONFIG;
	VAR $_DIR_EP;
	VAR $_THEME;
	VAR $CFG_INFO;
	VAR $_ENV_INFO=array();
	
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
		
		if(!empty($_REQUEST['cssblock']))	// блок css-файлов
		{
			$this->draw_css($_REQUEST['cssblock']);
			die();
		}
		
		GLOBAL $_EP, $_CONTROLLER, $_ACTION, $_THEME;
		GLOBAL $_CONFIGS_AREA, $_CONFIG, $_BASEDIR;
		if(empty($_EP))
			$_EP="frontend";
		
		if(empty( $_REQUEST['controller']))						
			$_CONTROLLER="site";
		else 
			$_CONTROLLER=$_REQUEST['controller'];
		
		if(empty( $_REQUEST['action']))
			$_ACTION="index";
		else 
			$_ACTION= $_REQUEST['action'];
		
		$this->_DIR_CONFIG = url_seg_add($_CONFIGS_AREA,$_CONFIG); // директория конфигурации		
		
		$this->_DIR_EP = url_seg_add($this->_DIR_CONFIG, $_EP);	// директория точки входа
			

		
		$conf_info = $this->controller_info();
		$this->CFG_INFO = $conf_info;
		//print_r($conf_info);
		//echo url_seg_add($conf_info['_DIR_EP'],"/config.php");
		include url_seg_add($conf_info['_DIR_EP'],"/config.php");
		
		if(!empty($_THEME))
		{
			$this->_THEME=$_THEME;
		}
	//	echo $_THEME;
		$info = $this->call_action($conf_info);
		//print_r($info);
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
	
	function draw_html($info)
	{
		$_CSS=array();
		$_JS=array();
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
		?>
		<html>
		<head>
		<?php 
					GLOBAL $_BASEDIR;		
					
								
					
					if(empty($_FAVICO))
						$_FAVICO = "favico.ico";
					if(empty($_FAVICO_FORMAT))
						$_FAVICO_FORMAT="image/x-icon";
					
					$conf_url =	url_seg_add($_BASEDIR,$_CONFIGS_AREA);
						
					$ico_file_ref = url_seg_add($this->_DIR_EP,$_FAVICO);
					$ico_file_path = url_seg_add("./",url_seg_add($this->_DIR_EP ,$_FAVICO));
					if(file_exists($ico_file_path))
					{
						?>
						<link href="<?=$ico_file_ref?>" rel='shortcut icon' type="<?=$_FAVICO_FORMAT?>"/>
						<link href="<?=$ico_file_ref?>" rel='icon' type="<?=$_FAVICO_FORMAT?>"/>
						<?php 
					}
											
					if(empty($_APPLE_TOUCH_ICONS))
						$_APPLE_TOUCH_ICONS=array($ico_file_ref);
					
					foreach ($_APPLE_TOUCH_ICONS as $idx => $icofile)
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
		
					$_LAYOUT_INFO = $this->get_layout($info);
					// ввод css
					global $_CACHE_CSS;
					if(empty($_CACHE_CSS)) $_CACHE_CSS = false;
					$_CSS=merge_arrays($_CSS, $info['css']);
					$_CSS=merge_arrays($_CSS,$_LAYOUT_INFO['css']);
					
					$this->out_css($_CSS,$_CACHE_CSS);
					
					
					// вывод скриптов
					$_JS=merge_arrays($_JS, $info['js']);
					$_JS=merge_arrays($_JS,$_LAYOUT_INFO['js']);
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
								$block_con_info=$this->controller_info($item['controller'], $item['action']);
								$_info=$this->call_action($block_con_info, $item['action']);
								$$varname=$$varname.$_info['content'];
							}
						}
					}
												
					if(empty($_HTML_CHARSET))
						$_HTML_CHARSET = "utf-8";
					?>
					<meta http-equiv="Content-Type" content="text/html; charset=<?=$_HTML_CHARSET?>" />
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
					?>
		</head>
		<body>
		<?php 
					
		include $_LAYOUT_INFO['basic_layout'];
		?>
		</body>
		</html>
		<?php 
	}
	
	function get_layout($info)
	{
		GLOBAL $_THEME;
		
		$found=false;
		if(!empty($this->_THEME))
		{
		//	echo ":: $_THEME ::";
			$layout_info = array('basic_layout'=>'','css'=>array(),'js'=>array());
			$themes = XTheme::find($this->_THEME,$this->CFG_INFO['_DIR_CONFIG']);
			if(count($themes)>0)
			{
				$theme = new XTheme($themes[0]);
				$layout_info['basic_layout']= url_seg_add($themes[0],'index.php');
				$layout_info['css']=$theme->_CONFIG['css'];
				$layout_info['js']=$theme->_CONFIG['js'];
				$found=true;
			}
			
		}		
		
		if($found==false)
		{			
						
			$_BASE_LAYOUT= url_seg_add($this->_DIR_EP,"/views/basic_layout.php");
			if(empty($info['basic_layout']))
			{
				$layout_info['basic_layout']=$_BASE_LAYOUT;
			}
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
				<link rel="stylesheet" type="text/css" href="<?=$css?>">
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
			<script src="<?=$js?>"></script>
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
		$res = $this->call_action($_info);
		return $res;
	}
	// вызвать действие контроллера
	function call_action($con_info,$_CONFIG=NULL,$_EP=NULL)
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
		ob_start();
		
		$this->_ENV_INFO['page_module']=$this;
		$controller_object = new $controller_name(
				array(
					'_CONTROLLER_DIR' => $con_info['_DIR_CONTROLLER'],					
					'_ENV'=>$this->_ENV_INFO,
				));
		$_action_name = $con_info['_ACTION'];
		
		
		// Такого метода нет в контроллере
		if(!method_exists($controller_object, $_action_name))
		{
			$_action_name="ActionIndex";
			// смещаем параметры не связанные с контроллером и действием
		//	print_r($_REQUEST['args']);
			$args2 = array($_REQUEST['action']);
			
			$_REQUEST['action']='index';
			
			if(!empty($_REQUEST['args']))
			foreach ($_REQUEST['args'] as $idx => $arg)
			{
				$args2[]=$arg;
			}
			//
			$_REQUEST['args']=$args2;
		}
		
		
		// Параметры метода
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
			$arg_info = $_RULES['action_args'][$con_info['_ACTION_NAME']];
		}
		//print_r($arg_info);
		foreach ($method_params as $idx => $arg)
		{
			if(!empty($_REQUEST[$arg->name]))
			{
				$_val = $_REQUEST[$arg->name];
				if(!empty($arg_info[$arg->name]))
				{
					eval('$_val=('.$arg_info[$arg->name].')$_REQUEST[$arg->name];');
				}
				else
				{
					$_val=$_REQUEST[$arg->name];
				}
				$method_args[] = $_val;
			}
			elseif(!empty($_REQUEST['args'][$idx_in_req_args])) 
			{				
				
				
				if(!empty($arg_info[$arg->name]))
				{
					eval('$_REQUEST[$arg->name]=('.$arg_info[$arg->name].')$_REQUEST["args"][$idx_in_req_args];');
				}
				else 
				{
					$_REQUEST[$arg->name]=$_REQUEST['args'][$idx_in_req_args];
				}
				$method_args[]=$_REQUEST[$arg->name];
				//getType				
				$idx_in_req_args++;
			}
			else 
			{
				$defval = $arg->getDefaultValue();
				$method_args[]=$defval;
				$_REQUEST[$arg->name]=$defval;
				
			}
		}
		
		call_user_func_array(array($controller_object,$_action_name), $method_args);
		//$controller_object->$_action_name();
		
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
			'_RESULT_TYPE'=>$controller_object->_RESULT_TYPE,
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