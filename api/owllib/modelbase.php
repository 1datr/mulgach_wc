<?php
require_once url_seg_add(__DIR__,"dataset.php");

class BaseModel
{
	VAR $_TABLE;
	VAR $_LOOKUPS;
	VAR $_SETTINGS;
	VAR $_LOCATION;
	VAR $_ENV;	
	
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
	
	private function db_query($query)
	{
		$res = $this->_ENV['_CONNECTION']->query($query);
		return $res;
	}
	
	private function make_dbrec($row)
	{
		
	}
	
	
	// find as default dataset
	function find($where=1,$orderby=NULL)
	{
		$sql=$this->select_query($where,$orderby);
		$res = $this->db_query($sql);
		$ds =new  DataSet($res,$this->_ENV);
		return $ds;
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
		if(count($this->_SETTINGS['constraints']))
		{
			foreach ($this->_SETTINGS['constraints'] as $cfld => $constraint)
			{
				$model = $this->get_model($constraint['model']);
			//	print_r($model->_SETTINGS['fields']);
				foreach($model->_SETTINGS['fields'] as $_fld)
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
		
		$base = ($page-1) * $pagesize;
		if(!empty($orderby))
			$_ORDER = "$orderby";
		$query="SELECT `{$this->_TABLE}`.*{$sql_selects} FROM @+{$this->_TABLE} as `{$this->_TABLE}` {$joins} WHERE $where $_ORDER LIMIT $base,$pagesize";
		$query_count="SELECT COUNT(*) as `COUNT` FROM @+{$this->_TABLE} as `{$this->_TABLE}` {$joins} WHERE $where";
		return array('page_query'=>$query, 'query_count'=>$query_count);
	}
	
	function select_query($where=1,$orderby=NULL,$group=NULL,$having=NULL)
	{
		$joins="";
		$selects=array();
		if(count($this->_SETTINGS['constraints']))
		{
			foreach ($this->_SETTINGS['constraints'] as $cfld => $constraint)
			{
				$model = $this->get_model($constraint['model']);
				foreach($model->_SETTINGS['fields'] as $_fld)
				{
					$selects[]="$cfld.$_fld as `$cfld.$_fld`";
				}
				$joins = "{$joins} LEFT OUTER JOIN @+".$constraint['model']." as `$cfld` ON {$this->_TABLE}.`{$cfld}`=`$cfld`.`".$constraint['fld']."`";
				//$selects[]="`$cfld`.*";
			}
		}
		$sql_selects=implode(',', $selects);
		if($sql_selects!="")
			$sql_selects=",$sql_selects";
		$query="SELECT `{$this->_TABLE}`.*{$sql_selects} FROM @+{$this->_TABLE} as `{$this->_TABLE}` {$joins} WHERE $where";
		return $query;
	}
	
	function get_model($triada)
	{
		$ctrlr = $this->_ENV['_CONTROLLER']->get_controller($triada);
		return $ctrlr->_MODEL;
	}
}