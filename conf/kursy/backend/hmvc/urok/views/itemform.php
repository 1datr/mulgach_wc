<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("urok/save"));
?>
<input type="hidden" name="urok[]" value="<?=((!empty($urok)) ? $urok->getField('') : '')?>" />
<h3><?php 
if(!empty($urok))   
{
	?>
	#{Edit UROK} <?=$urok->getView()?>
	<?php
}
else
{
	?>
	#{Create UROK}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{urok.id_urok}</label></th><td>
	<?php $form->field($urok,'id_urok')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{urok.id_razdel}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('razdel')->_MODEL->find() ,'required'=>true, 'name'=>'urok[id_razdel]');
					if(!empty($urok))
		{
			$params['value']=$urok->getField('id_razdel',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_id_razdel' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{urok.number}</label></th><td>
	<?php $form->field($urok,'number')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{urok.name}</label></th><td>
	<?php $form->field($urok,'name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{urok.video1}</label></th><td>
	<?php $form->field($urok,'video1')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{urok.video2}</label></th><td>
	<?php $form->field($urok,'video2')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{urok.video3}</label></th><td>
	<?php $form->field($urok,'video3')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{urok.document1}</label></th><td>
	<?php $form->field($urok,'document1')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{urok.document2}</label></th><td>
	<?php $form->field($urok,'document2')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{urok.hometask}</label></th><td>
	<?php $form->field($urok,'hometask')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{urok.presentation}</label></th><td>
	<?php $form->field($urok,'presentation')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{urok.text_block}</label></th><td>
	<?php $form->field($urok,'text_block')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{urok.theme}</label></th><td>
	<?php $form->field($urok,'theme')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>