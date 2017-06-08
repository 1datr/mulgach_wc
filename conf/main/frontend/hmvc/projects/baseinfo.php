<?php
$settings = array(
	'table'=>'projects',
	'fields'=>array('id_project','name','full_name','otv_ruk','date_generate','date_start','date_end','teh_zad','id_otdel','sostoyanie','current-task-number','creator_id'),
	'primary'=>'id_project',
	'constraints'=>array('otv_ruk'=>array('model'=>'workers','fld'=>'id'),'creator_id'=>array('model'=>'workers','fld'=>'id'),'id_otdel'=>array('model'=>'otdel','fld'=>'id_otdel'),),	
	'rules'=>array(),	
	'view'=>'{name}',
);