<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?><form method="post" >
<input type="hidden" name="otdel[id_otdel]" value="" />
<input type="submit" value="SUBMIT" />
<table>
	<tr>
	<th><label>name</label></th><td>
			<input type="text" name="otdel[name]" />
			</td>
	</tr>
		<tr>
	<th><label>function</label></th><td>
			<input type="text" name="otdel[function]" />
			</td>
	</tr>
		<tr>
	<th><label>id_otdel_papa</label></th>
		<td>
		<?php 
		$ds = $this->get_controller('otdel')->_MODEL->find();
		$this->usewidget(new ComboboxWidget(),array('ds'=>$ds));
		?>	
		</td>
	</tr>
		<tr>
	<th><label>cvet</label></th><td>
			<input type="text" name="otdel[cvet]" />
			</td>
	</tr>
	</table>
</form>