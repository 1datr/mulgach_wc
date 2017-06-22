<?php 
use BootstrapListView\ListViewWidget as ListViewWidget;
use BootstrapListView\LVW_Column as LVW_Column;
?>
<h3>#{TASKS LIST}</h3>
<a href="?r=tasks/create" class="btn btn-primary" role="button">#{CREATE NEW}</a>
<?
$this->usewidget(new ListViewWidget($this),array('ds'=>$ds,
		'columns'=>array(
			'__default__',
			'edit'=>LVW_Column::ref_column('<a href="?r=tasks/edit/{id_task}" role="button" class="btn btn-secondary btn-sm">#{EDIT}</a>'),
			'delete'=>LVW_Column::ref_column('<a href="?r=tasks/delete/{id_task}" role="button" class="ref_delete btn btn-secondary btn-sm">#{DELETE}</a>'),
		)
));

?>
