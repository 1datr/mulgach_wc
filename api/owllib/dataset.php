<?php
class DataRecord	// запись из БД
{
	VAR $_TABLE;
	VAR $_ENV;
	VAR $_MODEL;
	
	function __construct($table,$row_from_db=NULL,$env=array())
	{
	//	$this->res = $res;	
		$this->_TABLE=$table;
		$this->_ENV = $env;
		if($row_from_db!=NULL)
		{
			foreach ($row_from_db as $key => $val)
			{
				
			}
		}
	}
	
	function save()
	{

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
		return $row;
	}

	function walk($event_onrow)
	{
		$rowctr=0;
		while($row = $this->next_rec())
		{
			
			$event_onrow($row,$rowctr);
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

	function next_rec()
	{
		//print_r($this);
		$row = $this->_ENV['_CONNECTION']->get_row($this->res);
		$dr = new DataRecord($this->_ENV['model']->_TABLE->_TABLE,$row);
		return $row;
	}
	// пробежка по строкам текущей страницы
	function walk($event_onrow)
	{
		$rowctr=0;
		while($row = $this->next_rec())
		{
			$event_onrow($row,$rowctr);
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