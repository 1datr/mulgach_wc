<#php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
#>
<#php
$form = new mulForm(as_url("{table}/save"));
#>
<input type="hidden" name="{table}[{fld_primary}]" value="<#=((!empty(${table})) ? ${table}->getField('{fld_primary}') : '')#>" />
<h3><#php 
if(!empty(${table}))   
{
	#>
	#{Edit {TABLE_UC}} <#=${table}->getView()#>
	<#php
}
else
{
	#>
	#{Create {TABLE_UC}}
	<#php
}
#></h3>
<table>

<?php 
foreach($fields as $fld => $fldinfo)
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
		?>
		<#php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('<?=$fld ?>'),'name'=>'{table}[<?=$fld?>]');
			if(!empty(${table}))
			{
				$params['value']=${table}->getField('<?=$fld?>',true);
			}
			$this->usewidget(new ComboboxWidget(),$params);
		#>
		<div class="error" id='err_<?=$fld?>' role="alert"></div>
		<?php
		}
		elseif($fldinfo['Type']=='set')
		{
		
		}
		elseif(($fldinfo['Type']=='longtext') || (stristr($fldinfo['Type'],"varchar")))
		{
		?>
			<textarea name="{table}[<?=$fld?>]" ><#=((!empty(${table})) ? ${table}->getField('<?=$fld?>',true) : '')#></textarea>
			<div class="error" id='err_<?=$fld?>' role="alert"></div>
		<?	
		}
		else
		{
		?>
			<input type="text" name="{table}[<?=$fld?>]" value="<#=((!empty(${table})) ? ${table}->getField('<?=$fld?>',true) : '')#>" />
			<div class="error" id='err_<?=$fld?>' role="alert"></div>
		<?	
		}
	?>
	</td>
	</tr>
	<?php
	}
}
?>
</table>
<input type="hidden" name="back_url" value="<#=$_SERVER['HTTP_REFERER']; #>" />
<#php $form->submit('#{SAVE}'); #>
</form>