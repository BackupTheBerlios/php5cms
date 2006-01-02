<?php
list($t1, $t2) = explode(' ', microtime());
$start = $t1 + $t2;


ini_set('include_path', 
	ini_get('include_path') . 
	PATH_SEPARATOR . dirname(__FILE__) . '/lib' .
	PATH_SEPARATOR . dirname(__FILE__));

require_once 'prado/framework/prado.php';
pradoGetApplication('XpCms/application.spec')->run();

list($t1, $t2) = explode(' ', microtime());
printf('Total time: %2.4f', (($t1 + $t2) - $start));
?>
