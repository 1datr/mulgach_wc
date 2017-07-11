<?php
class ActiveField
{
	VAR $_ROW;
	VAR $_FLDNAME;
	VAR $_OPTIONS;
	VAR $_ENV;
	VAR $_CONTROLLER;
	function __construct($row,$name,$opts=array())
	{
		$this->_ROW=$row;
		$this->_FLDNAME=$name;
		$this->_OPTIONS=$opts;
	}
	
	function get_attr_str($attrlist)
	{
		return xx_implode($attrlist,' ','{idx}="{%val}"',
				function(&$val,&$idx,&$thetemplate,&$ctr){
					if( in_array($idx, array('selected','checked')) )
					{
						$thetemplate='{idx}';
					}
				});
	}
	
	function error_div()
	{
		?>
		<div class="error" id='err_<?=$this->_FLDNAME ?>' role="alert"></div>
		<?php 
	}
	
	function text($opts=array())
	{
		def_options(array('htmlattrs'=>array()), $opts);
		$opts['htmlattrs']['type']='text';
		if(!isset($opts['name']))
			$opts['htmlattrs']['name']= $this->_ROW->_MODEL->_TABLE.'['.$this->_FLDNAME.']';
		else
			$opts['htmlattrs']['name']= $opts['name'];
		
		$opts['htmlattrs']['value']=$this->_ROW->getField($this->_FLDNAME);
		?>
		<input <?=$this->get_attr_str($opts['htmlattrs'])?> />
		<?php
		$this->error_div();
	}
	
	function textarea($opts=array())
	{
		def_options(array('htmlattrs'=>array('rows'=>5,'cols'=>10)), $opts);

		if(!isset($opts['name']))
			$opts['htmlattrs']['name']= $this->_ROW->_MODEL->_TABLE.'['.$this->_FLDNAME.']';
			else
				$opts['htmlattrs']['name']= $opts['name'];
			
			$opts['value']=$this->_ROW->getField($this->_FLDNAME);
			?>
			<textarea <?=$this->get_attr_str($opts['htmlattrs'])?> ><?=$opts['value'] ?></textarea>
			<?php
			$this->error_div();
	}

