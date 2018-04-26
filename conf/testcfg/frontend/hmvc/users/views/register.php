<?php
$form = new \mulForm(as_url('users/makeuser'),$this);
$captcha = mul_captcha::use_captcha($this,['model'=>&$reg_form_struct,'form'=>&$form]);
//var_dump($reg_struct);
?>
<table>
	<tr>
	<th><label>#{users.login}</label></th><td>
	<?php $form->field($reg_struct,'login')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.password}</label></th><td>
	<?php $form->field($reg_struct,'password')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.password_re}</label></th><td>
	<?php $form->field($reg_struct,'password_re')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.email}</label></th><td>
	<?php $form->field($reg_struct,'email')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.avatar}</label></th><td>
	<?php $form->field($reg_struct,'avatar')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.status}</label></th><td>
	<?php $form->field($reg_struct,'status')->text();	 ?>	</td>
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