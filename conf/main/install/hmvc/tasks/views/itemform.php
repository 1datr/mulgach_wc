<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?><form method="post"  action="/?r=tasks/save">
<input type="hidden" name="tasks[id_task]" value="<?=((!empty($tasks)) ? $tasks->getField('id_task') : '')?>" />
<input type="submit" value="SUBMIT" />
<table>
	<tr>
	<th><label>name</label></th><td>
				<input type="text" name="tasks[name]" value="<?=((!empty($tasks)) ? $tasks->getField('name',true) : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>vhod_dannye</label></th><td>
				<input type="text" name="tasks[vhod_dannye]" value="<?=((!empty($tasks)) ? $tasks->getField('vhod_dannye',true) : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>vihod_resultat</label></th><td>
				<input type="text" name="tasks[vihod_resultat]" value="<?=((!empty($tasks)) ? $tasks->getField('vihod_resultat',true) : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>upravlenie</label></th><td>
				<input type="text" name="tasks[upravlenie]" value="<?=((!empty($tasks)) ? $tasks->getField('upravlenie',true) : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>resursy_spisok</label></th><td>
				<input type="text" name="tasks[resursy_spisok]" value="<?=((!empty($tasks)) ? $tasks->getField('resursy_spisok',true) : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>proj_id</label></th><td>
				<input type="text" name="tasks[proj_id]" value="<?=((!empty($tasks)) ? $tasks->getField('proj_id',true) : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>vazhnost</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('vazhnost'),'name'=>'tasks[vazhnost]');
			if(!empty($tasks))
			{
				$params['value']=$tasks->getField('vazhnost',true);
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
			</td>
	</tr>
		<tr>
	<th><label>srochnost</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('srochnost'),'name'=>'tasks[srochnost]');
			if(!empty($tasks))
			{
				$params['value']=$tasks->getField('srochnost',true);
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
			</td>
	</tr>
		<tr>
	<th><label>otv_sotr</label></th><td>
				<input type="text" name="tasks[otv_sotr]" value="<?=((!empty($tasks)) ? $tasks->getField('otv_sotr',true) : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>sostoyanie_zadachi</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('sostoyanie_zadachi'),'name'=>'tasks[sostoyanie_zadachi]');
			if(!empty($tasks))
			{
				$params['value']=$tasks->getField('sostoyanie_zadachi',true);
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
			</td>
	</tr>
		<tr>
	<th><label>date_plan</label></th><td>
				<input type="text" name="tasks[date_plan]" value="<?=((!empty($tasks)) ? $tasks->getField('date_plan',true) : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>date_start</label></th><td>
				<input type="text" name="tasks[date_start]" value="<?=((!empty($tasks)) ? $tasks->getField('date_start',true) : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>data_zaversheniya</label></th><td>
				<input type="text" name="tasks[data_zaversheniya]" value="<?=((!empty($tasks)) ? $tasks->getField('data_zaversheniya',true) : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>data_prinyatiya</label></th><td>
				<input type="text" name="tasks[data_prinyatiya]" value="<?=((!empty($tasks)) ? $tasks->getField('data_prinyatiya',true) : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>number_task</label></th><td>
				<input type="text" name="tasks[number_task]" value="<?=((!empty($tasks)) ? $tasks->getField('number_task',true) : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>creator_id</label></th><td>
				<input type="text" name="tasks[creator_id]" value="<?=((!empty($tasks)) ? $tasks->getField('creator_id',true) : '')?>" />
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
</form>