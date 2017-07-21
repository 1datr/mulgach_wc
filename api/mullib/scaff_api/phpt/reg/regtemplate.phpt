<#php
$frm = new mulForm(as_url('{makeuser_action}'),$this);
//var_dump($reg_struct);
#>
<table>
<?php 
foreach($fields_ordered as $fld => $fldinfo)
{
	
	if($fld!=$fld_primary)
	{
	?>
	<tr>
	<th><label>#{{table}.<?=$fld?>}</label></th><td>
	<?php
	if(!empty($settings['constraints'][$fld]))
	{
		
		?>
		<#php 
		<?php
		if($settings['constraints'][$fld]['required'])
		{
			?>
			$params = array('ds'=> $this->get_controller('<?=$settings['constraints'][$fld]['model']?>')->_MODEL->find() ,'required'=>true, 'name'=>'{table}[<?=$fld?>]');
			<?php
		}
		else
		{
			?>
			$params = array('ds'=> $this->get_controller('<?=$settings['constraints'][$fld]['model']?>')->_MODEL->find() ,'name'=>'{table}[<?=$fld?>]');			
			<?php
		}
		?>
		if(!empty(${table}))
		{
			$params['value']=${table}->getField('<?=$fld?>',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		#>
		<div class="error" id='err_<?=$fld?>' role="alert"></div>
		<?php
		}
		elseif($fldinfo['Type']=='enum')
		{
			?><#php $form->field(${table},'<?=$fld?>')->ComboBox();	 #><?php		
		}
		elseif($fldinfo['Type']=='set')
		{
			?><#php $form->field(${table},'<?=$fld?>')->set();	 #><?php	
		}
		elseif($fld==$fld_passw)
		{
			?><#php $form->field(${table},'<?=$fld?>')->password();	 #><?php	
		}
		elseif(isset($settings['file_fields'][$fld]))
		{
			?><#php $form->field(${table},'<?=$fld?>')->file();	 #><?php
		}
		elseif(($fldinfo['Type']=='longtext') || (stristr($fldinfo['Type'],"varchar")))
		{
			?><#php $form->field(${table},'<?=$fld?>')->textarea();	 #><?php	
		}
		else
		{
			?><#php $form->field(${table},'<?=$fld?>')->text();	 #><?php	
		}
	?>
	</td>
	</tr>
	<?php
	}
}
?>
  <tr> 	  
    <th></th>
    <td>
    <# $captcha->full_html();  #>
    </td>
  </tr>
</table>

<#php
$frm->submit('#{REGISTER}');
$frm->close();
#>