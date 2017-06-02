<?php

class QueryMaker {
	
	static function prepare_query($sql,$prefix)
	{
		return strtr($sql,array('@+'=>$prefix));
	}
}

class QueryResult
{
	
}