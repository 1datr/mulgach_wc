
<h3>#{View ATTACHEMENT} <?=$attachement->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{attachement.file_path}</label></th>
	<td valign="top">
	<?=$attachement->getField('file_path',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{attachement.comment}</label></th>
	<td valign="top">
	<?=$attachement->getField('comment',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{attachement.message_id}</label></th>
	<td valign="top">
	<?=$attachement->getField('message_id',true) ?>	</td>
	</tr>
	</table>