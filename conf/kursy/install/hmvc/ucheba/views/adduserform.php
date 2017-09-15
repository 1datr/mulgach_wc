<?php
$form = new mulForm(as_url('ucheba/regadmin'),$this);
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
	<th><label>#{.id_uchenik}</label></th><td>
	<?php $form->field($reg_struct,'id_uchenik')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.id_kurs}</label></th><td>
	<?php $form->field($reg_struct,'id_kurs')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.dostup}</label></th><td>
	<?php $form->field($reg_struct,'dostup')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.date_start}</label></th><td>
	<?php $form->field($reg_struct,'date_start')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.date_finish}</label></th><td>
	<?php $form->field($reg_struct,'date_finish')->text();	 ?>	</td>
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