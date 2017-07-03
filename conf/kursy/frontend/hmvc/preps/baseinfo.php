<?php
$settings = array(
	'table'=>'preps',
	'fields'=>array('id_prep'=>array('Type'=>'bigint','TypeInfo'=>"20"),'first_name'=>array('Type'=>'text','TypeInfo'=>""),'last_name'=>array('Type'=>'text','TypeInfo'=>""),'user_id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'sostoyanie_dopuska'=>array('Type'=>'enum','TypeInfo'=>"'new','check','allowed',''")),
	'primary'=>'id_prep',
	'constraints'=>array('user_id'=>array('model'=>'users','fld'=>'id','required'=>true),),	
	'required'=>array('id_prep','first_name','last_name','user_id','sostoyanie_dopuska'),
	'rules'=>array(),	
	'view'=>'{first_name}',
	
);