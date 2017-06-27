<?php
class scaff_triada
{
	VAR $_PATH;
	VAR $_VIEWPATH;
	VAR $_PARENT_CONF;
	VAR $_EP;
	VAR $_CONTROLLER_PATH;
	VAR $_MODEL_PATH;
	VAR $_BASEFILE_PATH;

	function __construct(&$conf_obj,$ep,$triada,$create=true)
	{
		$this->_PARENT_CONF = $conf_obj;
		$this->_PATH = url_seg_add( $conf_obj->_PATH, $ep, 'hmvc', $triada);
		if(!file_exists($this->_PATH) || $create)
		{
				x_mkdir($this->_PATH);
		}
		$this->_VIEWPATH = url_seg_add($this->_PATH,'views');
		if(!file_exists($this->_VIEWPATH) || $create)
		{
			x_mkdir($this->_VIEWPATH);
		}
	}
	
	
	function from_template()
	{
		
	}
	
	static function exists(&$obj,$ep,$hmvc)
	{
		$triada_path = url_seg_add($obj->_PATH, $ep, 'hmvc', $hmvc);
		if(file_exists($triada_path))
		{
			return true;
		}
		return false;
	}
	// файл модели
	function make_model($_params,$rewrite_all=true)
	{
		$this->_MODEL_PATH = url_seg_add( $this->_PATH,'model.php');
		if(!file_exists($this->_MODEL_PATH) || $rewrite_all)
		{
			$vars=array();
			$vars['table_uc_first']=UcaseFirst($_params['table']);
			$vars['TABLE_UC']=strtoupper($_params['table']);
			$vars['table'] = $_params['table'];
			if(!isset($_params['ModelClass']))
				$_params['ModelClass']='BaseModel';
			$vars['BaseModelClass'] = $_params['ModelClass'];
			x_file_put_contents($this->_MODEL_PATH, parse_code_template(url_seg_add(__DIR__,'/phpt/model.phpt'),$vars));
		}
	}
	
	function add_view($viewname,$_template,$vars=array(),$rewrite_all=true)
	{
		$new_view_path=url_seg_add($this->_VIEWPATH,$viewname.".php");
		if(!file_exists($new_view_path) || $rewrite_all)
			x_file_put_contents($new_view_path, parse_code_template(url_seg_add(__DIR__,'/phpt/'.$_template.'.phpt'),$vars));
	}
	
	function add_std_data_views($_params,$controller,$rewrite_all=true)
	{
		$index_view = url_seg_add($dir_views,'index.php');
		
		$_primary = $controller->_ENV['_CONNECTION']->get_primary($tbl_fields);
		
		if(!file_exists($index_view) || $_params['rewrite_all'])
		{
			$vars=array();
			$vars['table'] = $_params['table'];
			$vars['primary']=$_primary;
			$vars['TABLE_UC']=strtoupper($_params['table']);
			//	echo $this->parse_code_template('view_index',$vars);
			$this->add_view('index','view_index',$vars);
			//x_file_put_contents($index_view, parse_code_template(url_seg_add(__DIR__,'../../phpt/view_index.phpt'),$vars));
		}
		
		$itemform_view = url_seg_add($dir_views,'itemform.php');
		if(!file_exists($itemform_view) || $_params['rewrite_all'])
		{
			$vars=array();
		
			$vars['table'] = $_params['table'];
			$vars['TABLE_UC']=strtoupper($_params['table']);
			$vars['fld_primary']=$_primary;
			$vars['fields']=$tbl_fields;
			$vars['settings']=$settings;
			$vars['constraints']=$_params['constraints'];
			$this->add_view('itemform','view_itemform',$vars);
			// //	$tpl_file= url_seg_add(__DIR__,"../../phpt",$tpl).".phpt";
			//x_file_put_contents($itemform_view, parse_code_template(url_seg_add(__DIR__,'../../phpt/view_itemform.phpt'),$vars));
		}
	}
	
	
	function make_baseinfo($_params,$controller,$template='baseinfo')
	{
		$_template = url_seg_add(__DIR__,'/phpt/',$template.'.phpt');		
	//	$file_baseinfo= url_seg_add( $this->_PATH,'baseinfo.php');
		
		$vars=array();
		$vars['table']=$_params['table'];
		$tbl_fields = $controller->_ENV['_CONNECTION']->get_table_fields($_params['table']);
			
	//	$this->gather_fields_captions($tbl_fields);
		
		$fields_code = xx_implode($tbl_fields, ',', "'{idx}'=>array('Type'=>'{Type}','TypeInfo'=>\"{TypeInfo}\")",
				function(&$theval,&$idx,&$thetemplate,&$ctr,&$thedelimeter){
					//	$theval['TypeInfo']=strtr($theval['TypeInfo'],array("'"=>"'"));
				});
			
		$vars['array_fields']="array({$fields_code})";
		$con_str="";
		if(!empty($_params['constraints']))
		{
			foreach ($_params['constraints'] as $idx => $binding)
			{
				$required = ((!empty($binding['required'])) ? true : false);
				$con_str = $con_str."'".$binding['field']."'=>array('model'=>'".$binding['table']."','fld'=>'".$binding['field_to']."','required'=>".json_encode($required)."),";
			}
		}
		$constraints="";
		
		$vars['array_constraints']="array($con_str)";
		$vars['array_rules']='array()';
		$_primary = $controller->_ENV['_CONNECTION']->get_primary($tbl_fields);
		$vars['primary']=$_primary;
		$vars['view']=$_params['view'];
		//print_r($_params);
		$vars['required']='array('.xx_implode($_params['model_fields'], ',', "'{name}'",function($theval,&$idx,&$thetemplate,&$ctr,&$thedelimeter)
		{
			if(empty($theval['required']))
			{
				$thetemplate='';
				$thedelimeter='';
			}
		}).')';
		
		$this->_BASEFILE_PATH=url_seg_add($this->_PATH,'baseinfo.php');
		/*if(!file_exists($this->_CONTROLLER_PATH) || $rewrite)
		{*/
			x_file_put_contents($this->_BASEFILE_PATH, parse_code_template($_template, $vars));
		//}
	}
	
	function make_controller($vars=array(),$rewrite,$template='controller')
	{
		$_template = url_seg_add(__DIR__,'/phpt/',$template.'.phpt');
		$this->_CONTROLLER_PATH=url_seg_add($this->_PATH,'controller.php');
		if(!file_exists($this->_CONTROLLER_PATH) || $rewrite)
		{
			x_file_put_contents($this->_CONTROLLER_PATH, parse_code_template($_template, $vars));
		}
	}
	
	function getExistingModelInfo($triada,$ep="frontend")
	{
		GLOBAL $_BASEDIR;
		$baseinfo_file=url_seg_add($this->_PATH,$ep,"hmvc",$triada,"baseinfo.php");
		//echo $baseinfo_file;
		if(file_exists($baseinfo_file))
		{
			include $baseinfo_file;
			return $settings;
		}
	
		return NULL;
	}
}