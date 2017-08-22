<?php
$form = new mulForm(as_url("kursy/save"),$this);
// 'driver'
?>
<div id="drv_params">
<table>
	<tr>
	<th><label>#{driver}</label></th><td>
	<?php $form->field($model_row,'driver')->ComboBox($plugs,['htmlattrs'=>['id'=>'the_driver',
			'onclick'=>"load_ajax_block('#drv_params','".as_url('site/loadform').")');"]]);	 
			?>	</td>
	</tr>
</table>
</div>

<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{NEXT}'); ?>
</form>