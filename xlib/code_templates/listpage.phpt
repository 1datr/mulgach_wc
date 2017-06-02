<?php
include __DIR__."{basedir}/dbconf.php";
require_once __DIR__.'{basedir}/xlib/utils.php';

include __DIR__."{basedir}/dbconnect.php";

include __DIR__."/enter.php";

include __DIR__."/inc/__capts.php";

$_TITLE = $_capts['{table}']['__TITLE__'];


$_PAGE = '{list_page_block}';

$_SUBPAGE = '{edit_page_block}';
include "./inc/basiclayout.php";
?>
