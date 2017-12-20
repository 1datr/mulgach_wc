<?php
$form = new mulForm(as_url('zadanie/regadmin'),$this);
$captcha = mul_captcha::use_captcha($this,['model'=>&$reg_form_struct,'form'=>&$form]);
//var_dump($reg_struct);
?>
<table>
	<tr>
	<th><label>#{._re}</label></th><td>
	<?php $form->field($reg_struct,'_re')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.id_zadaniya}</label></th><td>
	<?php $form->field($reg_struct,'id_zadaniya')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.id_urok}</label></th><td>
	<?php $form->field($reg_struct,'id_urok')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.proverka}</label></th><td>
	<?php $form->field($reg_struct,'proverka')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.tematika}</label></th><td>
	<?php $form->field($reg_struct,'tematika')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.title}</label></th><td>
	<?php $form->field($reg_struct,'title')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.zadanie_text}</label></th><td>
	<?php $form->field($reg_struct,'zadanie_text')->textarea();	 ?>	</td>
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