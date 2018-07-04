<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("ant/save"),$this);
?>
<input type="hidden" name="ant[id]" value="<?=((!empty($ant)) ? $ant->getField('id') : '')?>" />
<h3><?php 
if($ant->_EXISTS_IN_DB)   
{
	?>
	#{Edit ANT} <?=$ant->getView()?>
	<?php
}
else
{
	?>
	#{Create ANT}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{ant.race}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('ant_race')->_MODEL->find() ,'name'=>'ant[race]');			
					if(!empty($ant))
		{
			$params['value']=$ant->getField('race',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_race' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{ant.number}</label></th><td>
	<?php $form->field($ant,'number')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{ant.owner_id}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('users')->_MODEL->find() ,'name'=>'ant[owner_id]');			
					if(!empty($ant))
		{
			$params['value']=$ant->getField('owner_id',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_owner_id' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{ant.game_id}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('game')->_MODEL->find() ,'name'=>'ant[game_id]');			
					if(!empty($ant))
		{
			$params['value']=$ant->getField('game_id',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_game_id' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>