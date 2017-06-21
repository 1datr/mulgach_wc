<?php 
use BootstrapListView\ListViewWidget as ListViewWidget;
use BootstrapListView\LVW_Column as LVW_Column;

$this->usewidget(new ListViewWidget($this),array('ds'=>$ds,
		'columns'=>array(
			'__default__',
			'edit'=>LVW_Column::ref_column('<a href="\?r=tasks/edit/{id_task}"><button>EDIT</button></a>'),
			'delete'=>LVW_Column::ref_column('<a href="\?r=tasks/delete/{id_task}" class="ref_delete"><button>DELETE</button></a>'),
		)
));

?>
<a href="\?r=tasks/create">NEW TASKS</a>