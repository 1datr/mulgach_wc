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

function url_seg_add($seg1,$seg2)
{
	if((substr($seg1,-1)=="/") || (substr($seg1,-1)=="\\"))
	{
		$seg1 = substr($seg1,0,-1);		
	}
	
	if((substr($seg2,0,1)=="/") || (substr($seg2,0,1)=="\\") )
	{
		$seg2 = substr($seg2,1,strlen($seg2)-1);
	}
	
	return "{$seg1}/{$seg2}";
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

//function 
