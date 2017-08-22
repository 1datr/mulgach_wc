<?php
trait dbDriver {
	public function query($sql){}
	public function get_row($res,$idx=NULL){}
	public function rowcount($res){}
	public function get_tables(){}
	public function get_table_fields($tbl){}
	public function get_primary($var){}
	public function get_constraints($table){}
	public function escape_val($value,$type='text'){}
	public function create_table($table,$params){}
	public function last_insert_id(){}	
	// Ìועמהû נאבמעû ס עטןאלט
	public function Typelist(){}
	public function GetTypeClass($type){}
	public function class_map(){}
	// Ìועמהû הכÿ נאבמעû ס ןאנאלוענאלט הנאיגונמג
	public static function getModel(){
		return base_driver_model();
	}
	
}

function base_driver_model_settings()
{
	$settings = array(
			'domen'=>'dbinfo',
			'fields'=>array(
					'driver'=>array('Type'=>'text','TypeInfo'=>"20"),
			),
			'required'=>array('driver'),
			'rules'=>array(),
			//	'view'=>'{name}',
			'file_fields'=>array(),
	
	);
	
	return $settings;
}