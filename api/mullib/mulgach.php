<?php
class Mulgach
{
	static function version()
	{
		return "1.0.0";
	}
	
	static function sysname()
	{
		return "Mulgach";
	}
	
	static function fullname()
	{
		return Mulgach::sysname()." ".Mulgach::version();
	}
}