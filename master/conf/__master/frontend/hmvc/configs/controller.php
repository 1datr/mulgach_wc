<?php 
namespace __master\Frontend;

class ConfigsController extends \BaseController
{
	public function Rules()
	{
		return array(
				'action_access'=>array(
						new \ActionAccessRule('deny',$this->getActions(),'anonym','site/login')
				),
		);
	}
	public function ActionIndex()
	{
		$this->_TITLE="CONFIGS";
		$this->add_css($this->get_current_dir()."/css/style.css");
		
		$this->add_block('BASE_MENU', 'site', 'menu');
		
		use_jq_plugin('confirmdelete',$this);
		
		global $_BASEDIR;
		$files_in_conf_dir = get_files_in_folder( url_seg_add($_BASEDIR,"/conf"));
		
		GLOBAL $_CONFIG;
		
		$this->out_view('index',array('files'=>$files_in_conf_dir,'curr_config'=>$this->getCurrCFG() ));
	}	
	
	public function BeforeAction(&$params)
	{
		$this->add_block('SIDEBAR_LEFT', 'configs', 'conflist');
	}
	
	public function ActionConflist()
	{
		global $_BASEDIR;
		$files_in_conf_dir = get_files_in_folder( url_seg_add($_BASEDIR,"/conf"));
		
		GLOBAL $_CONFIG;
		
		$this->out_view('conflist',array('files'=>$files_in_conf_dir,'curr_config'=>$this->getCurrCFG() ));
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
	
	public function ActionPack($cfg=null)
	{
		if($cfg==NULL)
		{				
			$cfg= $this->getCurrCFG();
		}
		
		GLOBAL $_BASEDIR;
		$this->_TITLE=$cfg.' #{Edit database connection config}';
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$cnf = new \scaff_conf($cfg);
		
		$arcplg = \mul_archive::use_archive_plg('zip');
		
		$zip_file_name = time().'.mca.zip';
		if ($arcplg->ARCMAN->open($zip_file_name, \ZipArchive::CREATE) === true){
			
			$fldr = $arcplg->AddFolder($cnf->_PATH,['/dbconf.php']);
			//$zip->addFile($cfg->_PATH);
		
			$arcplg->ARCMAN->close();
			$this->OutFile($zip_file_name);
			
			unlink($zip_file_name);
		}else{
			echo 'Не могу создать архив!';
		}
	}
	
	public function ActionNew()
	{
		if(!empty($_POST['newcfg']))
		{
			GLOBAL $_BASEDIR;		
			require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
			$cnf = new \scaff_conf($_POST['newcfg'],array('rewrite'=>true));
		}
		$this->redirect_back();
	}
	
	public function ActionDrop($cfg)
	{		
		GLOBAL $_BASEDIR;
		$cfgdir = url_seg_add($_BASEDIR,"/conf",$cfg);
		
		unlink_folder($cfgdir);
		
		$this->redirect_back();
	}
	
	// параметры POST - file
	public function ActionInstall()
	{
		GLOBAL $_BASEDIR;
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		//form_req_cfg_name
		/*
		if(isset($_POST['']))
		{*/
			//$_FILES['cfgfile']['tmp_name']
			mul_dbg($_FILES,true);
			die();
			/*
		}
		*/
	}
	
	public function ActionSetcurrent()
	{
		GLOBAL $_BASEDIR;
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		
		\scaff_conf::set_current_cfg($_POST['cfg']);
		
		$this->redirect_back();
	}
	
}


?>