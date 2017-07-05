<?php
// ìîäóëü ñòðàíèöà

class mul_bootstrap extends mul_Module 
{
	function __construct($_PARAMS)
	{
		$this->use_my_widgtes();
	}
	
	function use_my_widgtes()
	{
		$files = get_files_in_folder( url_seg_add("/",__DIR__,'widgets'));
		//print_r($files);
		foreach ($files as $thefile)
		{
			if(is_dir("/".$thefile))
			{
				$wid_file=url_seg_add("/",$thefile,'index.php');
				if(file_exists($wid_file))				
				{
					//echo "use widget";
					require_once $wid_file;
				}
			}
		}
	}
	
	function wait_events()
	{
		return array('jquery');
	}
		
	function page_before_html(&$args)
	{
		GLOBAL $_BASEDIR;
		$args['CSS']=array($this->get_module_dir()."/assets/css/bootstrap.min.css");
		$args['JS']=array($this->get_module_dir()."/assets/js/bootstrap.min.js");
	}

}