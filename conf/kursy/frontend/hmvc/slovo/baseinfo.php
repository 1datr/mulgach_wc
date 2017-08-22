<?php
$settings = array(
	'table'=>'slovo',
	'fields'=>array('id_slovo'=>array('Type'=>'bigint','TypeInfo'=>"20"),'ru'=>array('Type'=>'text','TypeInfo'=>""),'zvuk_ru'=>array('Type'=>'text','TypeInfo'=>""),'en'=>array('Type'=>'text','TypeInfo'=>""),'risunok'=>array('Type'=>'blob','TypeInfo'=>""),'zvuk_en'=>array('Type'=>'text','TypeInfo'=>""),'transcription'=>array('Type'=>'text','TypeInfo'=>""),'type'=>array('Type'=>'enum','TypeInfo'=>"'существительное','прилагательное','глагол','наречие','деепричастие','причастие','предлог','союз','артикль','служебное слово'")),
	'primary'=>'id_slovo',
	'constraints'=>array(),	
	'required'=>array('id_slovo','risunok','type'),
	'rules'=>array(),	
	'view'=>'{bukva}',
	'file_fields'=>array('zvuk_ru'=>array('type'=>'audio/*'),'risunok'=>array('type'=>'image/*'),'zvuk_en'=>array('type'=>'audio/*'),),
	
);