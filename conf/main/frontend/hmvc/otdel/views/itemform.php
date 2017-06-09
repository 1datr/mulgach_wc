<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?><form method="post" >
<input type="hidden" name="otdel[id_otdel]" value="<?=((!empty($otdel)) ? $otdel->getField('id_otdel') : '')?>" />
<input type="submit" value="SUBMIT" />
<table>
	<tr>
	<th><label>name</label></th><td>
				<input type="text" name="otdel[name]" value="<?=((!empty($otdel)) ? $otdel->getField('name') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>function</label></th><td>
				<input type="text" name="otdel[function]" value="<?=((!empty($otdel)) ? $otdel->getField('function') : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>id_otdel_papa</label></th><td>
			<?php 
			$params = array('ds'=> $this->get_controller('otdel')->_MODEL->find() ,'name'=>'otdel[id_otdel_papa]');
			if(!empty($otdel))
			{
				$params['value']=$otdel->getField('id_otdel_papa');
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>	</td>
	</tr>
		<tr>
	<th><label>cvet</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('cvet'),'name'=>'otdel[cvet]');
			if(!empty($otdel))
			{
				$params['value']=$otdel->getField('cvet');
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
			</td>
	</tr>
	</table>
</form>