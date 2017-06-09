<?php
$settings = array(
	'table'=>'projects',
	'fields'=>array('id_project'=>array('Type'=>'bigint','TypeInfo'=>"20"),'name'=>array('Type'=>'text','TypeInfo'=>""),'full_name'=>array('Type'=>'text','TypeInfo'=>""),'otv_ruk'=>array('Type'=>'bigint','TypeInfo'=>"20"),'date_generate'=>array('Type'=>'datetime','TypeInfo'=>""),'date_start'=>array('Type'=>'datetime','TypeInfo'=>""),'date_end'=>array('Type'=>'datetime','TypeInfo'=>""),'teh_zad'=>array('Type'=>'text','TypeInfo'=>""),'id_otdel'=>array('Type'=>'int','TypeInfo'=>"11"),'sostoyanie'=>array('Type'=>'enum','TypeInfo'=>"'планируется достичь','в работе','достигнуто'"),'current-task-number'=>array('Type'=>'int','TypeInfo'=>"11"),'creator_id'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id_project',
	'constraints'=>array('id_otdel'=>array('model'=>'otdel','fld'=>'id_otdel'),'creator_id'=>array('model'=>'workers','fld'=>'id'),),	
	'rules'=>array(),	
	'view'=>'{name}',
);