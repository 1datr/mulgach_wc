<#php 
class {table_uc_first}Controller extends BaseController
{
		
	public function ActionIndex($page=1)
	{
		$this->_TITLE="{TABLE_UC}";
	
		$conn = get_connection();

		$ds = $this->_MODEL->findAsPager(array('page_size'=>10),$page);
		echo "<h3>{TABLE_UC} LIST</h3>";
		$this->out_view('index',array('ds'=>$ds));
	}
	
	public function ActionCreate()
	{
		$this->_TITLE="CREATE {TABLE_UC}";
		$this->out_view('itemform',array());
	}
	
	public function ActionEdit($id)
	{
		$this->_TITLE="EDIT {TABLE_UC}";
		${table} = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id"); 
		$this->out_view('itemform',array('{table}'=>${table}));
	}
	
	public function ActionSave()
	{
	
	}
		
}
#>