<#php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
#><form method="post"  action="/?r={table}/save">
<input type="hidden" name="{table}[{fld_primary}]" value="<#=((!empty(${table})) ? ${table}->getField('{fld_primary}') : '')#>" />
<input type="submit" value="SUBMIT" />
<table>
<?php 
foreach($fields as $fld => $fldinfo)
{
	if($fld!=$fld_primary)
	{
	?>
	<tr>
	<th><label><?=$fld?></label></th><td>
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
		<?
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
		<?php
		}
		elseif($fldinfo['Type']=='set')
		{
		
		}
		elseif(($fldinfo['Type']=='longtext') || (stristr($fldinfo['Type'],"varchar")))
		{
		?>
			<textarea name="{table}[<?=$fld?>]" ><#=((!empty(${table})) ? ${table}->getField('<?=$fld?>',true) : '')#></textarea>
		<?	
		}
		else
		{
		?>
			<input type="text" name="{table}[<?=$fld?>]" value="<#=((!empty(${table})) ? ${table}->getField('<?=$fld?>',true) : '')#>" />
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
</form>