<?php

class QueryMaker {
	
	static function prepare_query($sql,$prefix)
	{
		return strtr($sql,array('@+'=>$prefix));
	}
	
	static function query_get_table_fields($tbl)
	{
		return "SHOW COLUMNS FROM `@+{$tbl}`";
	}
}

class QueryResult
{
	
}