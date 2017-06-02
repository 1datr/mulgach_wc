<?php 
class IndexController extends BaseController
{
		
	public function ActionIndex()
	{
		$this->_TITLE="FORUM";
		$this->add_css($this->get_current_dir()."/css/style.css");
		$this->add_block('LEFT', 'site', 'Blockx');
		$this->add_keyword('xxx');
		
		echo "<h3>forums</h3>";
		$this->add_keyword('workers');
		$conn = get_connection();
		$res = $conn->query("SELECT * FROM @+forum");
		while($row=$conn->get_row($res))
		{
			print_r($row);
		}	
		
		$this->out_view('index',array('i'=>'xXXXx'));
	}
	
}
?>