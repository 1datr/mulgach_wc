<?php
$form = new mulForm(as_url('workers/makeuser'),$this);
$captcha = mul_captcha::use_captcha($this,['model'=>&$reg_form_struct,'form'=>&$form]);
//var_dump($reg_struct);
?>
<table>
	<tr>
	<th><label>#{workers.login}</label></th><td>
	<?php $form->field($reg_struct,'login')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.password}</label></th><td>
	<?php $form->field($reg_struct,'password')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.password_re}</label></th><td>
	<?php $form->field($reg_struct,'password_re')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.mail1}</label></th><td>
	<?php $form->field($reg_struct,'mail1')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.number}</label></th><td>
	<?php $form->field($reg_struct,'number')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.fio}</label></th><td>
	<?php $form->field($reg_struct,'fio')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.fio_eng}</label></th><td>
	<?php $form->field($reg_struct,'fio_eng')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.position}</label></th><td>
	<?php $form->field($reg_struct,'position')->ComboBox();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.city}</label></th><td>
	<?php $form->field($reg_struct,'city')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.address1}</label></th><td>
	<?php $form->field($reg_struct,'address1')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.address2}</label></th><td>
	<?php $form->field($reg_struct,'address2')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.mail2}</label></th><td>
	<?php $form->field($reg_struct,'mail2')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.phone1}</label></th><td>
	<?php $form->field($reg_struct,'phone1')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.phone2}</label></th><td>
	<?php $form->field($reg_struct,'phone2')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.phone3}</label></th><td>
	<?php $form->field($reg_struct,'phone3')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.responsibility}</label></th><td>
	<?php $form->field($reg_struct,'responsibility')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.is_arhiv}</label></th><td>
	<?php $form->field($reg_struct,'is_arhiv')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{workers.level}</label></th><td>
	<?php $form->field($reg_struct,'level')->text();	 ?>	</td>
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