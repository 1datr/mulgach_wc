<?php 
class OtdelController extends BaseController
{
		
	public function ActionIndex()
	{
		$this->_TITLE="OTDELS";
		$this->add_css($this->get_current_dir()."/../../css/style.css");
		$this->add_css($this->get_current_dir()."/../../css/style2.css");
	//	$this->add_block('LEFT', 'site', 'Blockx');
		$this->add_keyword('workers');
		
		$conn = get_connection();
		
		$sql = $this->_MODEL->select_query();
	//	echo $sql;
		$res = $conn->query($sql);
		
		echo "<h3>OTDELS LIST</h3>";
		$this->out_view('index',array('res'=>$res,'conn'=>$conn));
	}
	
	public function ActionBlockx()
	{
		$this->out_view('blocks/block1',array('i'=>'xXXXx'));
	}
	
	
}
?>