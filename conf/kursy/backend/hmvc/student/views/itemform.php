<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("student/save"),$this);
?>
<input type="hidden" name="student[id_uchenik]" value="<?=((!empty($student)) ? $student->getField('id_uchenik') : '')?>" />
<h3><?php 
if($student->_EXISTS_IN_DB)   
{
	?>
	#{Edit STUDENT} <?=$student->getView()?>
	<?php
}
else
{
	?>
	#{Create STUDENT}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{student.summ}</label></th><td>
	<?php $form->field($student,'summ')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{student.login}</label></th><td>
	<?php $form->field($student,'login')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{student.passw}</label></th><td>
	<?php $form->field($student,'passw')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{student.user_id}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('users')->_MODEL->find() ,'required'=>true, 'name'=>'student[user_id]');
					if(!empty($student))
		{
			$params['value']=$student->getField('user_id',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_user_id' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>