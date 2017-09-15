
<h3>#{View PRIMENENIYE} <?=$primeneniye->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{primeneniye.id_predlogenie}</label></th>
	<td valign="top">
	<?=$primeneniye->getField('id_predlogenie',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{primeneniye.id_lifearea}</label></th>
	<td valign="top">
	<?=$primeneniye->getField('id_lifearea',true) ?>	</td>
	</tr>
	</table>