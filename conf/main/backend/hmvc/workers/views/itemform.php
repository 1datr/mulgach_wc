<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("workers/save"),$this);
?>
<input type="hidden" name="workers[id]" value="<?=((!empty($workers)) ? $workers->getField('id') : '')?>" />
<h3><?php 
if($workers->_EXISTS_IN_DB)   
{
	?>
	#{Edit WORKERS} <?=$workers->getView()?>
	<?php
}
else
{
	?>
	#{Create WORKERS}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{workers.number}</label></th><td>
	<?php $form->field($workers,'number')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.fio}</label></th><td>
	<?php $form->field($workers,'fio')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.fio_eng}</label></th><td>
	<?php $form->field($workers,'fio_eng')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.position}</label></th><td>
	<?php $form->field($workers,'position')->ComboBox();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.city}</label></th><td>
	<?php $form->field($workers,'city')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.address1}</label></th><td>
	<?php $form->field($workers,'address1')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.address2}</label></th><td>
	<?php $form->field($workers,'address2')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.mail1}</label></th><td>
	<?php $form->field($workers,'mail1')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.mail2}</label></th><td>
	<?php $form->field($workers,'mail2')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.phone1}</label></th><td>
	<?php $form->field($workers,'phone1')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.phone2}</label></th><td>
	<?php $form->field($workers,'phone2')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.phone3}</label></th><td>
	<?php $form->field($workers,'phone3')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.responsibility}</label></th><td>
	<?php $form->field($workers,'responsibility')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.login}</label></th><td>
	<?php $form->field($workers,'login')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.password}</label></th><td>
	<?php $form->field($workers,'password')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.is_arhiv}</label></th><td>
	<?php $form->field($workers,'is_arhiv')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.level}</label></th><td>
	<?php $form->field($workers,'level')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.token}</label></th><td>
	<?php $form->field($workers,'token')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>