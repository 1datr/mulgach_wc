<?php
$frm=new mulForm(as_url('workers/auth'),$this);
?>
<table>
<tr><th>#{Login}</th><td><input type="text" name="login" /></td></tr>
<tr><th>#{Password}</th><td><input type="password" name="password" /></td></tr>
<tr></tr>
</table>
<?php $frm->submit('#{Log_in}'); ?>