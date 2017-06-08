<?php
$settings = array(
	'table'=>'forum',
	'fields'=>array('id','name','description','forum_id'),
	'primary'=>'id',
	'constraints'=>array('forum_id'=>array('model'=>'forum','fld'=>'id'),),	
	'rules'=>array(),	
	'view'=>'{name}',
);