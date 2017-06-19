<?php
class mulForm
{
	function __construct($action="",$params=array())
	{
		def_options(array('method'=>'post'), $params);
		?>
		<form action="<?=$action?>" class="mul_form" method="<?=$params['method']?>" <?php if(!empty($params['target'])) echo 'target="'.$params['target'].'"'; ?>>		
		<?php 
	}
	
	function submit($caption,$name='',$htmlattrs=array())
	{
		def_options(array('type'=>'submit'),$htmlattrs );
		if($name!='')
		{
			$htmlattrs['name']=$name;
		}
		$htmlattrs['value']=$caption;
		?>
		<input <?=xx_implode($htmlattrs, ' ', '{idx}="{%val}"')?> />
		<?php 
	}
	
	function close()
	{
		?></form><?php 
	}
}