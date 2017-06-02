<?php
class DbRecord
{
	VAR $_TABLE;
	function save()
	{
		
	}
	
}

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
	
	function find($where=1,$orderby=NULL)
	{
		$sql=$this->select_query($where,$orderby);
		$res = $this->db_query($sql);
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