<?php
class DataRecord	// запись из БД
{
	VAR $_TABLE;
	VAR $_ENV;
	VAR $_MODEL;
	VAR $_FIELDS=array();
	VAR $_MODIFIED=false;
	VAR $_DB=true;
	VAR $_EXISTS_IN_DB=false;
	
	function __construct($model,$row_from_db=NULL,$env=array())
	{
	//	$this->res = $res;	
		$this->_MODEL=$model;
		$this->_ENV = $env;
		if($row_from_db!=NULL)
		{	
			//$selected_row = $this->_MODEL->findOne("");
			
			foreach ($row_from_db as $key => $val)
			{				
				
				$fld_base = $this->contains_fld($key);
				if($fld_base!=NULL)	// составное поле через ->
				{
					$rewrite_nested=false;
					if(empty($this->_FIELDS[$fld_base['fld']])) 
						$rewrite_nested = true;
					if(is_object($this->_FIELDS[$fld_base['fld']]))	
					{
						if( get_class($this->_FIELDS[$fld_base['fld']])!='DataRecord')  // не добавлен в поля либо он не запись 
							$rewrite_nested = true;
					}
					else 
						$rewrite_nested = true;
					
					if($rewrite_nested)	
					{
						if(!empty($this->_MODEL->_SETTINGS['constraints'][$fld_base['fld']]))
						{
							$constraint = $this->_MODEL->_SETTINGS['constraints'][$fld_base['fld']];
							$model_nested = $this->_MODEL->get_model($constraint['model']);
							$dr_nested = new DataRecord($model_nested,NULL,$env); 
								
							$_fld_nested = $fld_base['fld_nested'];
							$dr_nested->set_field($_fld_nested,$val);
								
							$_fld_base = $fld_base['fld'];
							$this->set_field($_fld_base,$dr_nested);
						}						
					}
					else 
					{
						$_fld_base = $fld_base['fld'];
						$_fld_nested = $fld_base['fld_nested'];
						$this->_FIELDS[$_fld_base]->set_field($_fld_nested,$val);
					}
				}
				else 
				{
					$this->set_field($key,$val);
				}
				$this->_EXISTS_IN_DB=true;
			}
		}
		else 
		{
			foreach($this->_MODEL->_SETTINGS['fields'] as $fldname => $fldinfo)
			{
				$this->set_field($fldname, '');
			}
		}
		$this->_MODIFIED=false;
	}
	
	function FillFromArray($val_array)
	{
		foreach ($val_array as $key => $val)
		{
			$this->set_field($key, $val);
			$this->_MODIFIED=true;
		}
	}
	
	function set_field($fld,$val)
	{
		if(isset($this->_MODEL->_SETTINGS['file_fields'][$fld]))
		{
			if($val=='#exists')
				return ;
		}
		$this->_FIELDS[$fld]=$val;
		$this->_MODIFIED=true;
	}
	
	function FieldExists($fld)
	{
		return array_key_exists($fld,$this->_FIELDS);
	}
	
	function setField($fld,$val)
	{
		if($this->FieldExists($fld))
			$this->set_field($fld,$val);		
	}
	
	function format_html($fldval,$flags=NULL)
	{
		if($flags==NULL) $flags=(ENT_COMPAT | ENT_HTML401);
		return htmlentities($fldval,$flags);
	}
	
	function Modified()
	{
		return $this->_MODIFIED;
	}
	
	function getField($fld,$format_val=true,$format=NULL)
	{
		if($format==NULL) $format = (ENT_COMPAT | ENT_HTML401);
		$val = $this->_FIELDS[$fld];
		if($format_val==true)
		{
			if(is_array($val) || is_object($val)) return $val;
			$val = $this->format_html($val,$format);
		}
		return $val;
	}
	
	function getPrimary()
	{
		return $this->_FIELDS[$this->_MODEL->_SETTINGS['primary']];
	}
	
	function foreach_fields($onfield)
	{
		foreach ($this->_FIELDS as $fld => $val)
		{
			$onfield($fld,$val);
		}
	}
	
	function contains_fld($fldname)
	{
		$splitted = explode('->', $fldname);
		if(count($splitted)>1)
		{
			return array('fld'=>$splitted[0],'fld_nested'=>$splitted[1]);
		}
		return NULL; 
			
	}
	
	function escape_array(&$fields,$fld_map)
	{
		foreach ($fields as $key => $val)
		{
			//
			$fields[$key]=$this->_MODEL->_ENV['_CONNECTION']->escape_val($val,$fld_map[$key]);
		}
	}
		
