
<h3>#{View RAZDEL} <?=$razdel->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{razdel.id_kurs}</label></th>
	<td valign="top">
	<?=$razdel->getField('id_kurs',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{razdel.number}</label></th>
	<td valign="top">
	<?=$razdel->getField('number',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{razdel.name}</label></th>
	<td valign="top">
	<?=$razdel->getField('name',true) ?>	</td>
	</tr>
	</table>