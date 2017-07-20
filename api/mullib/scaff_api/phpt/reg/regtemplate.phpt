<?php
$frm = new mulForm(as_url('makeuser'),$this);
//var_dump($reg_struct);
?>
<table>
	<tr><th>#{users.login}</th><td><?php	$frm->field($reg_struct, 'login')->text();	?></td></tr>
	<tr><th>#{users.password}</th><td><?php	$frm->field($reg_struct, 'password')->password();	?></td></tr>
  <tr> 	  
    <th></th>
    <td>
    <?php
	$captcha->full_html();
    ?>
    </td>
  </tr>
</table>

<?php
$frm->submit('#{REGISTER}');
$frm->close();
?>