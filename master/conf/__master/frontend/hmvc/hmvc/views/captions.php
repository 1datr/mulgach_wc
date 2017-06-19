<h3>#{CAPTIONS}</h3>
<?php 
$table = $_SESSION['makeinfo']['table'];
?>

  

<?php 
$eps = $_SESSION['makeinfo']['ep'];
unset($eps['rest']);
$eps = array_keys($eps);
?>
<ul class="nav nav-tabs" role="tablist">
<?php 
foreach ($eps as $idx => $_ep)
{
	?>
	<li class="nav-item">
	<a class="nav-link <?=(($idx==0)?'active':'')?>" data-toggle="tab" href="#capts_<?=$_ep?>" role="tab"><?=$_ep?></a>
	</li>		
	<?php	
}
?>
</ul>
<div class="tab-content">
<?php 
//print_r($_SESSION);
foreach ($eps as $idx => $_ep)
{
	?>
	<div class="tab-pane <?=(($idx==0)?'active':'')?>" id="capts_<?=$_ep?>" role="tabpanel">
	<table>
  	<tr>
    	<th>#{FieldName}</th>
    	<th>#{FieldCaption}</th>
  	</tr>
	<?php 
	foreach ($fields as $fld => $fldinfo)
	{
		?>
		<tr>
		<th><?=$fld?></th>
		<?php 
		$thelang=new Lang(NULL, $_SESSION['makeinfo']['conf'],$_ep);
		$lang_val = $thelang->getkey($table.'.'.$fld);
		?>
		<td><input type="text" name="captions[<?=$_ep?>][<?=$table?>.<?=$fld?>]" value="<?=($lang_val!=NULL) ? $lang_val: $fld?>" /></td>
		</tr>
		<?php 
	}
	?>
	</table>
	</div>
	<?php 
}
?>
</div>
