<#php
$_DATA=array(
<?php
foreach($tables as $tblidx => $tblinfo)
{
	?>
	array('url'=>'?r=<?=$tblinfo?>','capt'=>'#{<?=$tblinfo?>}'),
	<?php
}
?>
);