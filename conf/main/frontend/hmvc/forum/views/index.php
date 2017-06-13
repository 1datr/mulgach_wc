<?php 
use BootstrapListView\ListViewWidget as ListViewWidget;
use BootstrapListView\LVW_Column as LVW_Column;

$this->usewidget(new ListViewWidget(),array('ds'=>$ds,
		'columns'=>array(
			'__default__',
			'edit'=>LVW_Column::ref_column('<a href="\?r=forum/edit/{id}"><button>EDIT</button></a>'),
			'delete'=>LVW_Column::ref_column('<a href="\?r=forum/delete/{id}" class="ref_delete"><button>DELETE</button></a>'),
		)
));

?>
<a href="\?r=forum/create">NEW FORUM</a>