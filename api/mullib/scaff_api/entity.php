<?php
// Работа с сущностями
class scaff_entity {
	VAR $NAME;
	VAR $TABLE;
	VAR $TABLE_MADE = FALSE;
	VAR $COMPILED=FALSE;
	VAR $DATA_DRV;
	VAR $PARENT_CFG=NULL;
	VAR $_TABLE_INFO=NULL;
	
	function __construct($table,$cfg)
	{
		if(is_string($table))
		{
			$this->TABLE=$table;
			$this->NAME=$table;
			$this->PARENT_CFG = $cfg;
			$this->PARENT_CFG->get_triada('frontend',$this->TABLE);
		}
		else 
		{
			$this->TABLE=$table['ename'];
			$this->NAME=$this->TABLE;
			$this->PARENT_CFG = $cfg;
			$this->_TABLE_INFO = $table;
		}
	}
	
	function compile_table_info($nfo)
	{
		$this->_TABLE_INFO = array('fields'=>[],'table'=>$nfo['ename'],'required'=>[],'primary'=>[]);
		
		foreach($nfo['fieldlist'] as $idx => $element)
		{
			if(isset($element['primary']))
			{
		
				$this->_TABLE_INFO['primary']=$element['fldname'];
			}
				
			if(isset($element['required']))
			{
					
				$this->_TABLE_INFO['required'][]=$element['fldname'];
			}
				
			$this->_TABLE_INFO['fields'][$element['fldname']]=[
					'Type'=>$element['type'],
					'TypeInfo'=>$this->DATA_DRV->make_fld_info_from_data($element)
			];
		}				
	}
	
	function SetDrv($drv)
	{
		$this->DATA_DRV = $drv;
	}
	
	function get_fields()
	{
		return $this->DATA_DRV->get_table_fields($this->TABLE);
	}
	
	function make()
	{
		$this->compile_table_info($this->_TABLE_INFO);
		$this->build_table();
		$this->build_hmvc();
	}
	
	function build_table()
	{
		$this->DATA_DRV->create_table($this->_TABLE_INFO);
	}
	
	function build_hmvc()
	{
		
	}
	
	function delete()
	{
		$this->DATA_DRV->delete_table($this->TABLE);
	}
	
}