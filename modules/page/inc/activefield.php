<?php
class ActiveField
{
	VAR $_ROW;
	VAR $_FLDNAME;
	VAR $_OPTIONS;
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
		?>			
		<select <?=$this->get_attr_str($opts['htmlattrs'])?> >
		<?php
		if(!$opts['required'])
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
	
	function file($opts=array())
	{
		
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

