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
	
	static function query_delete($tbl,$where='1')
	{
		return "DELETE FROM `@+{$tbl}` WHERE $where";
	}
	
	static function query_makedb($db_name)
	{
		return "CREATE DATABASE IF NOT EXISTS `@+{$db_name}`";
	}
	
	static function query_update($tbl,$arr,$WHERE=1)
	{
		return "UPDATE `@+{$tbl}` SET ".xx_implode($arr, ',', "`{idx}`='{%val}'") ." WHERE {$WHERE}";
	}
	
	static function query_create_db($settings)
	{
		
	}
	
	static function query_insert($tbl,$_arr_to_insert)
	{
		function one_block_query($arr)
		{
			$str = xx_implode($arr, ',', "'{%val}'",
					function(&$theval,&$idx,&$thetemplate,&$ctr)
					{
						//print_r($theval);
						if(substr($theval['%val'],0,1)=='#')
						{
							$thetemplate="{%val}";
							$theval['%val']=substr($theval['%val'],1);
						}
						
					}
			);
			return "({$str})";
		}
		$akeys = array_keys($_arr_to_insert);
		if(is_int($akeys[0])) // many rows inserting
		{
			$sql="INSERT INTO `@+{$tbl}`(".xx_implode($_arr_to_insert[0], ',', '`{idx}`').") VALUES".one_block_query($_arr_to_insert[0]);
			for($i=1;$i<count($akeys);$i++)
			{
				$sql=$sql.",".one_block_query($_arr_to_insert[$i]);
			}
		}
		else 
		{
			$sql="INSERT INTO `@+{$tbl}`(".xx_implode($_arr_to_insert, ',', '`{idx}`').") VALUES".one_block_query($_arr_to_insert);
		}
		return $sql;
	}
}

class QueryResult
{
	
}