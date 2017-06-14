<?php
$settings = array(
	'table'=>'tasks',
	'fields'=>array('id_task'=>array('Type'=>'bigint','TypeInfo'=>"20"),'name'=>array('Type'=>'text','TypeInfo'=>""),'vhod_dannye'=>array('Type'=>'text','TypeInfo'=>""),'vihod_resultat'=>array('Type'=>'text','TypeInfo'=>""),'upravlenie'=>array('Type'=>'text','TypeInfo'=>""),'resursy_spisok'=>array('Type'=>'text','TypeInfo'=>""),'proj_id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'vazhnost'=>array('Type'=>'enum','TypeInfo'=>"'не очень важная','важная','очень важная'"),'srochnost'=>array('Type'=>'enum','TypeInfo'=>"'несрочная (недели"),'otv_sotr'=>array('Type'=>'bigint','TypeInfo'=>"20"),'sostoyanie_zadachi'=>array('Type'=>'enum','TypeInfo'=>"'план','в работе','закончена','принята'"),'date_plan'=>array('Type'=>'datetime','TypeInfo'=>""),'date_start'=>array('Type'=>'datetime','TypeInfo'=>""),'data_zaversheniya'=>array('Type'=>'datetime','TypeInfo'=>""),'data_prinyatiya'=>array('Type'=>'datetime','TypeInfo'=>""),'number_task'=>array('Type'=>'int','TypeInfo'=>"11"),'creator_id'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id_task',
	'constraints'=>array('proj_id'=>array('model'=>'projects','fld'=>'id_project','required'=>false),'otv_sotr'=>array('model'=>'workers','fld'=>'id','required'=>false),'creator_id'=>array('model'=>'workers','fld'=>'id','required'=>true),),	
	'rules'=>array(),	
	'view'=>'{name}',
);