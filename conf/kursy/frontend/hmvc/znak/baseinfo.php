<?php
$settings = array(
	'table'=>'znak',
	'fields'=>array('id_znak'=>array('Type'=>'bigint','TypeInfo'=>"20"),'znak'=>array('Type'=>'text','TypeInfo'=>""),'transcription'=>array('Type'=>'text','TypeInfo'=>""),'sound'=>array('Type'=>'text','TypeInfo'=>""),'type'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id_znak',
	'constraints'=>array(),	
	'required'=>array('id_znak','znak','transcription','sound','type'),
	'rules'=>array(),	
	'view'=>'{znak}',
	
);