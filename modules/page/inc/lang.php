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
	
	function __construct($_lang=NULL)
	{			
		if($_lang==NULL)
			$_lang='ru';		
		
		GLOBAL $_EP_PATH;
		$this->EP_PATH = $EP_PATH;
		$this->lang_dir = url_seg_add($_EP_PATH,"lang/{$_lang}.php");
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
		
		//print_r($newlang);
		
		$new_lang_content = "<?php
".xx_implode($newlang, '
', "\$_LANG['{idx}']='{%val}';")."
?>";
		file_put_contents($this->lang_dir, $new_lang_content);
	}
}