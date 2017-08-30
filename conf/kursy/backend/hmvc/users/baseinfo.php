<?php
$settings = array(
	'table'=>'users',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'login'=>array('Type'=>'text','TypeInfo'=>""),'password'=>array('Type'=>'text','TypeInfo'=>""),'email'=>array('Type'=>'text','TypeInfo'=>""),'first_name'=>array('Type'=>'text','TypeInfo'=>""),'last_name'=>array('Type'=>'text','TypeInfo'=>""),'phone'=>array('Type'=>'text','TypeInfo'=>""),'web'=>array('Type'=>'text','TypeInfo'=>""),'address'=>array('Type'=>'text','TypeInfo'=>""),'sostoyanie_dopuska'=>array('Type'=>'enum','TypeInfo'=>"'new','check','permited'"),'skype'=>array('Type'=>'text','TypeInfo'=>""),'status'=>array('Type'=>'enum','TypeInfo'=>"'student','prep'"),'hash'=>array('Type'=>'text','TypeInfo'=>"")),
	'primary'=>'id',
	'constraints'=>array(),	
	'required'=>array('id','sostoyanie_dopuska','status'),
	'rules'=>array(),	
	'view'=>'{bukva}',
	'file_fields'=>array(),
	
);