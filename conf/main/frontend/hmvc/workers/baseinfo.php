<?php
$settings = array(
	'table'=>'workers',
	'fields'=>array('id','number','fio','fio_eng','position','city','address1','address2','mail1','mail2','phone1','phone2','phone3','responsibility','login','password','is_arhiv','level','token'),
	'primary'=>'id',
	'constraints'=>array(),	
	'view'=>'{fio}',
	'rules'=>array(),	
);