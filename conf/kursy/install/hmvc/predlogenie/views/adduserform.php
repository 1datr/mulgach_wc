<?php
$form = new mulForm(as_url('predlogenie/regadmin'),$this);
$captcha = mul_captcha::use_captcha($this,['model'=>&$reg_form_struct,'form'=>&$form]);
//var_dump($reg_struct);
?>
<table>
	<tr>
	<th><label>#{._re}</label></th><td>
	<?php $form->field($reg_struct,'_re')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.id_predlogenie}</label></th><td>
	<?php $form->field($reg_struct,'id_predlogenie')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.ru}</label></th><td>
	<?php $form->field($reg_struct,'ru')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.zvuk_ru}</label></th><td>
	<?php $form->field($reg_struct,'zvuk_ru')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.en}</label></th><td>
	<?php $form->field($reg_struct,'en')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.zvuk_en}</label></th><td>
	<?php $form->field($reg_struct,'zvuk_en')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.transcription}</label></th><td>
	<?php $form->field($reg_struct,'transcription')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.sound}</label></th><td>
	<?php $form->field($reg_struct,'sound')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.type}</label></th><td>
	<?php $form->field($reg_struct,'type')->text();	 ?>	</td>
	</tr>
	  <tr> 	  
    <td rowspan="2">#{CAPTCHA_CAPTION}</td>
    <td>
    <? $captcha->full_html($form,$reg_struct);  ?>
    </td>
  </tr>

</table>

<?php
$form->submit('#{REGISTER}');
$form->close();
?>