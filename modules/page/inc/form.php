<?php
define(_CSR_FCODE_EXPIRE_,1000);


class mulForm
{
	VAR $_CONTROLLER;
	static function check_form($_POST_ARRAY)
	{
		if(!empty($_SESSION['csrf_codes']))
		{
			foreach ($_SESSION['csrf_codes'] as $key => $info)
			{
				if(isset($_POST_ARRAY[$key]))
				{
					$res = ($_POST_ARRAY[$key]==$info['value']);					
					if($_POST_ARRAY[$key]==$info['value'])
					{
					//	echo "XXX";
					//	unset($_SESSION['csrf_codes'][$key]);
						return true;
					}
				}
			}
		}
		return false;
	}
	
	function field($model,$fld_name,$opts=array())
	{
		$newfld = new ActiveField($model, $fld_name, $opts);
		return $newfld;
	}
	
	function __construct($action="",&$controller,$params=array())
	{
	//	print_r($_SESSION);
		$this->_CONTROLLER = $controller;
		def_options(array('html_attrs'=>array()), $params);
		def_options(array('method'=>'post','class'=>"mul_form",'enctype'=>"multipart/form-data"), $params['html_attrs']);
		$params['html_attrs']['action']=$action;
		?>
		<form <?=xx_implode($params['html_attrs'], ' ', '{idx}="{%val}"') ?> >		
		<?php 
		/*
		 <form action="<?=$action?>" class="mul_form" method="<?=$params['method']?>"  enctype="multipart/form-data" <?php if(!empty($params['target'])) echo 'target="'.$params['target'].'"'; ?>> 
		 
		list($csrf_key,$csrf_val) = $this->make_csrf($action);
		echo "<input type=\"hidden\" name=\"".$csrf_key."\" value=\"".$csrf_val."\" />";
		*/
		?>
		
		<?php 
	}
	
	function make_csrf($action)
	{
		$csrf_key = GenRandStr(rand(10,20));
		$csrf_val = GenRandStr(rand(10,20));
		if(!isset($_SESSION['csrf_codes']))
		{
			$_SESSION['csrf_codes']=array();			
		}
		$this->trash();
		$_SESSION['csrf_codes'][$csrf_key]=array('value'=>$csrf_val,'time_start'=>time(),'action'=>$action);
		return array($csrf_key,$csrf_val);
	}
	
	// сборщик мусора (устаревших кодов)
	function trash()
	{
		if(isset($_SESSION['csrf_codes']))
		{
			foreach ( $_SESSION['csrf_codes'] as $key => $info)
			{
				if( (time()-$info['time_start']) > _CSR_FCODE_EXPIRE_)
				{
					unset($_SESSION['csrf_codes'][$key]);
				}
			}
		}
	}
	
	function submit($caption,$name='',$htmlattrs=array())
	{
		def_options(array('type'=>'submit','class'=>'btn btn-primary'),$htmlattrs );
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