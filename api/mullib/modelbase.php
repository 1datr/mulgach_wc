<?php
require_once url_seg_add(__DIR__,"dataset.php");

class BaseModel
{
	VAR $_TABLE;
	VAR $_LOOKUPS;
	VAR $_SETTINGS;
	VAR $_LOCATION;
	VAR $_ENV;	
	VAR $_SCENARIO='default';
	
	function __construct($_LOCATION="",$the_ENV=array())
	{
		$this->_LOCATION=$_LOCATION;
		$this->_ENV = $the_ENV;
		$this->_ENV['model']=$this;
		$rules = $this->rules();
		if(count($rules)==0)
			$this->read_base_info();
		else 
			$this->_SETTINGS=$rules;
		
		//mul_dbg($this->)
	}
	
	function rules()
	{
		return array();
	}
	
	function scenario($value=null)
	{
		if($value==null)
		{
			return $this->_SCENARIO;
		}
		else 
		{
			$this->_SCENARIO=$value;
			$rules = $this->rules();
			if(count($rules))
				$this->_SETTINGS=$rules;
			else 
				$this->_SETTINGS=$this->read_base_info();
		}
		
		return NULL;
	}
	
	function get_base_info()
	{
		$_baseinfo_file = url_seg_add($this->_LOCATION,"baseinfo.php");
		if(file_exists($_baseinfo_file))
		{
			include $_baseinfo_file;
			return $settings;
		}
		return array();
	}
	
	function read_base_info()
	{		
		$this->_SETTINGS = $this->get_base_info();
		$this->_TABLE=$this->_SETTINGS['table'];
		return $this->_SETTINGS; 
	}
	
	function getFldInfo($fld)
	{
		$res = $this->_SETTINGS['fields'][$fld];
		$res['required'] = isset($this->_SETTINGS['required'][$fld]) || in_array($fld,$this->_SETTINGS['required']);
		$res['bindings'] = array();
		
		if(isset($this->_SETTINGS['constraints'][$fld]))
		{
			$res['bindings'] = $this->_SETTINGS['constraints'][$fld];
		}
			
		if(isset($this->_SETTINGS['file_fields'][$fld]))
		{
			$res['file'] = $this->_SETTINGS['file_fields'][$fld];
		}
		return $res;
	}
	
	function validate($data)
	{
		//mul_dbg($data);
		
		$res = array();
		if(isset($data[$this->_TABLE]))
		{
			foreach ($this->_SETTINGS['required'] as $idx => $fld)
			{
				if($this->getPrimaryName()==$fld)
					continue;
				if(isset($this->_SETTINGS['file_fields'][$fld]))
				{
					if(empty($data[$this->_TABLE][$fld]))
					{
						add_keypair($res,$fld,Lang::__t($this->_TABLE.".".$fld)." could not be empty");
					}
					
					
				}
				else 
				{
					if(empty($data[$this->_TABLE][$fld]))
					{
						add_keypair($res,$fld,Lang::__t($this->_TABLE.".".$fld)." could not be empty");
					}
				}
			}
			$this->OnValidate($data[$this->_TABLE], $res);
		}				
		return $res;
	}
	
	function OnValidate($row,&$res)
	{
		
	}
	
	function get_field_type($field)
	{
		$type = $this->_SETTINGS['fields'][$field]['Type'];
		$res=array(
				'type'=>$type,
				'typeclass'=>$this->_ENV['_CONNECTION']->GetTypeClass($type),
		);
		return $res;
	}
	
	protected function db_query($query)
	{
		$res = $this->_ENV['_CONNECTION']->query($query);
		return $res;
	}
	
	
	
	// Список возможных значений поля если ENUM или SET
	function get_field_value_list($field)
	{
		if(in_array($this->_SETTINGS['fields'][$field]['Type'],array('enum','set')))
			return $this->_ENV['_CONNECTION']->get_enum_field_values($this->_SETTINGS['table'],$field);
		else 
			return $this->_SETTINGS['fields'][$field]['Type'];
	}
	
	private function make_dbrec($row)
	{
		
	}
	
	function isFieldRequired($_fld)
	{
		return isset($this->_SETTINGS['required'][$_fld]);
	}
	
	function GetRow($row)
	{
		$dr = new DataRecord($this,$row,$this->_ENV);
		return $dr;
	}
	
	function CreateNew($row=NULL)
	{
		if($row!=NULL)
		{
			$dr = new DataRecord($this,$row,$this->_ENV);			
		}
		else 
		{
			$dr = $this->GetRow($row);			
		}
		return $dr;
	}
	
