<?php
$settings = array(
	'table'=>'otdel',
	'fields'=>array('id_otdel','name','function','id_otdel_papa','cvet'),
	'primary'=>'',
	'constraints'=>array('id_otdel_papa'=>array('model'=>'otdel','fld'=>'id_otdel'),),	
	'rules'=>array(),	
	'view'=>'{name}',
);