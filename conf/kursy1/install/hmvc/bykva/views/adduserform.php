<?php
$form = new mulForm(as_url('bykva/regadmin'),$this);
$captcha = mul_captcha::use_captcha($this,['model'=>&$reg_form_struct,'form'=>&$form]);
//var_dump($reg_struct);
?>
<table>
	<tr>
	<th><label>#{._re}</label></th><td>
	<?php $form->field($reg_struct,'_re')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.id_bukva}</label></th><td>
	<?php $form->field($reg_struct,'id_bukva')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.bukva}</label></th><td>
	<?php $form->field($reg_struct,'bukva')->text();	 ?>	</td>
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