<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?><form method="post" >
<input type="hidden" name="tasks[id_task]" value="<?=((!empty($tasks)) ? $tasks->getField('id_task') : '')?>" />
<input type="submit" value="SUBMIT" />
<table>
	<tr>
	<th><label>name</label></th><td>
				<input type="text" name="tasks[name]" value="<?=((!empty($tasks)) ? $tasks->getField('name') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>vhod_dannye</label></th><td>
				<input type="text" name="tasks[vhod_dannye]" value="<?=((!empty($tasks)) ? $tasks->getField('vhod_dannye') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>vihod_resultat</label></th><td>
				<input type="text" name="tasks[vihod_resultat]" value="<?=((!empty($tasks)) ? $tasks->getField('vihod_resultat') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>upravlenie</label></th><td>
				<input type="text" name="tasks[upravlenie]" value="<?=((!empty($tasks)) ? $tasks->getField('upravlenie') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>resursy_spisok</label></th><td>
				<input type="text" name="tasks[resursy_spisok]" value="<?=((!empty($tasks)) ? $tasks->getField('resursy_spisok') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>proj_id</label></th><td>
			<?php 
			$params = array('ds'=> $this->get_controller('projects')->_MODEL->find() ,'name'=>'tasks[proj_id]');
			if(!empty($tasks))
			{
				$params['value']=$tasks->getField('proj_id');
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>	</td>
	</tr>
		<tr>
	<th><label>vazhnost</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('vazhnost'),'name'=>'tasks[vazhnost]');
			if(!empty($tasks))
			{
				$params['value']=$tasks->getField('vazhnost');
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
				$params['value']=$tasks->getField('srochnost');
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
			</td>
	</tr>
		<tr>
	<th><label>otv_sotr</label></th><td>
			<?php 
			$params = array('ds'=> $this->get_controller('workers')->_MODEL->find() ,'name'=>'tasks[otv_sotr]');
			if(!empty($tasks))
			{
				$params['value']=$tasks->getField('otv_sotr');
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>	</td>
	</tr>
		<tr>
	<th><label>sostoyanie_zadachi</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('sostoyanie_zadachi'),'name'=>'tasks[sostoyanie_zadachi]');
			if(!empty($tasks))
			{
				$params['value']=$tasks->getField('sostoyanie_zadachi');
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
			</td>
	</tr>
		<tr>
	<th><label>date_plan</label></th><td>
				<input type="text" name="tasks[date_plan]" value="<?=((!empty($tasks)) ? $tasks->getField('date_plan') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>date_start</label></th><td>
				<input type="text" name="tasks[date_start]" value="<?=((!empty($tasks)) ? $tasks->getField('date_start') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>data_zaversheniya</label></th><td>
				<input type="text" name="tasks[data_zaversheniya]" value="<?=((!empty($tasks)) ? $tasks->getField('data_zaversheniya') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>data_prinyatiya</label></th><td>
				<input type="text" name="tasks[data_prinyatiya]" value="<?=((!empty($tasks)) ? $tasks->getField('data_prinyatiya') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>number_task</label></th><td>
				<input type="text" name="tasks[number_task]" value="<?=((!empty($tasks)) ? $tasks->getField('number_task') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>creator_id</label></th><td>
			<?php 
			$params = array('ds'=> $this->get_controller('workers')->_MODEL->find() ,'name'=>'tasks[creator_id]');
			if(!empty($tasks))
			{
				$params['value']=$tasks->getField('creator_id');
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>	</td>
	</tr>
	</table>
</form>