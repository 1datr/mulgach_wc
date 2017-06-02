<?php
function get_enum_field_values($table,$column)
{
	$result = mysql_query("SHOW COLUMNS FROM `$table`  LIKE '$column'");
	if ($result) 
	{
		$row = mysql_fetch_assoc($result);
		$option_array = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $row['Type']));
		return $option_array;
	}
	return null;
}

function array_to_input($array, $prefix='',$exclude=array()) {
	if( (bool)count(array_filter(array_keys($array), 'is_string')) ) {
		foreach($array as $key => $value) {
			if( empty($prefix) ) {
				$name = $key;
			} else {
				$name = $prefix.'['.$key.']';
			}
			if( is_array($value) || key_exists($key, $exclude) ) {
				array_to_input($value, $name);
			} else { ?>
        <input type="hidden" value="<?php echo $value ?>" name="<?php echo $name?>">
      <?php }
    }
  } else {
    foreach($array as $item) {
      if( is_array($item) ) {
        array_to_input($item, $prefix.'[]');
      } else { ?>
        <input type="hidden" name="<?php echo $prefix ?>[]" value="<?php echo $item ?>">
      <?php }
    }
  }
}

function array_to_hidden($array_to_out,$exclude=array(),$prefix='')
{
	
	foreach($array_to_out as $key => $item)
	{
		if(!in_array($key, $exclude) || key_exists($key, $exclude))
		{
			if(is_array($item) )
			{
				
				if($prefix=="")
					$newkey = "{$key}";
				else
					$newkey = "{$prefix}[{$key}]";
				array_to_hidden($item,array(),$newkey);
			}
			else
			{
				$name=$key;
				if($prefix!="")
					$name="{$prefix}[{$key}]";
				?>
				<input type="hidden" name="<?=$name?>" value="<?=$item?>">
				<?php 
			}			
		}
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

function cut_string_dots($thestring,$len)
{
	if(strlen($thestring)>$len)
		return substr($thestring,0,$len)."...";
	else
		return $thestring;
}
// option string from array
function implode_opts_array($array,$value_fld,$capt_fld,$current_id=NULL)
{	
	$str = "";
	foreach($array as $item)
	{
		if($value_fld==NULL) $_value=$item; 
		else $_value=$item[$value_fld];
		
		if($capt_fld==NULL) $_capt=$item;
		else $_capt=$item[$capt_fld];
		
		if($current_id==$_value)
		{
			$str = $str."<option value=\"{$_value}\" selected>{$_capt}</option>";
		}
		else 
			$str = $str."<option value=\"{$_value}\">{$_capt}</option>";		
	}
	return $str;
}

function delete_from_table($table,$where=1)
{
	mysql_query("DELETE FROM $table WHERE $where");
}

function normalize_opts($options)
{
	$optionfields = array('checkboxes','quoteless','files');
	foreach ($optionfields as  $fld)
	{
		if(empty($options[$fld]))
		{
			$options[$fld]=array();
		}
	}
	return $options;
}

// make update query
/*
'checkboxes' - array with checkbox fields
'quoteless' - array of fields without quotes
*/
function make_update_form_sql($table,$dataarray,$where=1,$options=Array())
{
	$options = normalize_opts($options);
	//print_r($dataarray);
	// РІСЃРµ С‡РµРєР±РѕРєСЃРЅС‹Рµ РЅР° 1 РёР»Рё 0
	foreach ($options['checkboxes'] as $fld)
	{
		if(!empty($dataarray[$fld]))
			$dataarray[$fld]=1;
			else
				$dataarray[$fld]=0;
	}
	
	$fields = implode(',',array_keys($dataarray));
	$sql = "UPDATE {$table} SET ";
	$i=0;
	//print_r($options['quoteless']);
	foreach($dataarray  as $fld => $val)
	{
		if((!empty($options['quoteless'][$fld])) ||  (in_array($fld, $options['quoteless'])))
			$fld_sql = "`$fld` = $val";
		else
			$fld_sql = "`$fld` = '$val'";
		
	 	if($i>0)
	 		$sql = $sql.','.$fld_sql;
	 	else
	 		$sql = $sql.$fld_sql;
	 	
	 	$i++;
	}
	// РїСЂРѕС…РѕРґ РїРѕ С„Р°Р№Р»Р°Рј
	foreach($options['files'] as $file_descr)
	{
		//print_r( $_FILES[$file_descr]["tmp_name"]);
		if(!empty($_FILES[$file_descr]["tmp_name"]))
		{
			$blob_content = addslashes(file_get_contents($_FILES[$file_descr]["tmp_name"]));
			if($i>0)
				$sql=$sql.",";
			
			$sql=$sql."`$file_descr`='$blob_content'";
			$i++;
		}
	}
	
	return $sql." WHERE $where";
}

function make_insert_sql($table,$fields,$dataarray)
{
	$fields_array = explode(',',$fields);
	$sql = "INSERT INTO {$table}({$fields}) VALUES (";
	$i=0;
	foreach($fields_array  as $fld)
	{
		$fld_sql = "'".$dataarray[$fld]."'";
		if($i>0)
			$sql = $sql.','.$fld_sql;
			else
				$sql = $sql.$fld_sql;
				$i++;
	}
	$sql = $sql.")";
	return $sql;
}

function make_insert_form_sql($table,$dataarray,$options=Array())
/*
 $options
 'checkboxes' - array with checkbox fields 
 'quoteless' - array of fields without quotes
 * */
{	
	$options = normalize_opts($options);
	//print_r($dataarray);
	// РІСЃРµ С‡РµРєР±РѕРєСЃРЅС‹Рµ РЅР° 1 РёР»Рё 0
	foreach ($options['checkboxes'] as $fld)
	{
		if(!empty($dataarray[$fld])) 
			$dataarray[$fld]=1;
		else 
			$dataarray[$fld]=0;
	}
	
	$fields = ximplode(',', array_merge(array_keys($dataarray),$options['files']), "`", "`");
	$sql = "INSERT INTO {$table}({$fields}) VALUES (";
	$i=0;
	//print_r($options['files']);
	//print_r($_FILES);
	foreach($dataarray  as $fld => $val)
	{
		if(in_array($fld, $options['quoteless']))			
			$fld_sql = "$val";		
		else 
			$fld_sql = "'$val'";
		
		if($i>0)
			$sql = $sql.','.$fld_sql;
		 else
		 	$sql = $sql.$fld_sql;
		 	$i++;
	}
	// РїСЂРѕС…РѕРґ РїРѕ С„Р°Р№Р»Р°Рј
	if(!empty($options['files']))
	foreach($options['files'] as $file_descr)
	{
		//print_r( $_FILES[$file_descr]["tmp_name"]);
		$blob_content = addslashes(file_get_contents($_FILES[$file_descr]["tmp_name"]));
		if($i>0)
			$sql=$sql.",";
		$sql=$sql."'$blob_content'";
		$i++;
	}
	$sql = $sql.")";
	return $sql;
}

function build_url($str_base,$str_add)
{
	$pos = strpos($str_base, '?');
	if ($pos === false)
		return $str_base."?".$str_add;
	
	return $str_base."&".$str_add;
}

function def_options($defs,&$opt_array)
{
	foreach ($defs as $defkey => $defval)
	{
		if(empty($opt_array[$defkey]))
			$opt_array[$defkey]=$defval;
	}
}

function auth_user_db($usr,$passw,$options=array())
{
	global $connection;
	def_options(array('table'=>'crm_workers','userfld'=>'login','pwdfld'=>'password'), $options);
	$sql="SELECT * FROM ".$options['table']." WHERE ".$options['userfld']."='$usr' AND ".$options['pwdfld']."='$passw'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)>0)
	{
		$row = mysql_fetch_assoc($res);
		unset($_SESSION['err_msg']);
		$_SESSION['user']=$row;
		return true;
	}
	$_SESSION['err_msg']="Неверное имя пользователя или пароль";
	return false;
}

function auth_user_db_admin($usr,$passw,$options=array())
{
	global $connection;
	def_options(array('table'=>'crm_workers','userfld'=>'login','pwdfld'=>'password','statusfld'=>'position','admin_sate'=>'Админ'), $options);
	$sql="SELECT * FROM ".$options['table']." WHERE ".$options['userfld']."='$usr' AND ".$options['pwdfld']."='$passw' AND ".$options['statusfld']."='".$options['admin_sate']."'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)>0)
	{
		$row = mysql_fetch_assoc($res);
		unset($_SESSION['err_msg']);
		$_SESSION['admin']=$row;
		return true;
	}
	$_SESSION['err_msg']="Неверное имя пользователя или пароль";
	return false;
}

function include_template($filepath,$vars)
{
	foreach($vars as $varname => $varval)
	{
		$$varname = $varval;
		
	}
	ob_start();
	include $filepath;
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

function json_fix_cyr($var)
{
	if (is_array($var)) {
		$new = array();
		foreach ($var as $k => $v) {
			$new[json_fix_cyr($k)] = json_fix_cyr($v);
		}
		$var = $new;
	} elseif (is_object($var)) {
		$vars = get_object_vars($var);
		foreach ($vars as $m => $v) {
			$var->$m = json_fix_cyr($v);
		}
	} elseif (is_string($var)) {
		$var = iconv('cp1251', 'utf-8', $var);
	}
	return $var;
}

function out_query_select($select_q,$opts=array())
{
	$code = "";
	$workers_res=mysql_query($select_q);
	GLOBAL $_DIR;
	if(!empty($opts['all']))
	{
		$_VAL="";
		$_SEL="";
		$_CAPT="Все";
		if($opts['current']=='')
		{
			$_SEL="selected";
		}	
		$code = include_template(__DIR__.'/../templates/option.php',get_defined_vars());
	}
	while($row = mysql_fetch_assoc($workers_res))
	{
		$_VAL=$row[$opts['val']];
		$_SEL="";
		if($opts['current']==$_VAL)
			$_SEL="selected";
		$_CAPT=$row[$opts['capt']];
		$code = $code."
		".include_template(__DIR__.'/../templates/option.php',get_defined_vars());

	}
	return $code;
}

function get_min_in_rows($rows,$key,&$min_idx,$opts=array())
{
	$min = NULL;
	foreach($rows as $idx => $row)
	{
		$val=$row[$key];
		if(!empty($opts['emptyval']))
		{
			if($val==$opts['emptyval'])
			{
				continue;
			}
		}
		
		if(($min==NULL)||($val<$min))
		{
			$min_idx = $idx;
			$min=$val;
		}
	}
	return $min;
}

/**
 * date_diff - функция вычисляет разницу между двумя датами в секундах
 *
 * @param string date1 - дата 1
 * @param string date2 - дата 2
 *
 * @return int - разница в секундах
 *
 * Дата должна быть определенного формата,
 * советую ознакомится с функций strtotime()
 * http://docs.php.net/manual/ru/function.strtotime.php
 *
 */
function _date_diff($date1, $date2)
{
	$diff = strtotime($date2) - strtotime($date1);
	return abs($diff);
}

function date_before_now($datestr)
{
	return strtotime("now")-strtotime($datestr);
}

// парсер url
class url_parser
{
	var $scheme;
	var $host;
	var $user;
	var $passw;
	var $path;
	var $fragment;
	var $params;
	function __construct($URL=NULL)
	{
		if ($URL==NULL)
			$URL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		$url_parses = parse_url($URL);
		
		$this->scheme = $url_parses['scheme'];
		$this->host = $url_parses['host'];
		$this->user = $url_parses['user'];
		$this->passw = $url_parses['passw'];
		$this->path = $url_parses['path'];
		$this->fragment = $url_parses['fragment'];
		parse_str($url_parses['query'],$this->params);		
	}
	
	function make_url()
	{
		$str_user = "";
		if(!empty($this->user))
			$str_user = "{$this->user}:{$this->pass}@";
		$query_str = http_build_query($this->params);
			
		$str = $this->scheme."://{$str_user}{$this->host}{$this->path}";
		if(!empty($query_str))
			$str="{$str}?{$query_str}";
		return $str;
	}
	
	function make_changed_url($newvars,$delete=array())
	{
		$str_user = "";
		if(!empty($this->user))
			$str_user = "{$this->user}:{$this->pass}@";
		
		$params_2 = $this->params;
		// add vars
		foreach ($newvars as $key => $val)
		{
			$params_2[$key]=$val;
		}
		// delete vars
		foreach ($delete as $del_fld)
		{
			unset($params_2[$del_fld]);
		}
		$query_str = http_build_query($params_2);
				
		$str = $this->scheme."://{$str_user}{$this->host}{$this->path}";
		if(!empty($query_str))
			$str="{$str}?{$query_str}";
		return $str;
	}
}

function make_changed_url()
{
	
}

class subsession
{
	var $sblock_name;
	var $ID;
	static function gen_new_ssid()
	{
		
	}
	
	function __construct($ssid=NULL)
	{
		if($ssid==NULL)
		{
			$this->ID=subsession::gen_new_ssid();
		}
		else 
			$this->ID = $ssid;
		$this->sblock_name = "ss_".$this->ID;
		$_SESSION[$this->sblock_name]=array(
			'_LASTTIME'=>time(),
		);
	}
	
	function get_var($var)
	{
		if(!empty($_SESSION[$this->sblock_name][$var]))
			return $_SESSION[$this->sblock_name][$var];
		else 
			return NULL;
	}
	
	function put_var($var,$val)
	{
		$_SESSION[$this->sblock_name][$var] = $val;
	}
}
?>