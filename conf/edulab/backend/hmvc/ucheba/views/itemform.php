<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("ucheba/save"),$this);
?>
<input type="hidden" name="ucheba[id]" value="<?=((!empty($ucheba)) ? $ucheba->getField('id') : '')?>" />
<h3><?php 
if($ucheba->_EXISTS_IN_DB)   
{
	?>
	#{Edit UCHEBA} <?=$ucheba->getView()?>
	<?php
}
else
{
	?>
	#{Create UCHEBA}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{ucheba.id_uchenik}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('student')->_MODEL->find() ,'required'=>true, 'name'=>'ucheba[id_uchenik]');
					if(!empty($ucheba))
		{
			$params['value']=$ucheba->getField('id_uchenik',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_id_uchenik' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{ucheba.id_kurs}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('kursy')->_MODEL->find() ,'required'=>true, 'name'=>'ucheba[id_kurs]');
					if(!empty($ucheba))
		{
			$params['value']=$ucheba->getField('id_kurs',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_id_kurs' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{ucheba.dostup}</label></th><td>
	<?php $form->field($ucheba,'dostup')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{ucheba.date_start}</label></th><td>
	<?php $form->field($ucheba,'date_start')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{ucheba.date_finish}</label></th><td>
	<?php $form->field($ucheba,'date_finish')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>