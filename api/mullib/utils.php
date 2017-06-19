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
/*
 *    $arr - ������, �������� �������������, �������� ��������
 * 	  $delimeter - �����������
 *    $template - ������. ����� - ������� �� ��������, ����������� ����� - {%val} - �������� (���� �� �����������) {idx} - ������
 *    $onelement - ������� � ����������� &$theval,&$idx,&$thetemplate,&$ctr 
 * */
function xx_implode($arr,$delimeter,$template,$onelement=NULL)
{
	$ctr=0;
	$str="";
	foreach ($arr as $idx => $val)
	{
		$thetemplate = $template;
		$thedelimeter = $delimeter;
		
		if(!is_array($val))
		{			
			$theval["%val"]=$val;
		}
		else 
		{
			$theval=$val;
			
		}
		if($onelement!=NULL)
		{
			
			$onelement($theval,$idx,$thetemplate,$ctr,$thedelimeter);
		}
		$theval["idx"]=$idx;
		
	//	print_r($theval);
		
		$newstr = x_make_str($thetemplate,$theval);
		if($ctr>0)
			$str=$str.$thedelimeter.$newstr;
		else 
			$str=$newstr;
		$ctr++;
	}
	return $str;
}

function x_make_str($str,$ptrn)
{
	$ptrn2=array("{%0}"=>$ptrn);
	if(is_array($ptrn))
	{
		foreach ($ptrn as $key => $val)
		{
			$ptrn2["{".$key."}"]= (string)$val;
		}
	}
	elseif(is_object($ptrn))
	{
		$vars = get_class_vars($ptrn);
		foreach ($vars as $key => $val)
		{
			$ptrn2["{".$key."}"]=$val;
		}
	}
	return strtr($str,$ptrn2);
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
// ������� ���� ���������� ���������
function x_file_put_contents($filename,$data,$flags=0,$context=null)
{
	$parent_path = dirname($filename);
	if(!file_exists($parent_path))
	{
		x_mkdir($parent_path);
	}
	file_put_contents($filename, $data,$flags,$context);
}
// ������� ����� ���������� ���������
function x_mkdir($path)
{
	
	$parent_path = dirname($path);
	if(file_exists($parent_path))
	{		
		mkdir($path);
	}
	else 
	{
		x_mkdir($parent_path);
	}
}
// �������� ����� ����� ����������� 
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
	//	echo "����������: " . $d->handle . "\n";
	//	echo "����: " . $d->path . "\n";
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

function get_nested_dirs($the_dir)
{
	$filelist = get_files_in_folder($the_dir);
	$the_dirs=array();
	foreach ($filelist as $the_file)
	{
		if(is_dir($the_file))
		{
			$the_dirs[]=$the_file;
		}
	}
	return $the_dirs;
}

function string_diff($str1,$str2)
{
	return strtr($str1,array($str2=>''));
}

function filepath2url($path)
{
	global $_BASEDIR;
	return url_seg_add($_BASEDIR,string_diff( strtr($path,array('\\'=>'/')), strtr($_SERVER['DOCUMENT_ROOT'],array('\\'=>'/')) ));
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
// ����� ����
function find_file($search, $dir_path=".", $rootonly=FALSE)
{
	if(!file_exists($dir_path))
	{
		return array();
	}
	$d = dir($dir_path);
	$result=array();
//	echo "����������: " . $d->handle . "\n";
//	echo "����: " . $d->path . "\n";
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

function parse_code_template($tpl_file,$var_array)
{
	foreach ($var_array as $var => $val)
	{
		$$var=$val;
	}

	ob_start();
	if(file_exists($tpl_file))
		include $tpl_file;
	
	$code = ob_get_clean();
		// php tags
	$code = strtr($code,array('<#'=>'<?','#>'=>'?>'));

	$var_array2=array();
	foreach ($var_array as $var => $val)
		{
			$var_array2['{'.$var.'}']=$val;
		}
	return strtr($code,$var_array2);
}

function UcaseFirst($str)
{
	return ucfirst(strtolower($str));
}
//function 
