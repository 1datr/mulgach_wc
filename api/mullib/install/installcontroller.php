<?php
class InstallController extends BaseController 
{

	public function ActionIndex()
	{
		$this->_TITLE = Lang::__t('Installation');
		$model=array();
		
		$model = $this->UseModel(base_driver_model_settings());
		$model_row = $model->empty_row_form_model();
		$plugs = $this->GetPlugs();
		//
		
		$this->out_view('dbinfocontainer',array('model_row'=>$model_row,'plugs'=>$plugs));
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
	
	public function ActionLoadform($drv=NULL)
	{
		$this->_TITLE = Lang::__t('Installation');
		$model=array();
		
		$model = $this->UseModel(base_driver_model_settings());
		$model_row = $model->empty_row_form_model();
		$plugs = $this->GetPlugs();
		
		//
		
		$this->out_ajax_block('dbsettings',array('model_row'=>$model_row,'plugs'=>$plugs));
	}
}