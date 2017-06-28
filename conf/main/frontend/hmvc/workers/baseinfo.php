<?php
$settings = array(
	'table'=>'workers',
	'fields'=>array('id'=>array('Type'=>'int','TypeInfo'=>"11"),'number'=>array('Type'=>'varchar','TypeInfo'=>"255"),'fio'=>array('Type'=>'varchar','TypeInfo'=>"255"),'fio_eng'=>array('Type'=>'varchar','TypeInfo'=>"255"),'position'=>array('Type'=>'enum','TypeInfo'=>"'Админ','Старший менеджер','Менеджер','Сотрудник'"),'city'=>array('Type'=>'varchar','TypeInfo'=>"255"),'address1'=>array('Type'=>'varchar','TypeInfo'=>"255"),'address2'=>array('Type'=>'varchar','TypeInfo'=>"255"),'mail1'=>array('Type'=>'varchar','TypeInfo'=>"255"),'mail2'=>array('Type'=>'varchar','TypeInfo'=>"255"),'phone1'=>array('Type'=>'varchar','TypeInfo'=>"255"),'phone2'=>array('Type'=>'varchar','TypeInfo'=>"255"),'phone3'=>array('Type'=>'varchar','TypeInfo'=>"255"),'responsibility'=>array('Type'=>'varchar','TypeInfo'=>"255"),'login'=>array('Type'=>'varchar','TypeInfo'=>"255"),'password'=>array('Type'=>'varchar','TypeInfo'=>"255"),'is_arhiv'=>array('Type'=>'tinyint','TypeInfo'=>"4"),'level'=>array('Type'=>'tinyint','TypeInfo'=>"4"),'token'=>array('Type'=>'text','TypeInfo'=>"")),
	'primary'=>'id',
	'constraints'=>array(),	
	'required'=>array('id','number','fio','fio_eng','position','city','address1','address2','mail1','mail2','phone1','phone2','phone3','responsibility','login','password','is_arhiv','level','token'),
	'rules'=>array(),	
	'view'=>'{fio}',
	
);