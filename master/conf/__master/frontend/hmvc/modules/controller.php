<?php 
class ModulesController extends BaseController
{
	public function Rules()
	{
		return array(
				'action_access'=>array(
						new ActionAccessRule('deny',$this->getActions(),'anonym','site/login')
				),
		);
	}
		
	public function ActionIndex()
	{
		$this->_TITLE="Master";
		$this->add_css($this->get_current_dir()."/css/style.css");
		
		$this->add_block('BASE_MENU', 'site', 'menu');
		$this->add_keyword('modules');
		
		global $_BASEDIR;
		$modules_dir = url_seg_add($_BASEDIR,'modules');
		//echo $modules_dir;
		$dirs = get_nested_dirs($modules_dir);
		$dirlist=array();
		foreach ($dirs as $dir)
		{
			$dirlist[]=basename($dir);
		}
	//	print_r($dirlist);
		
		$this->out_view('index',array('modules'=>$dirlist));
	}
	
	public function ActionMakeplg()
	{
		if(!empty($_POST['plgname']))
		{
			global $_BASEDIR;
			$module_file = url_seg_add($_BASEDIR,'modules',$_POST['module'],'plugins',$_POST['plgname'],'index.php');
			x_file_put_contents($module_file, 
					parse_code_template(url_seg_add(__DIR__,'../../phpt/module/plugin.phpt'), array('plgname'=>$_POST['plgname'])) );
			echo "<h3>".Lang::__t('Plugin succesfully created')."</h3>";
			$this->redirect('\?r=modules');
		}
	}
	
	
}
?>