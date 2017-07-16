<h3>#{Translations}</h3>
<?php 
$form = new mulForm(as_url('lang/search'),$this
		//,array('method'=>'get')
		);
$dr = $this->_MODEL->empty_row_form_model();
?>
<table>
<tr>
<td><?php 
$langs = Lang::get_langs();

?></td>
<td><?php $form->field($dr, 'lang')->text(['htmlattrs'=>['placeholder'=>Lang::__t('language')]]);?></td>
<td><?php $form->field($dr, 'translation')->text(['htmlattrs'=>['placeholder'=>Lang::__t('translation')]]);?></td>
<td><?php $form->submit(Lang::__t('Search')) ?></td>
</tr>
</table>
<?php 
$form->close();
?>