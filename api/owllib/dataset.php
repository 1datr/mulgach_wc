<?php
class DbRecord
{
	VAR $_TABLE;
	VAR $_ENV;
	VAR $_MODEL;
	
	function __construct($row)
	{
		$this->res = $res;
		$this->_ENV = $env;
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

	function __construct($res,$_COUNT,$page,$env)
	{
		$this->res = $res;
		$this->_ENV = $env;
		$this->pages_count=$_COUNT;
		$this->_PAGE=$page;
	}

	function next_rec()
	{
		//print_r($this);
		$row = $this->_ENV['_CONNECTION']->get_row($this->res);
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