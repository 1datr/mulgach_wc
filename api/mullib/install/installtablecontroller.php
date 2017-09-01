<?php
class InstallTableController extends BaseController 
{
	
	public function ActionIndex()
	{
		$this->_TITLE = Lang::__t('Installation');
		$model=array();
	
		//	$model = $this->UseModel(base_driver_model_settings());
		//	$model_row = $model->empty_row_form_model();
		//	$plugs = $this->GetPlugs();
		//
		
		$_TABLE = $this->_MODEL->_SETTINGS['table'];
		if($this->connect_db_if_exists())
		{
		//	mul_dbg($this->_CONNECTION);
			$this->_CONNECTION->create_table($this->_MODEL->_SETTINGS);
		}
	
		$arr_json=['message'=>Lang::__t('Table ').$_TABLE.Lang::__t(' was created')];
		
		$this->out_json($arr_json);
	}
	
	function connect_db_if_exists()
	{
		GLOBAL $_BASEDIR;
		try
		{
			$conffile=url_seg_add($this->get_current_dir(),"../../../dbconf.php");
			//mul_dbg($conffile);
	
			include $conffile;
			//
	
			if(!empty($dbparams))	// конфа подключена к базе
			{
				$this->_CONNECTION = $this->connect_db($dbparams);
				$this->_ENV['_CONNECTION'] = $this->_CONNECTION;
				//GLOBAL $_MUL_DBG_WORK;
				//print_r($_MODULES['db']);
	
				return $dbparams;
			}
	
			return TRUE;
		}
		catch (Exception $exc)
		{
			//	echo "<h4>This configuration does not exists</h4>";
			//die();
			return false;
		}
		return false;
	}
}