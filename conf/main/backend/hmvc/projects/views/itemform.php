<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("projects/save"),$this);
?>
<input type="hidden" name="projects[id_project]" value="<?=((!empty($projects)) ? $projects->getField('id_project') : '')?>" />
<h3><?php 
if(!empty($projects))   
{
	?>
	#{Edit PROJECTS} <?=$projects->getView()?>
	<?php
}
else
{
	?>
	#{Create PROJECTS}
	<?php
}
?></h3>
<table>
	<tr>
	<th><label>#{projects.name}</label></th><td>
				<input type="text" name="projects[name]" value="<?=((!empty($projects)) ? $projects->getField('name',true) : '')?>" />
			<div class="error" id='err_name' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{projects.full_name}</label></th><td>
				<input type="text" name="projects[full_name]" value="<?=((!empty($projects)) ? $projects->getField('full_name',true) : '')?>" />
			<div class="error" id='err_full_name' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{projects.otv_ruk}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('workers')->_MODEL->find() ,'name'=>'projects[otv_ruk]');			
				if(!empty($projects))
		{
			$params['value']=$projects->getField('otv_ruk',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_otv_ruk' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{projects.date_generate}</label></th><td>
				<input type="text" name="projects[date_generate]" value="<?=((!empty($projects)) ? $projects->getField('date_generate',true) : '')?>" />
			<div class="error" id='err_date_generate' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{projects.date_start}</label></th><td>
				<input type="text" name="projects[date_start]" value="<?=((!empty($projects)) ? $projects->getField('date_start',true) : '')?>" />
			<div class="error" id='err_date_start' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{projects.date_end}</label></th><td>
				<input type="text" name="projects[date_end]" value="<?=((!empty($projects)) ? $projects->getField('date_end',true) : '')?>" />
			<div class="error" id='err_date_end' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{projects.teh_zad}</label></th><td>
				<input type="text" name="projects[teh_zad]" value="<?=((!empty($projects)) ? $projects->getField('teh_zad',true) : '')?>" />
			<div class="error" id='err_teh_zad' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{projects.id_otdel}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('otdel')->_MODEL->find() ,'required'=>true, 'name'=>'projects[id_otdel]');
				if(!empty($projects))
		{
			$params['value']=$projects->getField('id_otdel',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_id_otdel' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{projects.sostoyanie}</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('sostoyanie'),'name'=>'projects[sostoyanie]');
			if(!empty($projects))
			{
				$params['value']=$projects->getField('sostoyanie',true);
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_sostoyanie' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{projects.current-task-number}</label></th><td>
				<input type="text" name="projects[current-task-number]" value="<?=((!empty($projects)) ? $projects->getField('current-task-number',true) : '')?>" />
			<div class="error" id='err_current-task-number' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{projects.creator_id}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('workers')->_MODEL->find() ,'required'=>true, 'name'=>'projects[creator_id]');
				if(!empty($projects))
		{
			$params['value']=$projects->getField('creator_id',true);
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