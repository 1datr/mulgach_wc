<?php
$settings = array(
	'table'=>'urok',
	'fields'=>array('id_urok'=>array('Type'=>'bigint','TypeInfo'=>"20"),'id_razdel'=>array('Type'=>'bigint','TypeInfo'=>"20"),'number'=>array('Type'=>'bigint','TypeInfo'=>"20"),'name'=>array('Type'=>'text','TypeInfo'=>""),'video1'=>array('Type'=>'text','TypeInfo'=>""),'video2'=>array('Type'=>'text','TypeInfo'=>""),'video3'=>array('Type'=>'text','TypeInfo'=>""),'document1'=>array('Type'=>'text','TypeInfo'=>""),'document2'=>array('Type'=>'text','TypeInfo'=>""),'hometask'=>array('Type'=>'text','TypeInfo'=>""),'presentation'=>array('Type'=>'text','TypeInfo'=>""),'text_block'=>array('Type'=>'text','TypeInfo'=>""),'theme'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id_urok',
	'constraints'=>array('id_razdel'=>array('model'=>'razdel','fld'=>'id_razdel','required'=>true),),	
	'required'=>array('id_urok','id_razdel','number','name','theme'),
	'rules'=>array(),	
	'view'=>'{name}',
	'file_fields'=>array('document1'=>array('type'=>''),'document2'=>array('type'=>''),),
	
);