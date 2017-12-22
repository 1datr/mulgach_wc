
<h3>#{View BYKVA} <?=$bykva->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{bykva.bukva}</label></th>
	<td valign="top">
	<?=$bykva->getField('bukva',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{bykva.transcription}</label></th>
	<td valign="top">
	<?=$bykva->getField('transcription',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{bykva.sound}</label></th>
	<td valign="top">
	<?=$bykva->getField('sound',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{bykva.type}</label></th>
	<td valign="top">
	<?=$bykva->getField('type',true) ?>	</td>
	</tr>
	</table>