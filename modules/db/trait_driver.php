<?php
trait dbDriver {
	public function query($sql){}
	public function must_connect(){}
	public function get_row($res,$idx=NULL){}
	public function rowcount($res){}
	public function get_tables(){}
	public function get_table_fields($tbl){}
	public function get_primary($var){}
	public function get_constraints($table){}
	public function escape_val($value,$type='text'){}
	public function create_table($table,$params){}
	public function last_insert_id(){}	
	
	public function error_number(){}
	public function error_text(){}
	
	public function test_conn($conn_params){}
	// Ìועמהû נאבמעû ס עטןאלט
	public function Typelist(){}
	public function GetTypeClass($type){}
	public function class_map(){}
	// Ìועמהû הכÿ נאבמעû ס ןאנאלוענאלט הנאיגונמג
	public static function getModel(){
		return dbDriver::base_driver_settings();
	}
	public function get_db_list(){}
	
	public function create_db($dbname){}
	
	public static function base_driver_settings()
	{
		$settings = array(
				'domen'=>'dbinfo',
				'fields'=>array(
						'driver'=>array('Type'=>'enum','TypeInfo'=>"20",'fldparams'=>['htmlattrs'=>[
											'id'=>'the_driver',
											'onclick'=>'load_ajax_block(\'#drv_params\',\''.as_url('site/loadform/').'\'+\'/\'+$(\'#the_driver\').val());',
						],
								'valuelist'=>function(){
									$plugs = mul_Module::getModulePlugins('db');
									$plugs = filter_array($plugs,function(&$el){
										$matchez=array();
										if( preg_match_all('/^drv_(.+)$/Uis', $el['value'],$matchez))
										{
											$el['value']=$matchez[1][0];
											return true;
										}
										return false;
									});
									
										return $plugs;
									}
								]),
				),
				'required'=>array('driver'),
				'rules'=>array(),
				//	'view'=>'{name}',
				'file_fields'=>array(),
	
		);
	
		return $settings;
	}

	public function dbconfig_code($_params){}
}

