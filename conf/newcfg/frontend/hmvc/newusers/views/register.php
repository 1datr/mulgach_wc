<?php
$form = new \mulForm(as_url('newusers/makeuser'),$this);
$captcha = mul_captcha::use_captcha($this,['model'=>&$reg_form_struct,'form'=>&$form]);
//var_dump($reg_struct);
?>
<table>
	<tr>
	<th><label>#{newusers.}</label></th><td>
	<?php $form->field($reg_struct,'')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{newusers._re}</label></th><td>
	<?php $form->field($reg_struct,'_re')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{newusers.login}</label></th><td>
	<?php $form->field($reg_struct,'login')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{newusers.password}</label></th><td>
	<?php $form->field($reg_struct,'password')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{newusers.email}</label></th><td>
	<?php $form->field($reg_struct,'email')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{newusers.thehash}</label></th><td>
	<?php $form->field($reg_struct,'thehash')->text();	 ?>	</td>
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