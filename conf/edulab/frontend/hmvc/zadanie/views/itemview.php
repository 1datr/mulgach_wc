
<h3>#{View ZADANIE} <?=$zadanie->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{zadanie.id_urok}</label></th>
	<td valign="top">
			<?=$zadanie->getField('id_urok')->getView() ?>	
			</td>
	</tr>
		<tr>
	<th valign="top"><label>#{zadanie.proverka}</label></th>
	<td valign="top">
	<?=$zadanie->getField('proverka',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{zadanie.tematika}</label></th>
	<td valign="top">
	<?=$zadanie->getField('tematika',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{zadanie.title}</label></th>
	<td valign="top">
	<?=$zadanie->getField('title',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{zadanie.zadanie_text}</label></th>
	<td valign="top">
				<p><?=nl2br($zadanie->getField('zadanie_text',true)) ?></p>	</td>
	</tr>
	</table>