<?php 
function gen_base_db_page($tablename,$opts=array())
{
	def_options(array('exclude_flds'=>array(),'editaction'=>'edit','lookups'=>array()),$opts);
	
	ob_start();
	$fields = get_table_fields($tablename);
	$_query_res = make_lookup_query($tablename,$opts['lookups']);
	$rowcode="?>
			<tr>";
	$head="";
	$primary="";
	$ORDER_CODE="";
	$FILTER_CODE="";
	$_FILTERS="";
	foreach ($fields as $fldname => $fld)
	{
		//print_r($fld);
		$thefilter="";
		
		if($fld['Key']=="PRI")
		{
			$primary = $fldname;
		}
		if(!in_array($fldname, $opts['exclude_flds']))
		{
			if(!empty($_query_res['selects'][$fldname]))
			{
				$rowcode = $rowcode."<td><?=\$row[\"".$_query_res['selects'][$fldname]."\"]?></td>";
			}
			else
			{
				$rowcode = $rowcode."<td><?=\$row[\"$fldname\"]?></td>";
			}
			
			add_to_lang($tablename,$fld);
			$fld_capt="<?=\$_capts['$tablename']['$fldname']?>";
			
			$thefilter="";
			$fltr_code="";
			// фильтры
			
			// text
			if(in_array($fld['Type'],array('text','longtext','mediumtext')) || ( substr($fld['Type'],0,strlen('varchar'))=='varchar' ) )
			{
				$filter_body=parse_code_template('filtr_text', array('fld_capt'=>$fld_capt,'fld'=>$fldname));
				$thefilter=parse_code_template('filter_container', array('fld_capt'=>$fld_capt,'fld'=>$fldname,'FILTER'=>$filter_body));
				$fltr_code=parse_code_template('code_filter_text', array('fld'=>$fldname,'table'=>$tablename));
			}
			elseif(substr($fld['Type'],0,strlen('enum'))=='enum')
			{
				$enum_vals = get_enum_field_values($tablename,$fldname);
				foreach ($enum_vals as $val)
				{
					add_to_lang($tablename,"$fldname.enum.$val",$val);	
				}				
				$filter_body=parse_code_template('filtr_enum', array('fld_capt'=>$fld_capt,'table'=>$tablename,'fld'=>$fldname));
				$thefilter=parse_code_template('filter_container', array('fld_capt'=>$fld_capt,'table'=>$tablename,'fld'=>$fldname,'FILTER'=>$filter_body));
				$fltr_code=parse_code_template('code_filter_enum', array('fld'=>$fldname,'table'=>$tablename));
			}
			elseif(!empty($opts['lookups'][$fldname]))
			{
				$filter_body=parse_code_template('filtr_lookup', array('fld_capt'=>$fld_capt,'table'=>$opts['lookups'][$fldname]['table'],'field'=>$fldname,'fld'=>$opts['lookups'][$fldname]['field'],'show'=>$opts['lookups'][$fldname]['show']));
				$thefilter=parse_code_template('filter_container', array('fld_capt'=>$fld_capt,'table'=>$tablename,'fld'=>$fldname,'FILTER'=>$filter_body));
				$fltr_code=parse_code_template('code_filter_lookup', array('fld'=>$fldname,'table'=>$tablename));
			}
			
			$head=$head.parse_code_template('field_th', array('fld_capt'=>$fld_capt,'fld'=>$fldname,'CHAR_UP'=>'&#9660;','CHAR_DOWN'=>'&#9650;','FILTER'=>$thefilter));
			
			$ORDER_CODE = $ORDER_CODE.parse_code_template('field_order', array('fld_capt'=>$fld_capt,'fld'=>$fldname,'table'=>$tablename));
			//"<th>$fld_capt</th>";
			$FILTER_CODE = $FILTER_CODE.$fltr_code;
			
		}
		
	}
	$rowcode = $rowcode."<td><a href=\"".$opts['editaction']."?id=<?=\$row[\"$primary\"]?>\">Edit</a></td>";
	$rowcode = $rowcode."<td><a  href='javascript:' onclick=\"delete_object(<?php echo \$row[\"$primary\"];?>,'Удалить этот объект?','".$opts['editaction']."')\">Удалить</a></td>";
	$rowcode.="
			</tr>
			<?php";
	$code = parse_code_template('list',array('query'=>$_query_res['sql'],'count_query'=>$_query_res['sql_count'],'table'=>$tablename,'rowcode'=>$rowcode,'head'=>$head,
			'filters'=>$_FILTERS,'ORDER_CODE'=>$ORDER_CODE,'FILTER_CODE'=>$FILTER_CODE));
	
	return $code;
}

