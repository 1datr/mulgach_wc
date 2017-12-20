
<h3>#{View SLOG} <?=$slog->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{slog.slog}</label></th>
	<td valign="top">
	<?=$slog->getField('slog',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{slog.transcription}</label></th>
	<td valign="top">
	<?=$slog->getField('transcription',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{slog.sound}</label></th>
	<td valign="top">
	<?=$slog->getField('sound',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{slog.type}</label></th>
	<td valign="top">
	<?=$slog->getField('type',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{slog.picture}</label></th>
	<td valign="top">
	<?=$slog->getField('picture',true) ?>	</td>
	</tr>
	</table>