	function save($files_fields_controll=true)
	{
		if(! $this->_MODIFIED)
			return ;
		
		$validres = $this->_MODEL->validate([$this->_MODEL->_TABLE => $this->getFields()]);
		//mul_dbg($validres);
		if(count($validres))
		{
			return;
		}
		
		$this->_MODEL->OnSave($this);
		//$fld_values = $this->getFields();
		$fld_map = $this->_MODEL->_SETTINGS['fields'];
		
		$inserting=false;
		if($this->getField($this->_MODEL->_SETTINGS['primary'])!=NULL)
		{			
			$primary = $this->_MODEL->getPrimaryName();
			$WHERE="`{$primary}`='".$this->getPrimary()."'";
			unset($fld_values[$primary]);
			if($files_fields_controll)
				$this->_MODEL->files_before_update($this);	
			$fld_values = $this->getFields();
			$this->escape_array($fld_values,$fld_map);
			$sql = QueryMaker::query_update($this->_MODEL->_TABLE,$fld_values,$WHERE);
			
		}
		else 
		{
			unset($fld_values[$this->_MODEL->getPrimaryName()]);
			$inserting=true;
			$fld_values = $this->getFields();
			$this->escape_array($fld_values,$fld_map);
			$sql = QueryMaker::query_insert($this->_MODEL->_TABLE, $fld_values);
		}
	//	mul_dbg($sql);
		//echo $sql;
		$this->_EXISTS_IN_DB=true;
		$insert_res = $this->_MODEL->_ENV['_CONNECTION']->query($sql);
		
		$newid = $this->_MODEL->_ENV['_CONNECTION']->last_insert_id();
		$this->setField($this->_MODEL->_SETTINGS['primary'],$newid);
		
		$this->_MODIFIED=false;
		
		if($inserting)
		{			
			if($files_fields_controll)
				$this->_MODEL->files_after_insert($this);
		}
		else 
		{
			
		}
		
		
	}
	
	public function draw_def_form($form)
	{
		?>
		<table>
		<?php 
		foreach($this->_FIELDS as $fld => $value)
		{
			?>
			
			<?php 
			$finfo = $this->_MODEL->getFldInfo($fld);
			if(eql_ife($finfo,'hidden',true))
			{
				$form->field($this,$fld)->hidden($fparams);
			}
			else 
			{
				?>
				<tr>
				<th><?=Lang::__t($this->_MODEL->_SETTINGS['domen'].'.'.$fld)?></th>
    			<td><?php 
    			
    			$fparams=[];
    			if(isset($finfo['fldparams']))
    				$fparams=$finfo['fldparams'];
    			if($finfo['Type']=='enum')
    			{
    				$form->field($this,$fld)->ComboBox([],$fparams);
    			}
    			elseif(eql_ife($finfo,'password',true))
    			{
    				$form->field($this,$fld)->password($fparams);
    			}
    			else 
    			{
    				$form->field($this,$fld)->text($fparams);
    			}
    			
    			?>
    			</td>	
    			</tr>			
				<?php 
			}
			?>    			
  			
			<?php 
		}
		?>
		</table>
		<?php 
	}
	
	function getFieldNames()
	{
		return array_keys($this->_FIELDS);
	}
	
	
	function getFields()
	{
		return $this->_FIELDS;
	}
	
	function getView($format_val=true,$format=NULL)
	{
		if($format==NULL) $format = (ENT_COMPAT | ENT_HTML401);
		$view = x_make_str( $this->_MODEL->_SETTINGS['view'], $this->_FIELDS);
		if($format_val)
			$view = $this->format_html($view,$format);
		
		return $view;
	}

	function query_insert()
	{

	}
	
	function __toString()
	{
		return $this->getView();
	}
	
}

class DataSet
{
	VAR $res;
	VAR $_ENV;
	VAR $total_count;
	
	function __construct($res,$env)
	{
		$this->res = $res;
		$this->_ENV = $env;
	}

	function next_rec()
	{
		//print_r($this);
		$row = $this->_ENV['_CONNECTION']->get_row($this->res);
		if($row==false)
			return NULL;
		$dr = new DataRecord($this->_ENV['model'],$row,$this->_ENV);		
		return $dr;
	}

	function walk($event_onrow,$event_onhead=NULL)
	{
		$rowctr=0;
		while($rec = $this->next_rec())
		{
			if($rowctr==0)
			{
				if($event_onhead!=NULL)
					$event_onhead($rec->getFieldNames());
			}
			$event_onrow($rec,$rowctr);
			$rowctr++;
		}
	}
}

class PageDataSet extends DataSet 
{
	VAR $res;
	VAR $_ENV;
	VAR $pages_count;
	VAR $_PAGE;
	VAR $total_count;

	function __construct($params)
	{
		$this->res = $params['res'];
		$this->_ENV = $params['env'];
		$this->pages_count=$params['pagecount'];
		$this->_PAGE=$params['page'];
		$this->total_count=$params['total_count'];
	}

	// пробежка по строкам текущей страницы
	function walk($event_onrow,$event_onhead=NULL)
	{
		$rowctr=0;
		while($rec = $this->next_rec())
		{
			if($rowctr==0)
			{
				if($event_onhead!=NULL)
					$event_onhead($rec->getFieldNames());
			}
			$event_onrow($rec,$rowctr);
			$rowctr++;
		}
	}
	
	function draw_pager($event_ondrawpage)
	{
		if($this->pages_count==1)
		{
			
		}
		else 
		{
			for($page=1;$page<=$this->pages_count;$page++)
			{
				$arr=array('pages_count'=>$this->pages_count,'current_page'=>$this->_PAGE);
				$event_ondrawpage($page,$arr);
			}
		}
	}
}

class TreeDataSet extends DataSet
{
	
}