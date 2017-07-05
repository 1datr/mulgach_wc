<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("preps/save"),$this);
?>
<input type="hidden" name="preps[id_prep]" value="<?=((!empty($preps)) ? $preps->getField('id_prep') : '')?>" />
<h3><?php 
if(!empty($preps))   
{
	?>
	#{Edit PREPS} <?=$preps->getView()?>
	<?php
}
else
{
	?>
	#{Create PREPS}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{preps.first_name}</label></th><td>
	<?php $form->field($preps,'first_name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{preps.last_name}</label></th><td>
	<?php $form->field($preps,'last_name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{preps.user_id}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('users')->_MODEL->find() ,'required'=>true, 'name'=>'preps[user_id]');
					if(!empty($preps))
		{
			$params['value']=$preps->getField('user_id',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_user_id' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{preps.sostoyanie_dopuska}</label></th><td>
	<?php $form->field($preps,'sostoyanie_dopuska')->ComboBox();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>