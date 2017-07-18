<?php
define(_CSR_FCODE_EXPIRE_,1000);


class mulForm
{
	VAR $_CONTROLLER;
	VAR $_UPLOAD_MODE;
	VAR $_MODE;
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
		$newfld->_CONTROLLER = $this->_CONTROLLER;
		$newfld->_FORM = $this;
		return $newfld;
	}
	
	function get_upload_mode()
	{
		$res = 'simple';
		$session__upload_progress__enabled = ini_get('session.upload_progress.enabled');
		//mul_dbg($session__upload_progress__enabled);
		$session__upload_progress__cleanup = ini_get('session.upload_progress.cleanup');
		//mul_dbg($session__upload_progress__cleanup);
		$session__upload_progress__prefix = ini_get('session.upload_progress.prefix');
		//mul_dbg($session__upload_progress__prefix);
		$session__upload_progress__name = ini_get('session.upload_progress.name');
		//mul_dbg($session__upload_progress__name);
		$session__upload_progress__freq = ini_get('session.upload_progress.freq');
		//mul_dbg($session__upload_progress__freq);
		$session__upload_progress__min_freq = ini_get('session.upload_progress.min_freq');
		//mul_dbg($session__upload_progress__min_freq);
		return $res;
	}
	
	function __construct($action="",&$controller,$params=array())
	{
	//	print_r($_SESSION);
		$this->_CONTROLLER = $controller;
		def_options(array('htmlattrs'=>array(),'mode'=>'post'), $params);
		$this->_MODE = $params['mode'];
		if($params['mode']=='post')
		{
			$method='post';
		}
		else 
		{
			$method='get';
		}
		
		def_options(array('method'=>$method,'class'=>"mul_form",'enctype'=>"multipart/form-data"), $params['html_attrs']);		
		
		$params['html_attrs']['action']=$action;
		?>
		<form <?=xx_implode($params['htmlattrs'], ' ', '{idx}="{%val}"') ?> >		
		<?php 
		/*
		 <form action="<?=$action?>" class="mul_form" method="<?=$params['method']?>"  enctype="multipart/form-data" <?php if(!empty($params['target'])) echo 'target="'.$params['target'].'"'; ?>> 
		 
		list($csrf_key,$csrf_val) = $this->make_csrf($action);
		echo "<input type=\"hidden\" name=\"".$csrf_key."\" value=\"".$csrf_val."\" />";
		*/
		$this->_UPLOAD_MODE=$this->get_upload_mode();
		if($this->_UPLOAD_MODE=='progress')
		{
		
		?>
			<div class="progress" id="mul_form_progress" style="display:none">
			<div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		<?php
		}
		else 
		{
			?>
			<div class="progress" id="mul_form_progress" style="display:none">
			<image src="<?=filepath2url(url_seg_add(__DIR__,'../img/ajax_loader.gif')) ?>" />
			</div>
			<?php 
		}
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