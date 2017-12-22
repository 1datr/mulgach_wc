<?php
$form = new mulForm(as_url('razdel/regadmin'),$this);
$captcha = mul_captcha::use_captcha($this,['model'=>&$reg_form_struct,'form'=>&$form]);
//var_dump($reg_struct);
?>
<table>
	<tr>
	<th><label>#{._re}</label></th><td>
	<?php $form->field($reg_struct,'_re')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.id_razdel}</label></th><td>
	<?php $form->field($reg_struct,'id_razdel')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.id_kurs}</label></th><td>
	<?php $form->field($reg_struct,'id_kurs')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.number}</label></th><td>
	<?php $form->field($reg_struct,'number')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.name}</label></th><td>
	<?php $form->field($reg_struct,'name')->text();	 ?>	</td>
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