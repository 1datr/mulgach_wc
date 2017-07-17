<h3>#{Translations}</h3>
<?php 
$form = new mulForm(as_url('lang/search'),$this
		//,array('method'=>'get')
		);
$dr = $this->_MODEL->empty_row_form_model();
?>
<table>
<tr>
<?php 
$langs = Lang::get_langs();
if(count($langs)>1)
{
	?>
	<td><?php $form->field($dr, 'lang')->ComboBox($langs); ?></td>
	<?php 
}
else 
	{
		?>
		<?php $form->field($dr, 'lang')->hidden(['value'=>$langs[0]]); ?>
		<?php 
	}	
?>
<td><?php $form->field($dr, 'langkey')->text(['htmlattrs'=>['placeholder'=>Lang::__t('language')],
		//'name'=>'lang'		
]);?></td>
<td><?php $form->field($dr, 'translation')->text(['htmlattrs'=>['placeholder'=>Lang::__t('translation')]]);?></td>
<td><?php $form->submit(Lang::__t('Search')) ?></td>
</tr>
</table>
<?php 
$form->close();
?>