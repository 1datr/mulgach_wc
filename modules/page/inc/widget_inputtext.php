<?php
use \Widget;

	class InputTextWidget extends \Widget 
	{
		function out($params=array())
		{
			def_options(array('data'=>array(),'htmlattrs'=>array()), $params);
			$params['htmlattrs']['type']='text';
			if(!empty($params['name']))	$params['htmlattrs']['name'] = $params['name'];
			if(!empty($params['value']))	$params['htmlattrs']['value'] = $params['value'];
			?>
			<input <?=$this->get_attr_str($params['htmlattrs'])?> />			
			<?php

		}
	}

?>
