<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("razdel/save"),$this);
?>
<input type="hidden" name="razdel[id_razdel]" value="<?=((!empty($razdel)) ? $razdel->getField('id_razdel') : '')?>" />
<h3><?php 
if(!empty($razdel))   
{
	?>
	#{Edit RAZDEL} <?=$razdel->getView()?>
	<?php
}
else
{
	?>
	#{Create RAZDEL}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{razdel.id_kurs}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('kursy')->_MODEL->find() ,'required'=>true, 'name'=>'razdel[id_kurs]');
					if(!empty($razdel))
		{
			$params['value']=$razdel->getField('id_kurs',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_id_kurs' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{razdel.number}</label></th><td>
	<?php $form->field($razdel,'number')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{razdel.name}</label></th><td>
	<?php $form->field($razdel,'name')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>