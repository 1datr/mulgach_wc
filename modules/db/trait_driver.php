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
}