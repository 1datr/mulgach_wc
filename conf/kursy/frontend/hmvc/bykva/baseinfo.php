<?php
$settings = array(
	'table'=>'bykva',
	'fields'=>array('id_bukva'=>array('Type'=>'bigint','TypeInfo'=>"20"),'bukva'=>array('Type'=>'text','TypeInfo'=>""),'transcription'=>array('Type'=>'text','TypeInfo'=>""),'sound'=>array('Type'=>'text','TypeInfo'=>""),'type'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id_bukva',
	'constraints'=>array(),	
	'required'=>array('id_bukva','bukva','transcription','sound','type'),
	'rules'=>array(),	
	'view'=>'{bukva}',
	
);