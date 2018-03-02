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
			
			if(!empty($element['fldname_old']))
			{
				$this->_TABLE_INFO['fields'][$element['fldname']]['fldname_old'] = $element['fldname_old'];
			}
		}				
	}
	
	function SetDrv($drv)
	{
		$this->DATA_DRV = $drv;
	}
	
	function get_fields()
	{
		$fields = $this->DATA_DRV->get_table_fields($this->TABLE);
		$this->COMPILED=false;
		if(!empty($this->PARENT_CFG))
		{
			$triada = $this->PARENT_CFG->get_triada('front',$this->TABLE);
			if($triada!=null)
			{
				$this->COMPILED=true;
			}
			else 
				$this->COMPILED=false;
		}
		
		if($this->COMPILED)
		{
			
		}		
		return $fields;
	}
	
	function make()
	{
		$this->compile_table_info($this->_TABLE_INFO);
		$this->build_table();
		$this->build_hmvc();
	}
	
	function build_table()
	{
		$this->DATA_DRV->build_table($this->_TABLE_INFO);
	}
	
	function build_hmvc()
	{
		
	}
	
	function delete()
	{
		$this->DATA_DRV->delete_table($this->TABLE);
	}
	
}