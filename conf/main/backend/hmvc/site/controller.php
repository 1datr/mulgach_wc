<?php 
class SiteController extends BaseController
{

	public function ActionIndex()
	{
		$this->redirect('?r=workers');
	}
	
	
}
?>