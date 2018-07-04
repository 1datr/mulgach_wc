<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("game/save"),$this);
?>
<input type="hidden" name="game[id]" value="<?=((!empty($game)) ? $game->getField('id') : '')?>" />
<h3><?php 
if($game->_EXISTS_IN_DB)   
{
	?>
	#{Edit GAME} <?=$game->getView()?>
	<?php
}
else
{
	?>
	#{Create GAME}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{game.owner_id}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('users')->_MODEL->find() ,'name'=>'game[owner_id]');			
					if(!empty($game))
		{
			$params['value']=$game->getField('owner_id',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_owner_id' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{game.creation_date}</label></th><td>
	<?php $form->field($game,'creation_date')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{game.name}</label></th><td>
	<?php $form->field($game,'name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{game.charact}</label></th><td>
	<?php $form->field($game,'charact')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{game.gamer2_id}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('users')->_MODEL->find() ,'name'=>'game[gamer2_id]');			
					if(!empty($game))
		{
			$params['value']=$game->getField('gamer2_id',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_gamer2_id' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>