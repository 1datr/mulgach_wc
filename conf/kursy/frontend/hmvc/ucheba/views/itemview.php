
<h3>#{View UCHEBA} <?=$ucheba->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{ucheba.id_uchenik}</label></th>
	<td valign="top">
	<?=$ucheba->getField('id_uchenik',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{ucheba.id_kurs}</label></th>
	<td valign="top">
	<?=$ucheba->getField('id_kurs',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{ucheba.dostup}</label></th>
	<td valign="top">
	<?=$ucheba->getField('dostup',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{ucheba.date_start}</label></th>
	<td valign="top">
	<?=$ucheba->getField('date_start',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{ucheba.date_finish}</label></th>
	<td valign="top">
	<?=$ucheba->getField('date_finish',true) ?>	</td>
	</tr>
	</table>