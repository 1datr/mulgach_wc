<?php 
class SiteController extends BaseController
{
	
	
	public function ActionIndex()
	{
		$this->add_css($this->get_current_dir()."/css/style.css");
		echo "<h3>ADMINKA</h3>";
	}
	
	public function ActionBlockx()
	{
		echo "<p>12121212
				12212313
				123213</p>";
	}
	
}
?>