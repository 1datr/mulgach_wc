
<h3>#{View ZADANIE} <?=$zadanie->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{zadanie.id_urok}</label></th>
	<td valign="top">
			<?=$zadanie->getField('id_urok')->getView() ?>	
			</td>
	</tr>
		<tr>
	<th valign="top"><label>#{zadanie.s_proverkoy}</label></th>
	<td valign="top">
	<?=$zadanie->getField('s_proverkoy',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{zadanie.tematika_zadaniya}</label></th>
	<td valign="top">
	<?=$zadanie->getField('tematika_zadaniya',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{zadanie.title}</label></th>
	<td valign="top">
	<?=$zadanie->getField('title',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{zadanie.task_text}</label></th>
	<td valign="top">
				<p><?=nl2br($zadanie->getField('task_text',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{zadanie.type}</label></th>
	<td valign="top">
	<?=$zadanie->getField('type',true)?>	</td>
	</tr>
	</table>