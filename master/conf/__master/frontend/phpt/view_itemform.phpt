<#php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
#><form method="post" >
<input type="hidden" name="{table}[{fld_primary}]" value="" />
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
		$ds = $this->get_controller('<?=$settings['constraints'][$fld]['model']?>')->_MODEL->find();
		$this->usewidget(new ComboboxWidget(),array('ds'=>$ds));
		#><?
		}
		elseif($fldinfo['Type']=='longtext')
		{
		?>
		<textarea name="{table}[<?=$fld?>]" ></textarea>
		<?	
		}
		else
		{
		?>
		<input type="text" name="{table}[<?=$fld?>]" />
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
</form>