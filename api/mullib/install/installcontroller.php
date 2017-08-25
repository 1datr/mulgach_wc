<?php
class InstallController extends BaseController 
{

	public function ActionIndex()
	{
		$this->_TITLE = Lang::__t('Installation');
		$model=array();
		
	//	$model = $this->UseModel(base_driver_model_settings());
	//	$model_row = $model->empty_row_form_model();
	//	$plugs = $this->GetPlugs();
		//
		
		$this->out_view('dbinfocontainer',array(//'model_row'=>$model_row,
				'plugs'=>$plugs,'drv_first'=>$plugs[0]));
	}
	
	public function GetPlugs()
	{
		$plugs = mul_Module::getModulePlugins('db');
		$plugs = filter_array($plugs,function(&$el){
			$matchez=array();
			if( preg_match_all('/^drv_(.+)$/Uis', $el['value'],$matchez))
			{
				$el['value']=$matchez[1][0];
				return true;
			}
			return false;
		});
		
		return $plugs;
	}
	
	public function get_plug_obj($plg)
	{
		$module_db = find_module('db');
		if($module_db!=NULL)
		{
			$plg = $module_db->use_plugin($plg,['connectable'=>false]);
			return $plg;
		}
		return NULL;
	}
		
	public function BeforeValidate()
	{
		//mul_dbg($_POST);
		$driver = $_POST['dbinfo']['driver'];
		$drv_obj = $this->get_plug_obj("drv_".$driver);
		$_model = $drv_obj->getModel();
		$this->UseModel($_model);
		//mul_dbg($_model);		
	}
	
	public function get_db_conf()
	{
		$conf_dir = url_seg_add($this->get_current_dir(),'../../..');
		$dbconf_file = url_seg_add($conf_dir,'dbconf.php');
		if(file_exists($dbconf_file))
		{
			include $dbconf_file;
			return $dbparams;
		}
		return NULL;
	}
	
	public function ActionSetconfig()
	{
		$conf_dir = url_seg_add($this->get_current_dir(),'../../..');
		$dbconf_file = url_seg_add($conf_dir,'dbconf.php');
		
		$driver = $_POST['dbinfo']['driver'];
		$drv_obj = $this->get_plug_obj("drv_".$driver);
		
		$code = $drv_obj->dbconfig_code($_POST['dbinfo']);
		file_put_contents($dbconf_file, $code);
	}
	
	public function ActionLoadform($drv=NULL)
	{
		$this->_TITLE = Lang::__t('Installation');
		
		$plugs = $this->GetPlugs();

		if($drv==NULL)
		{
			$params_in_conf = $this->get_db_conf();
			if($params_in_conf==NULL)
				$drv=$plugs[0];
			else 
				$drv=$params_in_conf['driver'];
		}
				
		//
		$drv_class = 'drv_'.$drv;
		$drv_obj = $this->get_plug_obj($drv_class);
		$the_model = $this->UseModel($drv_obj->getModel());
		
		$model_row = $the_model->empty_row_form_model();
		$model_row->setField('driver', $drv);
		
		if($params_in_conf!=NULL)	// есть конфиг бд
		{
			foreach($params_in_conf as $pkey => $pval)
			{
				
				$model_row->setField($pkey, $pval);
			}
		}
		
		$this->out_ajax_block('dbsettings',array('model_row'=>$model_row,'plugs'=>$plugs,'drv'=>$drv,'drv'=>$drv));
	}
}