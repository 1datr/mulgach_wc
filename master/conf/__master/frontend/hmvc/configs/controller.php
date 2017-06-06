<?php 
class ConfigsController extends BaseController
{
		
	public function ActionIndex()
	{
		$this->_TITLE="CONFIGS";
		$this->add_css($this->get_current_dir()."/css/style.css");
		
		$this->add_block('BASE_MENU', 'site', 'menu');
		$this->add_keyword('xxx');
		
		global $_BASEDIR;
		$files_in_conf_dir = get_files_in_folder( url_seg_add($_BASEDIR,"/conf"));
		
		$this->out_view('index',array('files'=>$files_in_conf_dir));
	}
	
	public function ActionNew()
	{
		if(!empty($_POST['newcfg']))
		{
			GLOBAL $_BASEDIR;
			$cfgdir = url_seg_add($_BASEDIR,"/conf");
			$newcfg = url_seg_add($cfgdir,$_POST['newcfg']);					
			mkdir($newcfg);
			
			$base_eps=array('frontend','backend','install','rest');
			foreach ($base_eps as $ep)
			{
				$ep_dir = url_seg_add($newcfg,$ep);
				mkdir($ep_dir);
			}
			
		}
		$this->redirect_back();
	}
	
	public function ActionDrop($cfg)
	{		
		GLOBAL $_BASEDIR;
		$cfgdir = url_seg_add($_BASEDIR,"/conf",$cfg);
		
		unlink_folder($cfgdir);
		
	//	$this->redirect_back();
	}
	
}
?>