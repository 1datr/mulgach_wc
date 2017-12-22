
<h3>#{View ZNAK} <?=$znak->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{znak.znak}</label></th>
	<td valign="top">
	<?=$znak->getField('znak',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{znak.transcription}</label></th>
	<td valign="top">
	<?=$znak->getField('transcription',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{znak.sound}</label></th>
	<td valign="top">
	<?=$znak->getField('sound',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{znak.type}</label></th>
	<td valign="top">
	<?=$znak->getField('type',true) ?>	</td>
	</tr>
	</table>