<?php
$settings = array(
	'table'=>'otdel',
	'fields'=>array('id_otdel'=>array('Type'=>'int','TypeInfo'=>"11"),'name'=>array('Type'=>'varchar','TypeInfo'=>"200"),'function'=>array('Type'=>'varchar','TypeInfo'=>"1000"),'id_otdel_papa'=>array('Type'=>'int','TypeInfo'=>"11"),'cvet'=>array('Type'=>'enum','TypeInfo'=>"'синий (анализ, управление")),
	'primary'=>'id_otdel',
	'constraints'=>array('id_otdel_papa'=>array('model'=>'otdel','fld'=>'id_otdel','required'=>false),),	
	'rules'=>array(),	
	'view'=>'{name}',
);