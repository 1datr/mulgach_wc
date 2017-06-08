<?php 
class SiteController extends BaseController
{
		
	public function ActionIndex()
	{
		$this->_TITLE="xxx";
		$this->add_css($this->get_current_dir()."/../../css/style.css");
		$this->add_block('LEFT', 'site', 'Blockx');
		$this->add_keyword('xxx');
		
	/*	$sql = QueryMaker::query_insert('forum', array(array('name'=>'forum1','descr'=>'f1','date'=>'#NOW()'),array('name'=>'forum2','descr'=>'f2','date'=>'#NOW()'),));
		echo $sql;*/
		//print_r($otdel);
		$this->out_view('index',array('i'=>'xXXXx'));
		
		
		//$this->inline_script("alert(999);");
	}
	
	public function ActionBlockx()
	{
		$this->out_view('blocks/block1',array('i'=>'xXXXx'));
	}
	
	public function ActionWorkers()
	{
		$this->_TITLE="Workers";
		$this->add_css($this->get_current_dir()."/../../css/style.css");
		$this->add_block('LEFT', 'site', 'Blockx');
		$this->add_keyword('workers');
		$conn = get_connection();
		$res = $conn->query("SELECT * FROM @+workers");
		while($row=$conn->get_row($res))
		{
			print_r($row);
		}
		echo "<h3>workers</h3>";
	}
	
	public function ActionWorkerlist()
	{
		$this->_TITLE="Workers";
		$this->add_css($this->get_current_dir()."/../../css/style.css");
		$this->add_block('LEFT', 'site', 'Blockx');
		$this->add_keyword('workers');
		$conn = get_connection();
		$res = $conn->query("SELECT * FROM @+workers");
		$arr=array();
		while($row=$conn->get_row($res))
		{
			$arr[]=$row;
		}
		$this->out_json($arr);
	}
}
?>