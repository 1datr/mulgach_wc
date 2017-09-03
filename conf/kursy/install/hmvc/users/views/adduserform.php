<?php
$form = new mulForm(as_url('users/regadmin'),$this);
$captcha = mul_captcha::use_captcha($this,['model'=>&$reg_form_struct,'form'=>&$form]);
//var_dump($reg_struct);
?>
<table>
	<tr>
	<th><label>#{.login}</label></th><td>
	<?php $form->field($reg_struct,'login')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.password}</label></th><td>
	<?php $form->field($reg_struct,'password')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.password_re}</label></th><td>
	<?php $form->field($reg_struct,'password_re')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.email}</label></th><td>
	<?php $form->field($reg_struct,'email')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.id}</label></th><td>
	<?php $form->field($reg_struct,'id')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.phone}</label></th><td>
	<?php $form->field($reg_struct,'phone')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.address}</label></th><td>
	<?php $form->field($reg_struct,'address')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.web}</label></th><td>
	<?php $form->field($reg_struct,'web')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.skype}</label></th><td>
	<?php $form->field($reg_struct,'skype')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.first_name}</label></th><td>
	<?php $form->field($reg_struct,'first_name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.last_name}</label></th><td>
	<?php $form->field($reg_struct,'last_name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.status}</label></th><td>
	<?php $form->field($reg_struct,'status')->ComboBox();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.sostoyanie_dopuska}</label></th><td>
	<?php $form->field($reg_struct,'sostoyanie_dopuska')->ComboBox();	 ?>	</td>
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