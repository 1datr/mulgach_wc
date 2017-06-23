<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm("?r=workers/save");
?>
<input type="hidden" name="workers[id]" value="<?=((!empty($workers)) ? $workers->getField('id') : '')?>" />
<h3><?php 
if(!empty($workers))   
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
				<textarea name="workers[number]" ><?=((!empty($workers)) ? $workers->getField('number',true) : '')?></textarea>
			<div class="error" id='err_number' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.fio}</label></th><td>
				<textarea name="workers[fio]" ><?=((!empty($workers)) ? $workers->getField('fio',true) : '')?></textarea>
			<div class="error" id='err_fio' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.fio_eng}</label></th><td>
				<textarea name="workers[fio_eng]" ><?=((!empty($workers)) ? $workers->getField('fio_eng',true) : '')?></textarea>
			<div class="error" id='err_fio_eng' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.position}</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('position'),'name'=>'workers[position]');
			if(!empty($workers))
			{
				$params['value']=$workers->getField('position',true);
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_position' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.city}</label></th><td>
				<textarea name="workers[city]" ><?=((!empty($workers)) ? $workers->getField('city',true) : '')?></textarea>
			<div class="error" id='err_city' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.address1}</label></th><td>
				<textarea name="workers[address1]" ><?=((!empty($workers)) ? $workers->getField('address1',true) : '')?></textarea>
			<div class="error" id='err_address1' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.address2}</label></th><td>
				<textarea name="workers[address2]" ><?=((!empty($workers)) ? $workers->getField('address2',true) : '')?></textarea>
			<div class="error" id='err_address2' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.mail1}</label></th><td>
				<textarea name="workers[mail1]" ><?=((!empty($workers)) ? $workers->getField('mail1',true) : '')?></textarea>
			<div class="error" id='err_mail1' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.mail2}</label></th><td>
				<textarea name="workers[mail2]" ><?=((!empty($workers)) ? $workers->getField('mail2',true) : '')?></textarea>
			<div class="error" id='err_mail2' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.phone1}</label></th><td>
				<textarea name="workers[phone1]" ><?=((!empty($workers)) ? $workers->getField('phone1',true) : '')?></textarea>
			<div class="error" id='err_phone1' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.phone2}</label></th><td>
				<textarea name="workers[phone2]" ><?=((!empty($workers)) ? $workers->getField('phone2',true) : '')?></textarea>
			<div class="error" id='err_phone2' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.phone3}</label></th><td>
				<textarea name="workers[phone3]" ><?=((!empty($workers)) ? $workers->getField('phone3',true) : '')?></textarea>
			<div class="error" id='err_phone3' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.responsibility}</label></th><td>
				<textarea name="workers[responsibility]" ><?=((!empty($workers)) ? $workers->getField('responsibility',true) : '')?></textarea>
			<div class="error" id='err_responsibility' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.login}</label></th><td>
				<textarea name="workers[login]" ><?=((!empty($workers)) ? $workers->getField('login',true) : '')?></textarea>
			<div class="error" id='err_login' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.password}</label></th><td>
				<textarea name="workers[password]" ><?=((!empty($workers)) ? $workers->getField('password',true) : '')?></textarea>
			<div class="error" id='err_password' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.is_arhiv}</label></th><td>
				<input type="text" name="workers[is_arhiv]" value="<?=((!empty($workers)) ? $workers->getField('is_arhiv',true) : '')?>" />
			<div class="error" id='err_is_arhiv' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.level}</label></th><td>
				<input type="text" name="workers[level]" value="<?=((!empty($workers)) ? $workers->getField('level',true) : '')?>" />
			<div class="error" id='err_level' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{workers.token}</label></th><td>
				<input type="text" name="workers[token]" value="<?=((!empty($workers)) ? $workers->getField('token',true) : '')?>" />
			<div class="error" id='err_token' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>