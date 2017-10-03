<?php 
$frm=new mulForm(as_url("configs/install"),$this,[]);
?>
<label for="newcfg">#{New config name}</label>
<input type="file" name="cfgfile">
<input type="submit" class="btn btn-primary" value="#{Install config}" />
<?php 
$frm->close();
?>