	function empty_row_form_model($fill_fields=true)
	{
		$therow=array();
		foreach($this->_SETTINGS['fields'] as $fld => $fldinfo)
		{
			$therow[$fld]='';
		}
		$dr = new DataRecord($this,$therow);
		if($fill_fields)
		{
			foreach ($this->_SETTINGS['fields'] as $fld => $fldinfo)
			{
				$dr->setField($fld, null);
			}
		}
		return $dr;
	}
	// find as default dataset
	function find($where=1,$orderby=NULL)
	{
		$sql=$this->select_query($where,$orderby);
		$res = $this->db_query($sql);
		$ds =new  DataSet($res,$this->_ENV);
		return $ds;
	}
	
	function getPrimaryName()
	{
		return $this->_SETTINGS['primary'];
	}
	
	function Delete($where) {
		
		if(isset($this->_SETTINGS['file_fields']))
		{
			$ds = $this->find($where);
			$ds->walk(function($rec,$rowctr)
			{
				foreach ($this->_SETTINGS['file_fields'] as $fld => $finfo)
				{				
					$thefile = $rec->getField($fld);
					if(file_exists($thefile))
						unlink($thefile);					
				}
			});
		}
		
		//$where = $this->_ENV['_CONNECTION']->escape_sql_string($where);
		$sql=QueryMaker::query_delete($this->_TABLE,$where);
		$res = $this->_ENV['_CONNECTION']->query($sql);
		return $res;
	}
	
	function findByPrimary($id)
	{
		if(is_array($id))
		{
			if(!empty($id[$this->getPrimaryName()]))
				$id = $id[$this->getPrimaryName()];
			else 
				return null;
		}
		
		$row = $this->findOne("*.".$this->getPrimaryName()."={$id}");
		return $row;
	}
	
	function findOne($where=1,$orderby=NULL)
	{
		$sql=$this->select_query($where,$orderby);
		$res = $this->db_query($sql);
		$row = $this->_ENV['_CONNECTION']->get_row($res);
		//$this->_ENV
		//$dr = new DataRecord($this->_MODEL,$row,$this->_ENV);
		$dr = new DataRecord($this,$row,$this->_ENV);
		//$ds =new  DataSet($res,$this->_ENV);
		return $dr;
	}	
	
	// find as DataPager
	function findAsPager($options=array(),$page=1,$where=1,$orderby=NULL)
	{
		def_options(array('page_size'=>20),$options);
		$info = $this->page_query_struct($page,$options['page_size'],$where=1,$orderby);
		//print_r($info);
		$params=array('page'=>$page);
		$params['res'] = $this->db_query($info['page_query']);
		
		$res_count = $this->db_query($info['query_count']);
		$row_res = $this->_ENV['_CONNECTION']->get_row($res_count);
		$params['total_count'] = $row_res['COUNT'];
		
		if($row_res['COUNT'] % $options['page_size']==0 )
		{
			$params['pagecount'] = $row_res['COUNT'] / $options['page_size'];
		}
		else 
		{
			$params['pagecount'] = floor($row_res['COUNT'] / $options['page_size'])+1;
		}
		$params['env'] = $this->_ENV;
		
		$ds = new PageDataSet($params);
		return $ds;
	}
	// struct with queries
	function page_query_struct($page,$pagesize,$where=1,$orderby=NULL,$group=NULL,$having=NULL)
	{
		$joins="";
		$selects=array();
		$where = strtr($where,array('*.'=>'`'.$this->_SETTINGS['table'].'`.'));
		if(count($this->_SETTINGS['constraints']))
		{
			foreach ($this->_SETTINGS['constraints'] as $cfld => $constraint)
			{
				$model = $this->get_model($constraint['model']);
			//	print_r($model->_SETTINGS['fields']);
				foreach($model->_SETTINGS['fields'] as $_fld => $_fld_info)
				{
					$selects[]="`$cfld`.`$_fld` as `$cfld->$_fld`";
				}
				$joins = "{$joins} LEFT OUTER JOIN @+".$constraint['model']." as `$cfld` ON {$this->_TABLE}.`{$cfld}`=`$cfld`.`".$constraint['fld']."`";
				//$selects[]="`$cfld`.*";
			}
		}
		$sql_selects=implode(',', $selects);
		if($sql_selects!="")
			$sql_selects=",$sql_selects";
		
		$base = ($page-1) * $pagesize;
		if(!empty($orderby))
			$_ORDER = "$orderby";
		$query="SELECT `{$this->_TABLE}`.*{$sql_selects} FROM @+{$this->_TABLE} as `{$this->_TABLE}` {$joins} WHERE $where $_ORDER LIMIT $base,$pagesize";
		$query_count="SELECT COUNT(*) as `COUNT` FROM @+{$this->_TABLE} as `{$this->_TABLE}` {$joins} WHERE $where";
		return array('page_query'=>$query, 'query_count'=>$query_count);
	}
	
