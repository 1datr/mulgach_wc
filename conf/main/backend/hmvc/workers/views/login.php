<?php
$frm=new mulForm('?r=workers/auth');
?>
<table>
<tr><th>#{Login}</th><td><input type="text" name="login" /></td></tr>
<tr><th>#{Password}</th><td><input type="password" name="passw" /></td></tr>
<tr></tr>
</table>
<?php $frm->submit('#{Log_in}'); ?>