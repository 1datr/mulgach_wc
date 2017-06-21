<?php 
use BootstrapListView\ListViewWidget as ListViewWidget;
use BootstrapListView\LVW_Column as LVW_Column;

$this->usewidget(new ListViewWidget($this),array('ds'=>$ds,
		'columns'=>array(
			'__default__',
			'edit'=>LVW_Column::ref_column('<a href="\?r=projects/edit/{id_project}"><button>EDIT</button></a>'),
			'delete'=>LVW_Column::ref_column('<a href="\?r=projects/delete/{id_project}" class="ref_delete"><button>DELETE</button></a>'),
		)
));

?>
<a href="\?r=projects/create">NEW PROJECTS</a>