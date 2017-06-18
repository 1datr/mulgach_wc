<?php
class Lang {
	
	static function __t($key,$_lang=NULL)
	{
		if($_lang==NULL)
			$_lang='ru';
		
		GLOBAL $_EP_PATH;
		$lang_dir = url_seg_add($_EP_PATH,"lang/{$__lang}.php");
		require_once $lang_dir;
		if(isset($_LANG[$key]))
			return $_LANG[$key];
	}
	
}