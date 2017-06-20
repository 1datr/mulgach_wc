<?php
class XTheme 
{
	public static function find($_theme,$_CONF_DIR)
	{
		GLOBAL $_BASEDIR, $_CONFIG;
		$path_themes_all= dir_dotted(url_seg_add($_BASEDIR,"/themes"));
		
		$paths =  find_file($_theme, $path_themes_all);
	//	$_CONF_DIR = dir_dotted(url_seg_add($_BASEDIR,url_seg_add('conf', url_seg_add( $_CONFIG,'themes'))));

		$paths_in_conf =  find_file($_theme, $_CONF_DIR);
		
		$paths = array_merge($paths,$paths_in_conf);
		
		//print_r($paths);
		
		return $paths;
	}
	
	VAR $_PATH;
	VAR $_CONFIG;
	function __construct($thema_dir)
	{
		$this->_PATH = $thema_dir;
		$config_file = url_seg_add($this->_PATH, '/config.php');
		if(file_exists($config_file))
		{
			include $config_file;
			$this->_CONFIG=$_CONFIG;
		}
		else 
		{
			$this->_CONFIG=array('css'=>'#def','js'=>'#def');
		}
		
		if(!empty($this->_CONFIG['css']))
		{
			if($this->_CONFIG['css']=='#def')
			{
				$this->_CONFIG['css']=$this->get_css_def();
			}
			else 
			{
				foreach ($this->_CONFIG['css'] as $idx => $css)
				{
					$this->_CONFIG['css'][$idx] = url_seg_add($this->_PATH, $css);
				}
			}
		}
		
		if(!empty($this->_CONFIG['js']))
		{
			if($this->_CONFIG['js']=='#def')
			{
				$this->_CONFIG['js']=$this->get_js_def();
			}
			else
			{
				foreach ($this->_CONFIG['js'] as $idx => $js)
				{
					$this->_CONFIG['js'][$idx] = url_seg_add($this->_PATH, $js);
				}
			}
		}
		
		$this->_CONFIG['_FAVICO']= url_seg_add($this->_PATH,$this->_CONFIG['_FAVICO']);
	}
	
	function get_view($theview)
	{
		$thepath = url_seg_add($this->_PATH,'views',"$theview.php");
		if(!file_exists($thepath))
		{
			return NULL;
		}
		return $thepath;
	}
	
	function get_css_def()
	{
		$result=array();
		
		$css_dir=dir_dotted( url_seg_add($this->_PATH,'css'));
		if(!file_exists($css_dir))
			return $result;
		$d = dir($css_dir);
		
		//	echo "Дескриптор: " . $d->handle . "\n";
		//	echo "Путь: " . $d->path . "\n";
		while (false !== ($entry = $d->read())) {
			if(($entry!="..")&&($entry!="."))
			{
				$filename = url_seg_add($css_dir, $entry);
				
				$result[]=$filename;
				
			}
		}
		$d->close();
		return $result;
	}
	
	function get_js_def()
	{
		$result=array();
		$js_dir=dir_dotted( url_seg_add($this->_PATH,'js'));
		if(!file_exists($js_dir))
			return $result;
		$d = dir($js_dir);
		
		//	echo "Дескриптор: " . $d->handle . "\n";
		//	echo "Путь: " . $d->path . "\n";
		while (false !== ($entry = $d->read())) {
			if(($entry!="..")&&($entry!="."))
			{
				$filename = url_seg_add($js_dir, $entry);
				
				$result[]=$filename;
				
			}
		}
		$d->close();
		return $result;
	}
}