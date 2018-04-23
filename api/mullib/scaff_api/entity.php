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
			$this->DATA_DRV = $this->PARENT_CFG->_DRV;
		}
		else 
		{
			$this->TABLE=$table['ename'];
			$this->NAME=$this->TABLE;
			$this->PARENT_CFG = $cfg;
			$this->_TABLE_INFO = $table;
			$this->DATA_DRV = $this->PARENT_CFG->_DRV;
		}
	}
	
	function compile_table_info($nfo)
	{
		
		$this->_TABLE_INFO = array('fields'=>[],'table'=>$nfo['ename'],'required'=>[],'primary'=>[]);
		
		if(!empty($nfo['oldname']))
			$this->_TABLE_INFO['oldname']=$nfo['oldname'];
		
		foreach($nfo['fieldlist'] as $idx => $element)
		{
			
			if($element['type'] =="_ref")
			{

				$entity_to_obj = new scaff_entity($element['typeinfo']['entity_to'],$this->PARENT_CFG);
				$entity_to_obj->DATA_DRV = $this->DATA_DRV;
					
				$entity_to_fields = $entity_to_obj->get_fields();
			
				$fld_to_info = $entity_to_fields[$element['typeinfo']['fld_to']];				
				
				if(isset($element['required']))
				{
				
					$this->_TABLE_INFO['required'][]=$element['fldname'];
				}
					
				$element2 = $element;
				$element2['typeinfo']=$fld_to_info;
				
				$this->_TABLE_INFO['fields'][$element['fldname']]=[
						'Type'=>$fld_to_info['Type'],
						'TypeInfo'=>$this->DATA_DRV->make_fld_info_from_data($element2),
						'Null'=>($element['required']=='on'),
						'Default'=>$element['defval']
				];
				
				if(!empty($element['fldname_old']))
				{
					$this->_TABLE_INFO['fields'][$element['fldname']]['fldname_old'] = $element['fldname_old'];
				}
			}
			else
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
						'TypeInfo'=>$this->DATA_DRV->make_fld_info_from_data($element),
						'Null'=>($element['required']=='on'),
						'Default'=>$element['defval']
				];
				
				if(!empty($element['fldname_old']))
				{
					$this->_TABLE_INFO['fields'][$element['fldname']]['fldname_old'] = $element['fldname_old'];
				}
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