<?php
$frm = new mulForm(as_url('makeuser'),$this);
//var_dump($reg_struct);
?>
<table>
	<tr>
	<th><label>#{{table}.id}</label></th><td>
	<?php $form->field(${table},'id')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{{table}.login}</label></th><td>
	<?php $form->field(${table},'login')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{{table}.password}</label></th><td>
	<?php $form->field(${table},'password')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{{table}.first_name}</label></th><td>
	<?php $form->field(${table},'first_name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{{table}.last_name}</label></th><td>
	<?php $form->field(${table},'last_name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{{table}.phone}</label></th><td>
	<?php $form->field(${table},'phone')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{{table}.web}</label></th><td>
	<?php $form->field(${table},'web')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{{table}.address}</label></th><td>
	<?php $form->field(${table},'address')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{{table}.sostoyanie_dopuska}</label></th><td>
	<?php $form->field(${table},'sostoyanie_dopuska')->ComboBox();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{{table}.skype}</label></th><td>
	<?php $form->field(${table},'skype')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{{table}.status}</label></th><td>
	<?php $form->field(${table},'status')->ComboBox();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{{table}.hash}</label></th><td>
	<?php $form->field(${table},'hash')->text();	 ?>	</td>
	</tr>
	  <tr> 	  
    <th></th>
    <td>
    <? $captcha->full_html();  ?>
    </td>
  </tr>
</table>

<?php
$frm->submit('#{REGISTER}');
$frm->close();
?>