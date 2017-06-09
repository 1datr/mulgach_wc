<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?><form method="post" >
<input type="hidden" name="workers[id]" value="<?=((!empty($workers)) ? $workers->getField('id') : '')?>" />
<input type="submit" value="SUBMIT" />
<table>
	<tr>
	<th><label>number</label></th><td>
				<input type="text" name="workers[number]" value="<?=((!empty($workers)) ? $workers->getField('number') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>fio</label></th><td>
				<input type="text" name="workers[fio]" value="<?=((!empty($workers)) ? $workers->getField('fio') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>fio_eng</label></th><td>
				<input type="text" name="workers[fio_eng]" value="<?=((!empty($workers)) ? $workers->getField('fio_eng') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>position</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('position'),'name'=>'workers[position]');
			if(!empty($workers))
			{
				$params['value']=$workers->getField('position');
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
			</td>
	</tr>
		<tr>
	<th><label>city</label></th><td>
				<input type="text" name="workers[city]" value="<?=((!empty($workers)) ? $workers->getField('city') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>address1</label></th><td>
				<input type="text" name="workers[address1]" value="<?=((!empty($workers)) ? $workers->getField('address1') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>address2</label></th><td>
				<input type="text" name="workers[address2]" value="<?=((!empty($workers)) ? $workers->getField('address2') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>mail1</label></th><td>
				<input type="text" name="workers[mail1]" value="<?=((!empty($workers)) ? $workers->getField('mail1') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>mail2</label></th><td>
				<input type="text" name="workers[mail2]" value="<?=((!empty($workers)) ? $workers->getField('mail2') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>phone1</label></th><td>
				<input type="text" name="workers[phone1]" value="<?=((!empty($workers)) ? $workers->getField('phone1') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>phone2</label></th><td>
				<input type="text" name="workers[phone2]" value="<?=((!empty($workers)) ? $workers->getField('phone2') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>phone3</label></th><td>
				<input type="text" name="workers[phone3]" value="<?=((!empty($workers)) ? $workers->getField('phone3') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>responsibility</label></th><td>
				<input type="text" name="workers[responsibility]" value="<?=((!empty($workers)) ? $workers->getField('responsibility') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>login</label></th><td>
				<input type="text" name="workers[login]" value="<?=((!empty($workers)) ? $workers->getField('login') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>password</label></th><td>
				<input type="text" name="workers[password]" value="<?=((!empty($workers)) ? $workers->getField('password') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>is_arhiv</label></th><td>
				<input type="text" name="workers[is_arhiv]" value="<?=((!empty($workers)) ? $workers->getField('is_arhiv') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>level</label></th><td>
				<input type="text" name="workers[level]" value="<?=((!empty($workers)) ? $workers->getField('level') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>token</label></th><td>
				<input type="text" name="workers[token]" value="<?=((!empty($workers)) ? $workers->getField('token') : '')?>" />
			</td>
	</tr>
	</table>
</form>