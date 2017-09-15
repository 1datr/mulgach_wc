<?php
$form = new mulForm(as_url('primeneniye/regadmin'),$this);
$captcha = mul_captcha::use_captcha($this,['model'=>&$reg_form_struct,'form'=>&$form]);
//var_dump($reg_struct);
?>
<table>
	<tr>
	<th><label>#{._re}</label></th><td>
	<?php $form->field($reg_struct,'_re')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.id}</label></th><td>
	<?php $form->field($reg_struct,'id')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.id_predlogenie}</label></th><td>
	<?php $form->field($reg_struct,'id_predlogenie')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.id_lifearea}</label></th><td>
	<?php $form->field($reg_struct,'id_lifearea')->text();	 ?>	</td>
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