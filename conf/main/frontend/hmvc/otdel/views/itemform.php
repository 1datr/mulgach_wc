<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("otdel/save"),$this);
?>
<input type="hidden" name="otdel[id_otdel]" value="<?=((!empty($otdel)) ? $otdel->getField('id_otdel') : '')?>" />
<h3><?php 
if(!empty($otdel))   
{
	?>
	#{Edit OTDEL} <?=$otdel->getView()?>
	<?php
}
else
{
	?>
	#{Create OTDEL}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{otdel.name}</label></th><td>
				<textarea name="otdel[name]" ><?=((!empty($otdel)) ? $otdel->getField('name',true) : '')?></textarea>
			<div class="error" id='err_name' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{otdel.function}</label></th><td>
				<textarea name="otdel[function]" ><?=((!empty($otdel)) ? $otdel->getField('function',true) : '')?></textarea>
			<div class="error" id='err_function' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{otdel.id_otdel_papa}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('otdel')->_MODEL->find() ,'required'=>true, 'name'=>'otdel[id_otdel_papa]');
					if(!empty($otdel))
		{
			$params['value']=$otdel->getField('id_otdel_papa',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_id_otdel_papa' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{otdel.cvet}</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('cvet'),'name'=>'otdel[cvet]');
			if(!empty($otdel))
			{
				$params['value']=$otdel->getField('cvet',true);
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_cvet' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>