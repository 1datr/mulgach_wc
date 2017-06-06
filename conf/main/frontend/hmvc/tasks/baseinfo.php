<?php
$settings = array(
	'table'=>'tasks',
	'constraints'=>array('proj_id'=>array('model'=>'projects','fld'=>'id_project')),
	'rules'=>array('fio'=>'required'),	
);

