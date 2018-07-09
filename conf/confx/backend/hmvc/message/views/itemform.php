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
	<th><label>#{message.from}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('users')->_MODEL->find() ,'name'=>'message[from]');			
					if(!empty($message))
		{
			$params['value']=$message->getField('from',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_from' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{message.to}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('users')->_MODEL->find() ,'name'=>'message[to]');			
					if(!empty($message))
		{
			$params['value']=$message->getField('to',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_to' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{message.when}</label></th><td>
	<?php $form->field($message,'when')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>