<?php
// ������ ��������

class mul_jquery_ui extends mul_jquery 
{
	VAR $name;
	
	
	
	
	function mulgach_hmvc_before_html(&$args)
	{
		$args['JS']=array($this->get_module_dir()."/assets/js/jquery.min.js");;
	}

	
	
}


