<?php
class DataRecord	// запись из БД
{
	VAR $_TABLE;
	VAR $_ENV;
	VAR $_MODEL;
	VAR $_FIELDS=array();
	
	function __construct($model,$row_from_db=NULL,$env=array())
	{
	//	$this->res = $res;	
		$this->_MODEL=$model;
		$this->_ENV = $env;
		if($row_from_db!=NULL)
		{			
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
			}
		}
	}
	
	function set_field($fld,$val)
	{
		$this->_FIELDS[$fld]=$val;
	}
	
	function getField($fld)
	{
		return $this->_FIELDS[$fld];
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
	
	function save()
	{

	}
	
	function getFieldNames()
	{
		return array_keys($this->_FIELDS);
	}
	
	function getView()
	{
		//print_r($this->_MODEL);

		return x_make_str( $this->_MODEL->_SETTINGS['view'], $this->_FIELDS);
	}

	function query_insert()
	{

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