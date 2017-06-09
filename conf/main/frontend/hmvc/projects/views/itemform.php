<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?><form method="post"  action="/?r=projects/save">
<input type="hidden" name="projects[id_project]" value="<?=((!empty($projects)) ? $projects->getField('id_project') : '')?>" />
<input type="submit" value="SUBMIT" />
<table>
	<tr>
	<th><label>name</label></th><td>
				<input type="text" name="projects[name]" value="<?=((!empty($projects)) ? $projects->getField('name') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>full_name</label></th><td>
				<input type="text" name="projects[full_name]" value="<?=((!empty($projects)) ? $projects->getField('full_name') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>otv_ruk</label></th><td>
			<?php 
			$params = array('ds'=> $this->get_controller('workers')->_MODEL->find() ,'name'=>'projects[otv_ruk]');
			if(!empty($projects))
			{
				$params['value']=$projects->getField('otv_ruk');
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>	</td>
	</tr>
		<tr>
	<th><label>date_generate</label></th><td>
				<input type="text" name="projects[date_generate]" value="<?=((!empty($projects)) ? $projects->getField('date_generate') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>date_start</label></th><td>
				<input type="text" name="projects[date_start]" value="<?=((!empty($projects)) ? $projects->getField('date_start') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>date_end</label></th><td>
				<input type="text" name="projects[date_end]" value="<?=((!empty($projects)) ? $projects->getField('date_end') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>teh_zad</label></th><td>
				<input type="text" name="projects[teh_zad]" value="<?=((!empty($projects)) ? $projects->getField('teh_zad') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>id_otdel</label></th><td>
			<?php 
			$params = array('ds'=> $this->get_controller('otdel')->_MODEL->find() ,'name'=>'projects[id_otdel]');
			if(!empty($projects))
			{
				$params['value']=$projects->getField('id_otdel');
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>	</td>
	</tr>
		<tr>
	<th><label>sostoyanie</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('sostoyanie'),'name'=>'projects[sostoyanie]');
			if(!empty($projects))
			{
				$params['value']=$projects->getField('sostoyanie');
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
			</td>
	</tr>
		<tr>
	<th><label>current-task-number</label></th><td>
				<input type="text" name="projects[current-task-number]" value="<?=((!empty($projects)) ? $projects->getField('current-task-number') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>creator_id</label></th><td>
			<?php 
			$params = array('ds'=> $this->get_controller('workers')->_MODEL->find() ,'name'=>'projects[creator_id]');
			if(!empty($projects))
			{
				$params['value']=$projects->getField('creator_id');
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>	</td>
	</tr>
	</table>
</form>