<th style="border-left:1px;">  	
<nobr>
{FILTER}
{fld_capt}
<?php 
if(empty($_REQUEST['ord_{fld}']))
{
//<button class="btn btn-secondary dropdown-toggle" style="margin:0px;padding:0px;"></button>
	?>	 
	<a href="<?=$URL_P->make_changed_url(array('ord_{fld}'=>'ASC'))?>" title="Сортировка по возрастанию" style="font-size:10px;">{CHAR_DOWN}</a>
	<a href="<?=$URL_P->make_changed_url(array('ord_{fld}'=>'DESC'))?>" title="Сортировка по убыванию" style="font-size:10px;">{CHAR_UP}</a>
	<?php
}
elseif($_REQUEST['ord_{fld}']=='ASC')
{
	?>	
	<a href="<?=$URL_P->make_changed_url(array('ord_{fld}'=>'DESC'))?>" title="Сортировка по убыванию" style="font-size:10px;">{CHAR_UP}</a>
	<a href="<?=$URL_P->make_changed_url(array(),array('ord_{fld}'))?>" title="Отменить сортировку по полю" style="font-size:10px;">x</a>	
	<?php
}
elseif($_REQUEST['ord_{fld}']=='DESC')
{
	?>	
	<a href="<?=$URL_P->make_changed_url(array('ord_{fld}'=>'ASC'))?>" title="Сортировка по возрастанию" style="font-size:10px;">{CHAR_DOWN}</a>
	<a href="<?=$URL_P->make_changed_url(array(),array('ord_{fld}'))?>" title="Отменить сортировку по полю" style="font-size:10px;">x</a>	
	<?php
}
?>
&nbsp;
</nobr>
</th>