	/* параметры : 
	enum_mode => 'raw' или 'lang' - режим перечислений
	required => true | false - обязательно для заполнения, есть ли пустое значение
	*/
	function ComboBox($data=NULL,$opts=array())
	{
		def_options(array('htmlattrs'=>array(),'enum_mode'=>'raw','required'=>$this->_ROW->_MODEL->isFieldRequired($this->_FLDNAME),), $opts);
		if(!isset($opts['name']))
			$opts['htmlattrs']['name']= $this->_ROW->_MODEL->_TABLE.'['.$this->_FLDNAME.']';
		else
			$opts['htmlattrs']['name']= $opts['name'];
		
		$curr_value = $this->_ROW->getField($this->_FLDNAME);	
		$fldparams = $this->_ROW->_MODEL->getFldInfo($this->_FLDNAME);
		?>			
		<select <?=$this->get_attr_str($opts['htmlattrs'])?> >
		<?php
		if(!$fldparams['required'])
		{
			if(empty($curr_value))
			{
				?>
				<option selected value=""></option>
				<?php				
			}
			else 
			{
				?>
				<option value=""></option>
				<?php
			}
		}
		 
		if($data==NULL)
		{
			if( in_array( $this->_ROW->_MODEL->_SETTINGS['fields'][$this->_FLDNAME]['Type'], array('enum','set')))
			{
				$data = $this->_ROW->_MODEL->get_field_value_list($this->_FLDNAME);
			}
		}
		
		//mul_dbg($data);
		
		if(is_array($data))
		{			 
			$fld_capt_prefix=$this->_ROW->_MODEL->_TABLE.'.'.$this->_FLDNAME;
			$enum_mode = $opts['enum_mode'];
			$str = xx_implode($data, "
", '<option value="{%val}">{%capt}</option>', function(&$theval,&$idx,&$thetemplate,&$ctr,$thedelimeter) use($curr_value,$fld_capt_prefix,$enum_mode)
{
				//mul_dbg($theval);
				switch($enum_mode)
				{
					case 'lang': 
						$theval['%capt']=Lang::__t($fld_capt_prefix.".".$theval['%val']);
						break;
					case 'raw': 
						$theval['%capt']=$theval['%val'];
						break;
				}
		
		if($theval['%val']==$curr_value)
		{
			$thetemplate='<option selected value="{%val}">{%capt}</option>';
		}
}
			);
			echo $str;
		}
		elseif(is_object($data)) 
		{
			if(get_class($data)=='DataSet')
			{
								
			//	mul_dbg($curr_value);
				
				$data->walk(
						function($dr,$numrow) use ($opts,$curr_value)
						{
							$checked="";
							// field
							if(!empty($opts['field_value']))
								$val = $dr->getField($opts['field_value']);
							else
								$val = $dr->getPrimary();
										
							if($val==$curr_value)
								$checked="selected";
							
							// caption
							if(!empty($opts['field_caption']))
								$caption = $dr->getField($opts['field_value']);
							elseif(!empty($opts['caption_template']))
								$caption = x_make_str($opts['caption_template'], $dr);
							else
								$caption = $dr->getView();
							?>
							<option value="<?=$val?>" <?=$checked?> ><?=$caption?></option>
							<?php 
												
						}
						);
			}
		}
		?>
		</select>
		<?php 
		$this->error_div();
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
	
	function file($opts=array())
	{
		$_UPLOAD_MODE=$this->get_upload_mode();
		$view_src_def_template = '<a href="{file_url}" target="new_file">{file_name}</a>';
		
		$fldinfo = $this->_CONTROLLER->_MODEL->getFldInfo($this->_FLDNAME);
		
		//mul_dbg($fldinfo);
		
		if(!empty($fldinfo['file']['type']))
		{
			$the_type = $fldinfo['file']['type'];
			$arr = explode('/',$the_type);
			$class=$arr[0];
			switch($class)
			{
				case 'audio': {
					use_jq_plugin('jqplayer',$this->_CONTROLLER);
					$view_src_def_template = '<audio src="{file_url}" preload="auto" controls></audio>&nbsp;<a href="{file_url}" target="new_file">{file_name}</a>';
				};break;
			}
			
		}
			
		def_options(array('htmlattrs'=>array(),
				'enum_mode'=>'raw',
				'required'=>$this->_ROW->_MODEL->isFieldRequired($this->_FLDNAME),
				'source_code'=>$view_src_def_template,
		), 
				$opts);
		$opts['htmlattrs']['type']='file';
		if(!empty($this->_CONTROLLER->_MODEL->_SETTINGS['file_fields'][$this->_FLDNAME]['type']))
		{
			$opts['htmlattrs']['accept']= $this->_CONTROLLER->_MODEL->_SETTINGS['file_fields'][$this->_FLDNAME]['type'];
		}
		
		if(!isset($opts['name']))
				$opts['htmlattrs']['name']= $this->_ROW->_MODEL->_TABLE.'['.$this->_FLDNAME.']';
			else
				$opts['htmlattrs']['name']= $opts['name'];
		?>
		<input <?=$this->get_attr_str($opts['htmlattrs'])?> />
		<?php
		if($fldinfo['required']==false)
		{
			?>
		<input type="button" onclick="clear_file('<?=$this->_CONTROLLER->_MODEL->_TABLE?>','<?=$this->_FLDNAME?>')" class="btn btn-small clearfile" title="#{Clear the file}" value="x" />
		<?php 
		}
		?>
		<?php 
		$file_fld = $this->_ROW->getField($this->_FLDNAME);
		if(!empty($file_fld))
		{
			?>
			<input type="hidden" name="<?=$opts['htmlattrs']['name']?>" value="#exists" />
			<?php 
			$_fld_info = $this->_CONTROLLER->_MODEL->get_field_type($this->_FLDNAME);
		//	mul_dbg($_fld_info);
			switch( $_fld_info['typeclass'])
			{				
				case 'text':
				{
					$file_url = as_url($file_fld);
				};break;
				
				case 'binary':
				{
					$file_url = as_url($file_fld);
				
				};break;
			}
			
			$source_html = x_make_str($opts['source_code'],array(
				'file_url'=>$file_url,
				'file_name'=>basename($file_fld),
			));
			
			echo "<div id=\"file_source_{$this->_FLDNAME}\" style=\"display:inline;\">$source_html</div>";			
		}
		
		
		$this->error_div();
	}
	
	function set($opts=array())
	{
		
	}
	
	function checkbox($opts=array())
	{
		def_options(array('htmlattrs'=>array()), $opts);
		$opts['htmlattrs']['type']='checkbox';
		if(!isset($opts['name']))
			$opts['htmlattrs']['name']= $this->_ROW->_MODEL->_TABLE.'['.$this->_FLDNAME.']';
		else
			$opts['htmlattrs']['name']= $opts['name'];
		
		$fldval = $this->_ROW->getField($this->_FLDNAME);
		if(!empty($fldval))
			$opts['htmlattrs']['checked']=true;
		?>
		<input <?=$this->get_attr_str($opts['htmlattrs'])?> />
		<?php
		$this->error_div();
	}
	
	function password($opts=array())
	{
		def_options(array('htmlattrs'=>array()), $opts);
		$opts['htmlattrs']['type']='password';
		if(!isset($opts['name']))
			$opts['htmlattrs']['name']= $this->_ROW->_MODEL->_TABLE.'['.$this->_FLDNAME.']';
		else
			$opts['htmlattrs']['name']= $opts['name'];
		$opts['htmlattrs']['value']=$this->_ROW->getField($this->_FLDNAME);
		?>
		<input <?=$this->get_attr_str($opts['htmlattrs'])?> />
		<?php
		$this->error_div();
	}
}

