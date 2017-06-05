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
		$res = $this->db_query($info['page_query']);
		$res_count = $this->db_query($info['query_count']);
		$row_res = $this->_ENV['_CONNECTION']->get_row($res_count);	
				
		if($row_res['COUNT'] % $options['page_size']==0 )
		{
			$pagecount = $row_res['COUNT'] / $options['page_size'];
		}
		else 
		{
			$pagecount = floor($row_res['COUNT'] / $options['page_size'])+1;
		}
		
		$ds = new PageDataSet($res,$pagecount,$page,$this->_ENV);
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
				$joins = "{$joins} LEFT OUTER JOIN @+".$constraint['model']." as `$cfld` ON {$this->_TABLE}.`{$cfld}`=`$cfld`.`".$constraint['fld']."`";
				$selects[]="`$cfld`.*";
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
				$joins = "{$joins} LEFT OUTER JOIN @+".$constraint['model']." as `$cfld` ON {$this->_TABLE}.`{$cfld}`=`$cfld`.`".$constraint['fld']."`";
				$selects[]="`$cfld`.*";
			}
		}
		$sql_selects=implode(',', $selects);
		if($sql_selects!="")
			$sql_selects=",$sql_selects";
		$query="SELECT `{$this->_TABLE}`.*{$sql_selects} FROM @+{$this->_TABLE} as `{$this->_TABLE}` {$joins} WHERE $where";
		return $query;
	}
}