
<h3>#{View ATTACHEMENT} <?=$attachement->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{attachement.path}</label></th>
	<td valign="top">
	<?=$attachement->getField('path',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{attachement.comment}</label></th>
	<td valign="top">
				<p><?=nl2br($attachement->getField('comment',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{attachement.message_id}</label></th>
	<td valign="top">
	<?=$attachement->getField('message_id',true) ?>	</td>
	</tr>
	</table>