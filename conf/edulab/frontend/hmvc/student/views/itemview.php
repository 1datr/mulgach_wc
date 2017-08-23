
<h3>#{View STUDENT} <?=$student->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{student.summ}</label></th>
	<td valign="top">
	<?=$student->getField('summ',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{student.login}</label></th>
	<td valign="top">
	<?=$student->getField('login',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{student.passw}</label></th>
	<td valign="top">
	<?=$student->getField('passw',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{student.user_id}</label></th>
	<td valign="top">
			<?=$student->getField('user_id')->getView() ?>	
			</td>
	</tr>
	</table>