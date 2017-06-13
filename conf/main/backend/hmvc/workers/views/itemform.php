<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?><form method="post"  action="/?r=workers/save">
<input type="hidden" name="workers[id]" value="<?=((!empty($workers)) ? $workers->getField('id') : '')?>" />
<input type="submit" value="SUBMIT" />
<table>
	<tr>
	<th><label>number</label></th><td>
				<textarea name="workers[number]" ><?=((!empty($workers)) ? $workers->getField('number',true) : '')?></textarea>
			</td>
	</tr>
		<tr>
	<th><label>fio</label></th><td>
				<textarea name="workers[fio]" ><?=((!empty($workers)) ? $workers->getField('fio',true) : '')?></textarea>
			</td>
	</tr>
		<tr>
	<th><label>fio_eng</label></th><td>
				<textarea name="workers[fio_eng]" ><?=((!empty($workers)) ? $workers->getField('fio_eng',true) : '')?></textarea>
			</td>
	</tr>
		<tr>
	<th><label>position</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('position'),'name'=>'workers[position]');
			if(!empty($workers))
			{
				$params['value']=$workers->getField('position',true);
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
			</td>
	</tr>
		<tr>
	<th><label>city</label></th><td>
				<textarea name="workers[city]" ><?=((!empty($workers)) ? $workers->getField('city',true) : '')?></textarea>
			</td>
	</tr>
		<tr>
	<th><label>address1</label></th><td>
				<textarea name="workers[address1]" ><?=((!empty($workers)) ? $workers->getField('address1',true) : '')?></textarea>
			</td>
	</tr>
		<tr>
	<th><label>address2</label></th><td>
				<textarea name="workers[address2]" ><?=((!empty($workers)) ? $workers->getField('address2',true) : '')?></textarea>
			</td>
	</tr>
		<tr>
	<th><label>mail1</label></th><td>
				<textarea name="workers[mail1]" ><?=((!empty($workers)) ? $workers->getField('mail1',true) : '')?></textarea>
			</td>
	</tr>
		<tr>
	<th><label>mail2</label></th><td>
				<textarea name="workers[mail2]" ><?=((!empty($workers)) ? $workers->getField('mail2',true) : '')?></textarea>
			</td>
	</tr>
		<tr>
	<th><label>phone1</label></th><td>
				<textarea name="workers[phone1]" ><?=((!empty($workers)) ? $workers->getField('phone1',true) : '')?></textarea>
			</td>
	</tr>
		<tr>
	<th><label>phone2</label></th><td>
				<textarea name="workers[phone2]" ><?=((!empty($workers)) ? $workers->getField('phone2',true) : '')?></textarea>
			</td>
	</tr>
		<tr>
	<th><label>phone3</label></th><td>
				<textarea name="workers[phone3]" ><?=((!empty($workers)) ? $workers->getField('phone3',true) : '')?></textarea>
			</td>
	</tr>
		<tr>
	<th><label>responsibility</label></th><td>
				<textarea name="workers[responsibility]" ><?=((!empty($workers)) ? $workers->getField('responsibility',true) : '')?></textarea>
			</td>
	</tr>
		<tr>
	<th><label>login</label></th><td>
				<textarea name="workers[login]" ><?=((!empty($workers)) ? $workers->getField('login',true) : '')?></textarea>
			</td>
	</tr>
		<tr>
	<th><label>password</label></th><td>
				<textarea name="workers[password]" ><?=((!empty($workers)) ? $workers->getField('password',true) : '')?></textarea>
			</td>
	</tr>
		<tr>
	<th><label>is_arhiv</label></th><td>
				<input type="text" name="workers[is_arhiv]" value="<?=((!empty($workers)) ? $workers->getField('is_arhiv',true) : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>level</label></th><td>
				<input type="text" name="workers[level]" value="<?=((!empty($workers)) ? $workers->getField('level',true) : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>token</label></th><td>
				<input type="text" name="workers[token]" value="<?=((!empty($workers)) ? $workers->getField('token',true) : '')?>" />
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
</form>