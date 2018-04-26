<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("message/save"),$this);
?>
<input type="hidden" name="message[id]" value="<?=((!empty($message)) ? $message->getField('id') : '')?>" />
<h3><?php 
if($message->_EXISTS_IN_DB)   
{
	?>
	#{Edit MESSAGE} <?=$message->getView()?>
	<?php
}
else
{
	?>
	#{Create MESSAGE}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{message.topic}</label></th><td>
	<?php $form->field($message,'topic')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{message.message}</label></th><td>
	<?php $form->field($message,'message')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{message.user_from}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('users')->_MODEL->find() ,'name'=>'message[user_from]');			
					if(!empty($message))
		{
			$params['value']=$message->getField('user_from',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_user_from' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{message.user_to}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('users')->_MODEL->find() ,'name'=>'message[user_to]');			
					if(!empty($message))
		{
			$params['value']=$message->getField('user_to',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_user_to' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>