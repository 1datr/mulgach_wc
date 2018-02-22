<?php
// Работа с сущностями
class scaff_entity {
	VAR $NAME;
	VAR $TABLE;
	VAR $COMPILED=FALSE;
	VAR $DATA_DRV;
	VAR $PARENT_CFG=NULL;
	
	function __construct($table,$cfg)
	{
		$this->TABLE=$table;
		$this->NAME=$table;
		$this->PARENT_CFG = $cfg;
		$this->PARENT_CFG->get_triada('frontend',$this->TABLE);
		
	}
	
	function delete()
	{
		$this->DATA_DRV->delete_table($this->TABLE);
	}
	
}