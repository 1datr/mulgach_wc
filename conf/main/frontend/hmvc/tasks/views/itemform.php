<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm("?r=tasks/save");
?>
<input type="hidden" name="tasks[id_task]" value="<?=((!empty($tasks)) ? $tasks->getField('id_task') : '')?>" />
<h3><?php 
if(!empty($tasks))   
{
	?>
	#{Edit TASKS} <?=$tasks->getView()?>
	<?php
}
else
{
	?>
	#{Create TASKS}
	<?php
}
?></h3>
<table>
	<tr>
	<th><label>#{tasks.name}</label></th><td>
				<input type="text" name="tasks[name]" value="<?=((!empty($tasks)) ? $tasks->getField('name',true) : '')?>" />
			<div class="error" id='err_name' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{tasks.vhod_dannye}</label></th><td>
				<input type="text" name="tasks[vhod_dannye]" value="<?=((!empty($tasks)) ? $tasks->getField('vhod_dannye',true) : '')?>" />
			<div class="error" id='err_vhod_dannye' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{tasks.vihod_resultat}</label></th><td>
				<input type="text" name="tasks[vihod_resultat]" value="<?=((!empty($tasks)) ? $tasks->getField('vihod_resultat',true) : '')?>" />
			<div class="error" id='err_vihod_resultat' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{tasks.upravlenie}</label></th><td>
				<input type="text" name="tasks[upravlenie]" value="<?=((!empty($tasks)) ? $tasks->getField('upravlenie',true) : '')?>" />
			<div class="error" id='err_upravlenie' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{tasks.resursy_spisok}</label></th><td>
				<input type="text" name="tasks[resursy_spisok]" value="<?=((!empty($tasks)) ? $tasks->getField('resursy_spisok',true) : '')?>" />
			<div class="error" id='err_resursy_spisok' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{tasks.proj_id}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('projects')->_MODEL->find() ,'name'=>'tasks[proj_id]');			
				if(!empty($tasks))
		{
			$params['value']=$tasks->getField('proj_id',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_proj_id' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{tasks.vazhnost}</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('vazhnost'),'name'=>'tasks[vazhnost]');
			if(!empty($tasks))
			{
				$params['value']=$tasks->getField('vazhnost',true);
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_vazhnost' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{tasks.srochnost}</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('srochnost'),'name'=>'tasks[srochnost]');
			if(!empty($tasks))
			{
				$params['value']=$tasks->getField('srochnost',true);
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_srochnost' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{tasks.otv_sotr}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('workers')->_MODEL->find() ,'name'=>'tasks[otv_sotr]');			
				if(!empty($tasks))
		{
			$params['value']=$tasks->getField('otv_sotr',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_otv_sotr' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{tasks.sostoyanie_zadachi}</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('sostoyanie_zadachi'),'name'=>'tasks[sostoyanie_zadachi]');
			if(!empty($tasks))
			{
				$params['value']=$tasks->getField('sostoyanie_zadachi',true);
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_sostoyanie_zadachi' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{tasks.date_plan}</label></th><td>
				<input type="text" name="tasks[date_plan]" value="<?=((!empty($tasks)) ? $tasks->getField('date_plan',true) : '')?>" />
			<div class="error" id='err_date_plan' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{tasks.date_start}</label></th><td>
				<input type="text" name="tasks[date_start]" value="<?=((!empty($tasks)) ? $tasks->getField('date_start',true) : '')?>" />
			<div class="error" id='err_date_start' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{tasks.data_zaversheniya}</label></th><td>
				<input type="text" name="tasks[data_zaversheniya]" value="<?=((!empty($tasks)) ? $tasks->getField('data_zaversheniya',true) : '')?>" />
			<div class="error" id='err_data_zaversheniya' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{tasks.data_prinyatiya}</label></th><td>
				<input type="text" name="tasks[data_prinyatiya]" value="<?=((!empty($tasks)) ? $tasks->getField('data_prinyatiya',true) : '')?>" />
			<div class="error" id='err_data_prinyatiya' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{tasks.number_task}</label></th><td>
				<input type="text" name="tasks[number_task]" value="<?=((!empty($tasks)) ? $tasks->getField('number_task',true) : '')?>" />
			<div class="error" id='err_number_task' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{tasks.creator_id}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('workers')->_MODEL->find() ,'required'=>true, 'name'=>'tasks[creator_id]');
				if(!empty($tasks))
		{
			$params['value']=$tasks->getField('creator_id',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_creator_id' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>