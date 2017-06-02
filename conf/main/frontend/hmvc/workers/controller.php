<?php 
class WorkersController extends BaseController
{
		
	public function ActionIndex()
	{
		$this->_TITLE="Workers";
		$this->add_css($this->get_current_dir()."/css/style.css");
		$this->add_block('LEFT', 'site', 'Blockx');
		$this->add_keyword('workers');
		$conn = get_connection();
		$res = $conn->query("SELECT * FROM @+workers");
		echo "<h3>workers</h3>";
		$this->out_view('index',array('res'=>$res,'conn'=>$conn));
	}
	
	public function ActionBlockx()
	{
		$this->out_view('blocks/block1',array('i'=>'xXXXx'));
	}
	
	public function ActionWorkers()
	{
		
	}
}
?>