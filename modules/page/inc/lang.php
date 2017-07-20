<?php
class Lang {
	
	static function __t($key,$_lang=NULL)
	{
		
		
		GLOBAL $_EP_PATH;
		
		$langfile=new Lang($_lang);
		
		if($langfile->getkey($key)==NULL)
			$langfile->add_key($key);
		
		return $langfile->getkey($key);
	}
	
	static function get_langs($conf=NULL,$ep=NULL)
	{
		GLOBAL $_EP_PATH;
		GLOBAL $_BASEDIR;
		if(($conf==NULL)&&($ep==NULL))
			$lang_dir = url_seg_add($_EP_PATH,"lang");
		else
			$lang_dir = url_seg_add($_BASEDIR,"conf",$conf,$ep,"lang");
		
		$lang_files = get_files_in_folder($lang_dir,['without_ext'=>true]);
		return $lang_files;
	}
	
	static function search($lng,$srch,$val)
	{
		$lng_object = new Lang($lng);
		return $lng_object->search_fuzzy($srch,$val);
	}
	
	static function translate_str($str,$_lang=NULL)
	{
		$langfile=new Lang($_lang);
		$langfile->read();
		$strtr_buf=array();
		
		$matches=array();
		
		preg_match_all('/\#\{(.+)\}/Uis', $str, $matches);
		$to_strtr=array();
		foreach ($matches[1] as $idx => $key)
		{
			$lng_val = Lang::__t($key);
			$to_strtr[$matches[0][$idx]]=$lng_val;
		}
		//$str = preg_match() ('/\#\{(.+)\}/', '=Lang::__t()', $str);
		
		return strtr($str,$to_strtr);
	}
	
	VAR $lang_dir;
	VAR $EP_PATH;
	VAR $_BUFFER;
	
	function __construct($_lang=NULL,$conf=NULL,$ep=NULL,$base_lang_dir="")
	{		
		GLOBAL $_BASEDIR;
		if($_lang==NULL)
			$_lang='ru';		
		
		GLOBAL $_EP_PATH;
		$this->EP_PATH = $EP_PATH;
		if(($conf==NULL)&&($ep==NULL))
			$this->lang_dir = url_seg_add($_EP_PATH,"lang/{$_lang}.php");
		else 
			$this->lang_dir = url_seg_add($_BASEDIR,"conf",$conf,$ep,"lang/{$_lang}.php");
		if(!file_exists($this->lang_dir))
		{
			x_file_put_contents($this->lang_dir, '<?php
	$_LANG["'.$key.'"]="'.$key.'";
?>');
		}
		else 
		{
			
		}
	}
	
	function read()
	{
		include $this->lang_dir;
		$this->_BUFFER=$_LANG;
	}
	
	function search_fuzzy($_key,$_val)
	{
		if(empty($_val))
			$_val='';
		if(empty($_key))
			$_key='';
			
		include $this->lang_dir;
		$res=array();		
		
		try 
		{
			foreach ($_LANG as $key => $val)
			{
				$founded=false;
				if(!empty($_key))
				{
					if(strpos($key,$_key)!==false)
					{
						$founded=true;
					}
				}	
				if(!empty($_val))
				{
					if(strpos($val,$_val)!==false)
					{
						$founded=true;
					}
				}
				if(empty($_key) && empty($_val))
					$founded=true;
				if($founded)
				{
					$res[$key] = $val;
				}
			}
		}
		catch(Exception $exc)
		{
			
		}
	//	mul_dbg($res);
		return $res;
	}
	
	function getkey($key)
	{
		include $this->lang_dir;
		if(empty($_LANG[$key])) 
			return NULL;
		else 
			return $_LANG[$key];		
	}
	
	
	function add_key($key,$value=NULL)
	{
		include $this->lang_dir;
		$newlang=array();
		foreach ($_LANG as $oldkey => $val)
		{
			$newlang[$oldkey]=$val;
		}
		if($value==NULL)
			$value=$key;
		$newlang[$key]=$value;
		
			
		$new_lang_content = "<?php
				// ++++
".xx_implode($newlang, '
', "\$_LANG['{idx}']='{%val}';")."
?>";
		//mul_dbg($new_lang_content);
		
		$res = file_put_contents($this->lang_dir, $new_lang_content);
	}
}