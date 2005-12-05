<?php

ini_set('include_path', 
	ini_get('include_path') . 
	PATH_SEPARATOR . dirname(__FILE__) . '/lib' .
	PATH_SEPARATOR . dirname(__FILE__));

require_once 'prado/framework/prado.php';
pradoGetApplication('XpCms/application.spec')->run();
?>
