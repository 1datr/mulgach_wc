<?php 
class OtdelController extends BaseController
{
		
	public function ActionIndex($page=1)
	{
		$this->_TITLE="OTDELS";
		$this->add_css($this->get_current_dir()."/../../css/style.css");
		$this->add_css($this->get_current_dir()."/../../css/style2.css");
	//	$this->add_block('LEFT', 'site', 'Blockx');
		$this->add_keyword('workers');
		
		$conn = get_connection();

		$ds = $this->_MODEL->findAsPager(array('page_size'=>10),$page);
		echo "<h3>OTDELS LIST</h3>";
		$this->out_view('index',array('ds'=>$ds));
	}
	
	public function ActionBlockx()
	{
		$this->out_view('blocks/block1',array('i'=>'xXXXx'));
	}
	
	
}
?>