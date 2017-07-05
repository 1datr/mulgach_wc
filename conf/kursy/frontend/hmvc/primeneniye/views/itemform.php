<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("primeneniye/save"));
?>
<input type="hidden" name="primeneniye[id]" value="<?=((!empty($primeneniye)) ? $primeneniye->getField('id') : '')?>" />
<h3><?php 
if(!empty($primeneniye))   
{
	?>
	#{Edit PRIMENENIYE} <?=$primeneniye->getView()?>
	<?php
}
else
{
	?>
	#{Create PRIMENENIYE}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{primeneniye.id_predlogenie}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('predlogenie')->_MODEL->find() ,'required'=>true, 'name'=>'primeneniye[id_predlogenie]');
					if(!empty($primeneniye))
		{
			$params['value']=$primeneniye->getField('id_predlogenie',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_id_predlogenie' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{primeneniye.id_lifearea}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('lifearea')->_MODEL->find() ,'required'=>true, 'name'=>'primeneniye[id_lifearea]');
					if(!empty($primeneniye))
		{
			$params['value']=$primeneniye->getField('id_lifearea',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_id_lifearea' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>