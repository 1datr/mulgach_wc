<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("phones/save"),$this);
?>
<input type="hidden" name="phones[id]" value="<?=((!empty($phones)) ? $phones->getField('id') : '')?>" />
<h3><?php 
if($phones->_EXISTS_IN_DB)   
{
	?>
	#{Edit PHONES} <?=$phones->getView()?>
	<?php
}
else
{
	?>
	#{Create PHONES}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{phones.user_id}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('')->_MODEL->find() ,'name'=>'phones[user_id]');			
					if(!empty($phones))
		{
			$params['value']=$phones->getField('user_id',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_user_id' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{phones.name}</label></th><td>
	<?php $form->field($phones,'name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{phones.phone}</label></th><td>
	<?php $form->field($phones,'phone')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>