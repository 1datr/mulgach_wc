<?php 
class ConfigsController extends BaseController
{
	public function Rules()
	{
		return array(
				'action_access'=>array(
						new ActionAccessRule('deny',$this->getActions(),'anonym','?r=site/login')
				),
		);
	}
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
	
	public function ActionChangecfgfile()
	{
		
	}
	
	public function ActionSetdbcfg()
	{
		GLOBAL $_BASEDIR;
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$cnf = new scaff_conf($_POST['cfg']);
		$cnf->set_db_conf_code($_POST['code']);
		$this->redirect(as_url('configs'));
	}
	
	public function ActionEditconf($cfg='main')
	{
		$this->add_block('BASE_MENU', 'site', 'menu');
		GLOBAL $_BASEDIR;		
		$this->_TITLE=$cfg.' #{Edit database connection config}';
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$cnf = new scaff_conf($cfg); 
		
		$this->out_view('configform',array('cfg'=>$cfg,'conf_code'=>$cnf->get_db_conf_code()));
	}
	
	public function ActionNew()
	{
		if(!empty($_POST['newcfg']))
		{
			GLOBAL $_BASEDIR;		
			require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
			$cnf = new scaff_conf($_POST['newcfg'],array('rewrite'=>true));
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