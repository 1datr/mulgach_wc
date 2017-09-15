<?php
$form = new mulForm(as_url('urok/regadmin'),$this);
$captcha = mul_captcha::use_captcha($this,['model'=>&$reg_form_struct,'form'=>&$form]);
//var_dump($reg_struct);
?>
<table>
	<tr>
	<th><label>#{._re}</label></th><td>
	<?php $form->field($reg_struct,'_re')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.id_urok}</label></th><td>
	<?php $form->field($reg_struct,'id_urok')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.id_razdel}</label></th><td>
	<?php $form->field($reg_struct,'id_razdel')->text();	 ?>	</td>
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
	<th><label>#{.video1}</label></th><td>
	<?php $form->field($reg_struct,'video1')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.video2}</label></th><td>
	<?php $form->field($reg_struct,'video2')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.video3}</label></th><td>
	<?php $form->field($reg_struct,'video3')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.document1}</label></th><td>
	<?php $form->field($reg_struct,'document1')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.document2}</label></th><td>
	<?php $form->field($reg_struct,'document2')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.hometask}</label></th><td>
	<?php $form->field($reg_struct,'hometask')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.presentation}</label></th><td>
	<?php $form->field($reg_struct,'presentation')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.text_block}</label></th><td>
	<?php $form->field($reg_struct,'text_block')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.theme}</label></th><td>
	<?php $form->field($reg_struct,'theme')->text();	 ?>	</td>
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