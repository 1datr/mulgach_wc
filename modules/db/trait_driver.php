<?php
trait dbDriver {
	function query($sql){}
	function get_row($res,$idx=NULL){}
	function rowcount($res){}
}