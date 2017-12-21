
<h3>#{View KURSY} <?=$kursy->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{kursy.id_prep}</label></th>
	<td valign="top">
	<?=$kursy->getField('id_prep',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{kursy.name}</label></th>
	<td valign="top">
	<?=$kursy->getField('name',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{kursy.full_text}</label></th>
	<td valign="top">
				<p><?=nl2br($kursy->getField('full_text',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{kursy.small_text}</label></th>
	<td valign="top">
	<?=$kursy->getField('small_text',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{kursy.web}</label></th>
	<td valign="top">
	<?=$kursy->getField('web',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{kursy.sostoyanie_dopuska}</label></th>
	<td valign="top">
	<?=$kursy->getField('sostoyanie_dopuska',true)?>	</td>
	</tr>
	</table>