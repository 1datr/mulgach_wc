<?php
$frm = new mulForm(as_url(''),$this);
?>
<table>
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