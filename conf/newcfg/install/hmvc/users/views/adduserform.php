<?php
$form = new mulForm(as_url('users/regadmin'),$this);
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
	<th><label>#{.login}</label></th><td>
	<?php $form->field($reg_struct,'login')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.password}</label></th><td>
	<?php $form->field($reg_struct,'password')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.hash}</label></th><td>
	<?php $form->field($reg_struct,'hash')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.email}</label></th><td>
	<?php $form->field($reg_struct,'email')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{.fio}</label></th><td>
	<?php $form->field($reg_struct,'fio')->text();	 ?>	</td>
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