	public function files_before_update(&$datarow)
	{
		foreach ($this->_SETTINGS['file_fields'] as $fld => $fldsettings)
		{
			$curr_file =  $datarow->getField($fld);
			if($this->_SETTINGS['fileds'][$fld]['Type']=='blob')
			{
			
			}
			else
			{
				if($datarow->getField($fld)!='')
				{
					$temp_save_dir = url_seg_add($this->_ENV['_CONTROLLER']->get_current_dir(), '../../../files',$this->_SETTINGS['table'],$fld);
					$curr_file_info = pathinfo($curr_file);
					$newname = url_seg_add($temp_save_dir,$datarow->getPrimary().".".$curr_file_info['extension']);
				
					if (copy($curr_file,$newname)) {
						unlink($curr_file);
					}
				
					$datarow->setField($fld,$newname);
				}
				else 
					$datarow->setField($fld,'');
			}
		}
	}
	
	public function files_after_insert(&$datarow)
	{
		foreach ($this->_SETTINGS['file_fields'] as $fld => $fldsettings)
		{
			$curr_file =  $datarow->getField($fld);
			if($this->_SETTINGS['fileds'][$fld]['Type']=='blob')
			{
				
			}
			else 
			{
				if($datarow->getField($fld)!='')
				{
					$temp_save_dir = url_seg_add($this->_ENV['_CONTROLLER']->get_current_dir(), '../../../files',$this->_SETTINGS['table'],$fld);
					$curr_file_info = pathinfo($curr_file);
					$newname = url_seg_add($temp_save_dir,$datarow->getPrimary().".".$curr_file_info['extension']);
					
					if (copy($curr_file,$newname)) {
						unlink($curr_file);
					}
					
					$datarow->setField($fld,$newname);
				}
				else 
					$datarow->setField($fld,'');
			}
		}
		$datarow->save(false);
	}
	
	public function ActionRegister()
	{
		
	} 	
	
	public function UploadfilesTemp()
	{
		$res=array();
		
		foreach ($this->_SETTINGS['file_fields'] as $fld => $fld_info )
		{
			$filename = $_FILES[$this->_SETTINGS['table']]['name'][$fld];
			$tmpfile = $_FILES[$this->_SETTINGS['table']]['tmp_name'][$fld];
			
			if(empty($filename) && empty($tmpfile)) 
				continue;
			
			$path_parts = pathinfo($tmpfile);
			$path_name = pathinfo($filename);
			$ext = $path_name['extension'];
								
			$temp_save_dir = url_seg_add($this->_ENV['_CONTROLLER']->get_current_dir(), '../../../files',$this->_SETTINGS['table'],$fld, 'temp');
			x_mkdir($temp_save_dir);
			
			$basename = $path_parts['filename'];
			$ctr=1;
			while(file_exists( url_seg_add($temp_save_dir,$basename.".{$ext}") ))
			{
				$basename=$basename."_{$ctr}";
				$ctr++;
			}
			
			$temppath = url_seg_add($temp_save_dir,$basename.".{$ext}");
			copy($tmpfile,$temppath);
			$res[$this->_SETTINGS['table']."[{$fld}]"] = $temppath;
		}
		return $res;
	}
	
	function OnSave(&$object)
	{
		
	}
	
	function select_query($where=1,$orderby=NULL,$group=NULL,$having=NULL)
	{
		$joins="";
		$selects=array();
		$where = strtr($where,array('*.'=>'`'.$this->_SETTINGS['table'].'`.'));
		if(count($this->_SETTINGS['constraints']))
		{
			foreach ($this->_SETTINGS['constraints'] as $cfld => $constraint)
			{
				$model = $this->get_model($constraint['model']);
				foreach($model->_SETTINGS['fields'] as $_fld => $_fldinfo)
				{
					$selects[]="`$cfld`.`$_fld` as `$cfld->$_fld`";
				}
				$joins = "{$joins} LEFT OUTER JOIN @+".$constraint['model']." as `$cfld` ON {$this->_TABLE}.`{$cfld}`=`$cfld`.`".$constraint['fld']."`";
				//$selects[]="`$cfld`.*";
			}
		}
		$sql_selects=implode(',', $selects);
		if($sql_selects!="")
			$sql_selects=",$sql_selects";
		$query="SELECT `{$this->_TABLE}`.*{$sql_selects} FROM @+{$this->_TABLE} as `{$this->_TABLE}` {$joins} WHERE $where";
		//echo $query;
		return $query;
	}
	
	function get_model($triada)
	{
		$ctrlr = $this->_ENV['_CONTROLLER']->get_controller($triada);
		return $ctrlr->_MODEL;
	}
}