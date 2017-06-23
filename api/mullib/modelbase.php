<?php
require_once url_seg_add(__DIR__,"dataset.php");

class BaseModel
{
	VAR $_TABLE;
	VAR $_LOOKUPS;
	VAR $_SETTINGS;
	VAR $_LOCATION;
	VAR $_ENV;	
	VAR $_SCENARIO;
	
	function __construct($_LOCATION="",$the_ENV=array())
	{
		$this->_LOCATION=$_LOCATION;
		$this->_ENV = $the_ENV;
		$this->_ENV['model']=$this;
		$this->read_base_info();
	}
	
	function rules()
	{
		return array();
	}
	
	function read_base_info()
	{
		$_baseinfo_file = url_seg_add($this->_LOCATION,"baseinfo.php");
		if(file_exists($_baseinfo_file))
		{
			include $_baseinfo_file;
			$this->_SETTINGS = $settings;
			$this->_TABLE=$this->_SETTINGS['table'];
		}
	}
	
	function validate($data)
	{
		$res = array();
		if(isset($data[$this->_TABLE]))
		{
			foreach ($this->_SETTINGS['required'] as $idx => $fld)
			{
				if($this->getPrimaryName()==$fld)
					continue;
				if(!isset($data[$this->_TABLE][$fld]))
				{
					add_keypair($res,$fld,Lang::__t($this->_TABLE.".".$fld)." could not be empty");
				}
			}
			$this->OnValidate($data[$this->_TABLE], $res);
		}
		return $res;
	}
	
	function OnValidate($row,&$res)
	{
		
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
	
	function GetRow($row)
	{
		$dr = new DataRecord($this,$row,$this->_ENV);
		return $dr;
	}
	
	function CreateNew($row)
	{
		$dr = new DataRecord($this,$row,$this->_ENV);
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
		//$where = $this->_ENV['_CONNECTION']->escape_sql_string($where);
		$sql=QueryMaker::query_delete($this->_TABLE,$where);
		$res = $this->_ENV['_CONNECTION']->query($sql);
		return $res;
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
					$selects[]="`$cfld`.`$_fld` as `$cfld.$_fld`";
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