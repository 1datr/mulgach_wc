<?php
define(_CSR_FCODE_EXPIRE_,1000);


class mulForm
{
	VAR $_CONTROLLER;
	VAR $_UPLOAD_MODE;
	VAR $_MODE;
	VAR $_PARAMS;
	VAR $_NAME_PARTS;
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
	
	function custom_error_div($err_blockname)
	{
		?>
		<div class="error" id='err_<?=$err_blockname ?>' role="alert"></div>
		<?php 
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
	
	function __construct($action="",&$controller,$params=array(),$autoshow=true)
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
		
		def_options(array('method'=>$method,'class'=>"mul_form",'enctype'=>"multipart/form-data"), $params['htmlattrs']);		
		
		$params['htmlattrs']['action']=$action;
		if(isset($params['process']))
			$params['htmlattrs']['process']=$params['process'];
		if(isset($params['pbid']))
			$params['htmlattrs']['pbid']=$params['pbid'];
		
		$this->_PARAMS = $params;
		if($autoshow)
			$this->draw_begin();
	}
	
	function draw_begin()
	{
		?>
		<form <?=xx_implode($this->_PARAMS['htmlattrs'], ' ', '{idx}="{%val}"') ?> >		
		<?php 
		
		$this->_UPLOAD_MODE=$this->get_upload_mode();
	/*	if(isset($params['process']))
		{
			?>
			<div class="progress" class="proc_dlg_box" style="display:none">
			<?php 
		}*/
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
	
	// ������� ������ (���������� �����)
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
	
	function scenario($model_row)
	{
		?>
		<input type="hidden" name="#scenario" value="<?=$model_row->_MODEL->scenario()?>" />
		<?php 
	}
	
	function close()
	{
		?></form><?php 
	}
}