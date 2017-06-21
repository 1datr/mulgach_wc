<?php 
use BootstrapListView\ListViewWidget as ListViewWidget;
use BootstrapListView\LVW_Column as LVW_Column;

$this->usewidget(new ListViewWidget($this),array('ds'=>$ds,
		'columns'=>array(
			'__default__',
			'edit'=>LVW_Column::ref_column('<a href="\?r=otdel/edit/{id_otdel}"><button>EDIT</button></a>'),
			'delete'=>LVW_Column::ref_column('<a href="\?r=otdel/delete/{id_otdel}" class="ref_delete"><button>DELETE</button></a>'),
		)
));

?>
<a href="\?r=otdel/create">NEW OTDEL</a>