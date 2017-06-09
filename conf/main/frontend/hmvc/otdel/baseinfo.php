<?php
$settings = array(
	'table'=>'otdel',
	'fields'=>array('id_otdel'=>array('Type'=>'int','TypeInfo'=>"11"),'name'=>array('Type'=>'varchar','TypeInfo'=>"200"),'function'=>array('Type'=>'varchar','TypeInfo'=>"1000"),'id_otdel_papa'=>array('Type'=>'int','TypeInfo'=>"11"),'cvet'=>array('Type'=>'enum','TypeInfo'=>"'синий (анализ, управление")),
	'primary'=>'',
	'constraints'=>array('id_otdel_papa'=>array('model'=>'otdel','fld'=>'id_otdel'),),	
	'rules'=>array(),	
	'view'=>'{name}',
);