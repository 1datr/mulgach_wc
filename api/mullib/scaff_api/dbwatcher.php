<?php
// Вытаскивает данные из базы нужные для скаффолдинга

class DbWatcher {
	
	VAR $_CONNECTION;
	
	function __construct(&$dbconnection)
	{
		$this->_CONNECTION = $dbconnection;
	}
	
	function get_basic_table_info($_table)
	{
		$result = [];
		
		$result['fields'] = $this->_CONNECTION->get_table_fields($_SESSION['makeinfo']['table']);
		$result['tables'] = $this->_CONNECTION->get_tables();
		$result['first_table_fields'] = $this->_CONNECTION->get_table_fields($result['tables'][0]);
		$result['view'] = $this->SearchViewFld($result['fields']);
		
		$result['auth_fields']=$this->search_auth_fields($result['fields']);
		
		$primary_fld = $this->_CONNECTION->get_primary($result['fields']);
		
		if($primary_fld!=null)
		{
			$result['primary']['field']=$primary_fld;
			if($result['fields'][$primary_fld]['Extra'] != 'auto_increment')
			{
				$result['primary']['ai']=FALSE;
			}
			else 
				$result['primary']['ai']=TRUE;
		}
		return $result;
	}
	
	function search_auth_fields($_fields)
	{
		$result=array();
		foreach ($_fields as $fld => $val)
		{
			if(strstr($fld,'login')!=false)
			{
				$result['login']=$fld;
			}
		
			if(strstr($fld,'passw')!=false)
			{
				$result['passw']=$fld;
			}
		
			if( (strstr($fld,'hash')!=false) || (strstr($fld,'token')!=false) )
			{
				$result['hash']=$fld;
			}
		
			if( (strstr($fld,'e-mail')!=false) || (strstr($fld,'email')!=false) || (strstr($fld,'mail')!=false) )
			{
				$result['email']=$fld;
			}
		}
		return $result;
	}
	
	function SearchViewFld($fieldlist)
	{
		foreach ($fieldlist as $fld => $fldinfo)
		{
			if( ($fldinfo['Type']=='text') || (strstr($fldinfo['Type'],"varchar")!=false) )
			{
				return "{".$fld."}";
			}
		}
		$primary = $this->_CONNECTION->get_primary($fieldlist);
		return "#{".$primary."}";
	}
	
}