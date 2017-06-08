<?php
$settings = array(
	'table'=>'tasks',
	'fields'=>array('id_task','name','vhod_dannye','vihod_resultat','upravlenie','resursy_spisok','proj_id','vazhnost','srochnost','otv_sotr','sostoyanie_zadachi','date_plan','date_start','data_zaversheniya','data_prinyatiya','number_task','creator_id'),
	'primary'=>'id_task',
	'constraints'=>array('proj_id'=>array('model'=>'projects','fld'=>'id_project'),'otv_sotr'=>array('model'=>'workers','fld'=>'id'),'creator_id'=>array('model'=>'workers','fld'=>'id'),),	
	'rules'=>array(),	
	'view'=>'{name}',
);