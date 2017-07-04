<?php
define(_CSR_FCODE_EXPIRE_,1000);


class mulForm
{
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
	
	function __construct($action="",$params=array())
	{
	//	print_r($_SESSION);
		def_options(array('method'=>'post'), $params);
		?>
		<form action="<?=$action?>" class="mul_form" method="<?=$params['method']?>" <?php if(!empty($params['target'])) echo 'target="'.$params['target'].'"'; ?>>		
		<?php 
		/*
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