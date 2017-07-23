<?php
$form = new mulForm(as_url('makeuser'),$this);
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
	<th><label>#{users.hash}</label></th><td>
	<?php $form->field($reg_struct,'hash')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.phone}</label></th><td>
	<?php $form->field($reg_struct,'phone')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.address}</label></th><td>
	<?php $form->field($reg_struct,'address')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.web}</label></th><td>
	<?php $form->field($reg_struct,'web')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.skype}</label></th><td>
	<?php $form->field($reg_struct,'skype')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.first_name}</label></th><td>
	<?php $form->field($reg_struct,'first_name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.last_name}</label></th><td>
	<?php $form->field($reg_struct,'last_name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.status}</label></th><td>
	<?php $form->field($reg_struct,'status')->ComboBox();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.sostoyanie_dopuska}</label></th><td>
	<?php $form->field($reg_struct,'sostoyanie_dopuska')->ComboBox();	 ?>	</td>
	</tr>
	  <tr> 	  
    <th></th>
    <td>
    <? $captcha->full_html();  ?>
    </td>
  </tr>
</table>

<?php
$form->submit('#{REGISTER}');
$form->close();
?>