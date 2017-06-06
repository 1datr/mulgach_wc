<?php
function merge_arrays($array1,$array2)
{
	$res = $array1;
	if(!empty($array2))
	{
		foreach ($array2 as $key => $val)
		{
			if(!in_array($val,$res))
			{
				$res[]=$val;
			}
		}
	}
	return $res;
}

function def_options($defs,&$opt_array)
{
	foreach ($defs as $defkey => $defval)
	{
		if(empty($opt_array[$defkey]))
			$opt_array[$defkey]=$defval;
	}
}

function ximplode($delimeter,$array,$prefix,$suffix,$options=NULL)
{
	$i=0;
	$str = "";
	foreach($array as $key => $item)
	{
		$itemz = $item;
		$prefixz=strtr($prefix,array('{value}'=>$item,'{key}'=>$key));
		$suffixz=strtr($suffix,array('{value}'=>$item,'{key}'=>$key));
		$delimeterz=strtr($delimeter,array('{value}'=>$item,'{key}'=>$key));
		if($i>0)
		{
			$str = $str.$delimeterz;
		}
		$str=$str.$prefixz.$item.$suffixz;
		$i++;
	}
	return $str;
}

function url_seg_add()
{
	$numargs = func_num_args();
	$arg_list = func_get_args();
	$resstr="";
	foreach ($arg_list as $idx => $arg)
	{
		if((substr($arg,-1)=="/") || (substr($arg,-1)=="\\"))
		{
			$arg = substr($arg,0,-1);
		}
		
		if((substr($arg,0,1)=="/") || (substr($arg,0,1)=="\\") )
		{
			$arg = substr($arg,1,strlen($arg)-1);
		}
		
		if($idx==0)
		{
			$resstr=$arg;
		}
		else 
		{
			$resstr=$resstr."/".$arg;
		}
	}

	return $resstr;
	
}
// добавить точку перед директорией 
function dir_dotted($dir)
{
	if((substr($dir,0,2)=='./') || (substr($dir,0,3)=='../'))
	{
		return $dir;
	}
	return url_seg_add('./', $dir);
}

function get_files_in_folder($dir_path)
{
	$d = dir($dir_path);
	$result=array();
	//	echo "Дескриптор: " . $d->handle . "\n";
	//	echo "Путь: " . $d->path . "\n";
	while (false !== ($entry = $d->read())) {
		if(($entry!="..")&&($entry!="."))
		{
			$filename = url_seg_add($dir_path, $entry);
			
			$result[]=$filename;
			
		}
	}
	$d->close();
	return $result;
}

function unlink_folder($fldr)
{
	$nested_files=get_files_in_folder($fldr);
	foreach ($nested_files as $nested)
	{
		if(is_dir($nested))
			unlink_folder(dir_dotted($nested));
		else 
			chown($nested, 666);
			unlink(dir_dotted($nested));
	}
	chown($fldr, 666);
	//if(file_exists($fldr)) echo ";;;";
	unlink($fldr);
}
// Найти файл
function find_file($search, $dir_path=".", $rootonly=FALSE)
{
	if(!file_exists($dir_path))
	{
		return array();
	}
	$d = dir($dir_path);
	$result=array();
//	echo "Дескриптор: " . $d->handle . "\n";
//	echo "Путь: " . $d->path . "\n";
	while (false !== ($entry = $d->read())) {
		if(($entry!="..")&&($entry!="."))
		{			
			$filename = url_seg_add($dir_path, $entry);
			if($entry==$search)
			{
				$result[]=$filename;
			}
			
			if($rootonly==FALSE)
			{
				if(is_dir($filename))
				{
					
					$result_nested = find_file($search, $filename);
					$result = array_merge($result,$result_nested);
				}
			}
		}
	}
	$d->close();
	return $result;
}

function UcaseFirst($str)
{
	return ucfirst(strtolower($str));
}
//function 
