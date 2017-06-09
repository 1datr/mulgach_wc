<#php 
use BootstrapListView\ListViewWidget as ListViewWidget;
use BootstrapListView\LVW_Column as LVW_Column;

$this->usewidget(new ListViewWidget(),array('ds'=>$ds,
		'columns'=>array(
			'__default__',
			'edit'=>LVW_Column::ref_column('<a href="\?r={table}/edit/{{primary}}"><button>EDIT</button></a>'),
			'delete'=>LVW_Column::ref_column('<a href="\?r={table}/delete/{{primary}}" class="ref_delete"><button>DELETE</button></a>'),
		)
));

#>
<a href="\?r={table}/create">NEW {TABLE_UC}</a>