function make_lookup_query($table,$lookups=array())
{
	$selects="$table.*";
	
	$sql = " FROM $table";
	$_selects_array=array();
	$bind_ctr=1;
	foreach ($lookups as $fld => $loo_item)
	{
		$join_table_name="bind_$bind_ctr";
		$sql_join = " LEFT OUTER JOIN ".$loo_item['table']." as `$join_table_name` ON $table.$fld ={$join_table_name}.".$loo_item['field'];
		$sql= $sql.$sql_join;
		$loo_field = "{$join_table_name}_".$loo_item['show'];
		$selects=$selects.",{$join_table_name}.".$loo_item['show']." as `{$loo_field}`";
		
		$_selects_array[$fld]=$loo_field;
		$bind_ctr++;
	}
	
	$sql_count = "SELECT COUNT(*) as COUNT ".$sql." WHERE \$_FILTER";
	$sql = "SELECT $selects $sql WHERE \$_FILTER";
	
	
	return array('sql'=>$sql,'selects'=>$_selects_array,'sql_count'=>$sql_count);
}

function add_to_lang($table,$fld,$val=NULL)
{
	if(is_array($fld)) return;

	$_capts_file = './inc/__capts.php';
	if($val==NULL)
	{
		$val=$fld;
	}
	
	if(!file_exists($_capts_file))
	{
		file_put_contents($_capts_file,"
<?php
\$_capts=array();
\$_capts['$table']['$fld']='$val';");
	}
	else 
	{
		$capts_code = file_get_contents($_capts_file);
		include $_capts_file;
		if(empty($_capts[$table][$fld]))
		{
			$capts_code = $capts_code."			
\$_capts['$table']['$fld']='$fld';";		
			file_put_contents($_capts_file, $capts_code);
		}
	}
}

function gen_base_editform($tablename,$opts=array())
{
	$fields = get_table_fields($tablename);
	$rowcode='';
	$primary='';
	foreach($fields as $fld => $fldopts)
	{
		$valstr='<?php echo (!empty($'.$tablename.'["'.$fld.'"]) ? $'.$tablename.'["'.$fld.'"]: "" );  ?>';
		if($fldopts['Key']=="PRI")
		{
			$primary="<input type=\"hidden\" name=\"{$tablename}[{$fld}]\" value=\"{$valstr}\" />";
		}
		
		else 
		{
			if(substr($fldopts['Type'],0,strlen('enum'))=='enum')
			{
				$input = parse_code_template('select_opts',array('table'=>$tablename,'field'=>$fld));
				
			}
			elseif(!empty($opts['lookups'][$fld]))
			{
				//print_r($fldopts['lookups'][$fld]);
				$input = parse_code_template('select_lookup',
						array('table'=>$tablename,
								'field'=>$fld,
								'loopkup_table'=>$opts['lookups'][$fld]['table'],
								'lookup_field'=>$opts['lookups'][$fld]['field'],
								'show'=>$opts['lookups'][$fld]['show'],
						));
			}
			else 
			{
				$input = "<input type=\"text\" name=\"{$tablename}[{$fld}]\" value=\"{$valstr}\" />";
			}
			
			add_to_lang($tablename,$fld);
			$fld_capt="<?=\$_capts['$tablename']['$fld']?>";
			$rowcode = $rowcode . "
			<tr><th>{$fld_capt}</th><td>$input</td></tr>					
					";
		}
	}
	
	// контроль обязательных полей
	$error_block="<div class=\"errors\">";
	if(!empty($opts['reqfields']))
	{
		foreach ($opts['reqfields'] as $fld)
		{
			$error_block = $error_block."
			<div id=\"err_{$fld}\" class=\"error\"></div>";			
		}
	}
	$error_block=$error_block."</div>";
	$code = parse_code_template('editform',array('primary'=>$primary,'rows'=>$rowcode,'error_block'=>$error_block,'action'=>$opts['action']));
	return $code;
}

function parse_code_template($filename,$vars)
{
	$tmpl_file = __DIR__.'/code_templates/'.$filename.'.phpt';
	$vars2=array();
	foreach ($vars as $var => $val)
	{
		$vars2['{'.$var.'}']=$val;
	}
	
	return strtr(file_get_contents($tmpl_file),$vars2);
}
// страница едита таблицы
function gen_edit_page($table,$opts)
{
	def_options( array('basedir'=>''), $opts);
	$fields = get_table_fields($table);
	$fld_primary = get_primary($fields);
	
	// контроль обязательных полей
	$fieldcheck="";
	if(!empty($opts['reqfields']))
	{
		foreach ($opts['reqfields'] as $fld)
		{
			$fieldcheck = $fieldcheck."\n\r".parse_code_template('notempty',array('field'=>$fld));
		}
	}
	
	// форма едита
	if(!empty($opts['editform']))
	{
		if(!file_exists($opts['editform']))	
		{
			file_put_contents($opts['editform'], gen_base_editform($table,$opts));
		}
		else 
		{
			
		}
	}
	else 
	{
		$opts['editform']="./inc/form_{$table}.php";
		file_put_contents($opts['editform'], gen_base_editform($table,$opts));
	}
	
	if(empty($opts['view']))
		$_EDIT_TITLE = "\$table['".$opts['view']."']. Редактирование";
	else
		$_EDIT_TITLE = "\$_capts['$table']['__ITEM__'].\" #{$table}['{fld_primary}'].\". Редактирование";
	
	echo $_EDIT_TITLE;
		
	$code = parse_code_template('editpage',array(
			'fld_primary'=>$fld_primary,
			'EDIT_TITLE'=>$_EDIT_TITLE,
			'table'=>$table,
			'basedir'=>$opts['basedir'],
			'edit_page_block'=>$opts['editform'],
			'fieldcheck'=>$fieldcheck));
	return $code;
}
// генерить и едит и обзор
function gen_all($table,$editpage,$listpage,$opts)
{
	def_options( array('basedir'=>''), $opts);
	$opts['action']=$editpage;
	$opts['editaction']=$editpage;
	
	add_to_lang($table,'__TITLE__',$table);
	add_to_lang($table,'__ITEM__',$table);
	$fields = get_table_fields($table);
	$fld_primary = get_primary($fields);
	
	if(empty($opts['view']))
	{
		if(!empty($fields['name']))
		{
			$opts['view']='name';
		}
	}
	
	// контроль обязательных полей
	$fieldcheck="";
	if(!empty($opts['reqfields']))
	{
		foreach ($opts['reqfields'] as $fld)
		{
			add_to_lang($table, "$fld.empty", "$fld could not be empty");
			$fieldcheck = $fieldcheck."\n\r".parse_code_template('notempty',array('field'=>$fld));
		}
	}
	
	// форма едита
	if(!empty($opts['editform']))
	{
		if(!file_exists($opts['editform']))
		{
			file_put_contents($opts['editform'], gen_base_editform($table,$opts));
		}
		else
		{
				
		}
	}
	else
	{
		$opts['editform']="./inc/form_{$table}.php";
		file_put_contents($opts['editform'], gen_base_editform($table,$opts));
	}
	
	
	if(empty($opts['view']))
		$_EDIT_TITLE = parse_code_template('editingtitle',array('fld_primary'=>$fld_primary,'table'=>$table,));		
	else
		$_EDIT_TITLE = "\${$table}['".$opts['view']."'].\" Редактирование\"";
	
	//"\$_capts['$table']['__ITEM__'].\" #\$\".{$table}['{$fld_primary}'].\". Редактирование\"";
	
	file_put_contents($editpage, parse_code_template('editpage',
			array(	'fld_primary'=>$fld_primary,
					'table'=>$table,
					'basedir'=>$opts['basedir'],
					'EDIT_TITLE'=>$_EDIT_TITLE,
					'edit_page_block'=>$opts['editform'],
					'fieldcheck'=>$fieldcheck)));
	
	// блок список
	if(!empty($opts['list']))
	{
		if(!file_exists($opts['list']))
		{
			file_put_contents($opts['list'], gen_base_db_page($table,$opts));
		}
		else
		{
	
		}
	}
	else
	{
		$opts['list']="./inc/{$table}_list.php";
		file_put_contents($opts['list'], gen_base_db_page($table,$opts));
	}
	
	file_put_contents($listpage, parse_code_template('listpage',array('fld_primary'=>$fld_primary,'table'=>$table,'basedir'=>$opts['basedir'],
			'list_page_block'=>$opts['list'],'edit_page_block'=>$opts['editform'])));
	
}

function get_table_fields($tbl)
{
	$result = mysql_query("SHOW COLUMNS FROM `{$tbl}`");
	$arr=array();
	while($col = mysql_fetch_assoc($result)){
	//	print_r($col);
		
		$arr[$col['Field']]=$col;
		//print_r($col); print "<br>\n";
	}
	return $arr;
}

function get_primary($var)
{
	if(is_string($var))
	{
		$var = get_table_fields($tablename);
	}
	
	foreach($var as $fld => $fld_info )
	{
		if($fld_info['Key']=="PRI")
		{
			return $fld;
		}
	}
}
?>