
<h3>#{View PHONES} <?=$phones->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{phones.user_id}</label></th>
	<td valign="top">
	<?=$phones->getField('user_id',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{phones.name}</label></th>
	<td valign="top">
	<?=$phones->getField('name',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{phones.phone}</label></th>
	<td valign="top">
	<?=$phones->getField('phone',true) ?>	</td>
	</tr>
	</table>