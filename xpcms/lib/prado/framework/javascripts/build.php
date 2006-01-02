<?php

//Build script for compressing javascript files.
//Requires java 1.4+

$base_dir = dirname(__FILE__).'/';
$library = './';

//output directories
$outputs[] = '../js/';
$outputs[] = '../../examples/js/';
$outputs[] = '../../tests/js/';
$outputs[] = '../../../petshop/js/';

/* javascript library files */

//base javascript functions
$lib_files['base.js'][] = 'prototype/prototype.js';
$lib_files['base.js'][] = 'prototype/compat.js';
$lib_files['base.js'][] = 'prototype/base.js';
$lib_files['base.js'][] = 'extended/base.js';
$lib_files['base.js'][] = 'extended/util.js';
$lib_files['base.js'][] = 'prototype/string.js';
$lib_files['base.js'][] = 'extended/string.js';
$lib_files['base.js'][] = 'prototype/enumerable.js';
$lib_files['base.js'][] = 'prototype/array.js';
$lib_files['base.js'][] = 'extended/array.js';
$lib_files['base.js'][] = 'prototype/hash.js';
$lib_files['base.js'][] = 'prototype/range.js';
$lib_files['base.js'][] = 'extended/functional.js';
$lib_files['base.js'][] = 'prado/prado.js';
$lib_files['base.js'][] = 'effects/builder.js';

//dom functions
$lib_files['dom.js'][] = 'prototype/dom.js';
$lib_files['dom.js'][] = 'extended/dom.js';
$lib_files['dom.js'][] = 'prototype/form.js';
$lib_files['dom.js'][] = 'prototype/event.js';
$lib_files['dom.js'][] = 'extended/event.js';
$lib_files['dom.js'][] = 'prototype/position.js';
$lib_files['dom.js'][] = 'extra/getElementsBySelector.js';
$lib_files['dom.js'][] = 'extra/behaviour.js';

//effects
$lib_files['effects.js'][] = 'effects/effects.js';

//controls
$lib_files['controls.js'][] = 'effects/slider.js';
$lib_files['controls.js'][] = 'effects/controls.js';
$lib_files['controls.js'][] = 'effects/dragdrop.js';
$lib_files['controls.js'][] = 'prado/controls.js';

//logging
$lib_files['logger.js'][] = 'extra/logger.js';

$lib_files['ajax.js'][] = 'prototype/ajax.js';
$lib_files['ajax.js'][] = 'prado/ajax.js';
$lib_files['ajax.js'][] = 'prado/json.js';

//rico
$lib_files['rico.js'][] = 'effects/rico.js';

//javascript templating
$lib_files['template.js'][] = 'extra/tp_template.js';

//validator
$lib_files['validator.js'][] = 'prado/validation.js';
$lib_files['validator.js'][] = 'prado/validators.js';

//date picker
$lib_files['datepicker.js'][] = 'prado/datepicker.js';

/*============ Build the javascript files =========*/

/**
 * Collect specific libraries to be built from command line
 */
if(isset($argc))
{
	if($argc < 2)
		print_usage($lib_files);		
	else
	{
		array_shift($argv);
		build_these($argv, $library, $lib_files, $outputs);
	}
}
elseif(isset($_GET['lib']))
{
	build_these(explode(",", $_GET['lib']), $library, $lib_files, $outputs);
}
else
{
	die("Please run build.php from the command line.");
}


/*============ utility functions ==============*/

function print_usage($lib_files)
{
	echo "Usage:     php build.php [libraries]\n\n";
	echo "Example:   php build.php base validator dom\n\n";
	$available = get_available_libs($lib_files);
	echo "[libraries]:\t".implode("\n\t\t", $available);
	echo "\n\nTry: php build.php all\n";
}

function get_available_libs($lib_files)
{
	$available = array();
	foreach($lib_files as $lib => $file)
		$available[] = substr($lib, 0, -3) ;
	return $available;
}

function build_these($files, $library, $lib_files, $outputs)
{
	if(count($files) == 1 && $files[0] == 'all')
		$files = get_available_libs($lib_files);
	foreach($files as $file)
	{
		$lib = "{$file}.js";
		if(isset($lib_files[$lib]))
		{
			echo str_repeat("=", 60)."\n";
			echo "Creating {$lib}\n";
			echo str_repeat("-", 60)."\n";
			$list = get_library_files($library, $lib_files[$lib]);
			$compressed = get_compressed_content($list);
			save_contents($outputs, $lib, $compressed);
		}
	}
}

function save_contents($outputs, $output_file, $contents)
{
	echo "\n";
	$tmp_file = $output_file.'.tmp';
	file_put_contents($tmp_file, $contents);
	copy_files($outputs, $tmp_file, $output_file);
	unlink($tmp_file);
	echo "\n\n";
}

function get_library_files($lib_dir, $lib_files)
{
	$files = array();
	foreach($lib_files as $file)
	{
		if(is_file($lib_dir.$file))
			$files[] = $lib_dir.$file;
		else
			echo 'File not found '.$lib_dir.$file."\n";
	}
	return $files;
}

function get_compressed_content($files)
{
	$contents = '';
	foreach($files as $file)
	{
		$tmp_file = $file.'.tmp';
		rhino_compress($file, $tmp_file);
		$contents  .= file_get_contents($tmp_file);
		unlink($tmp_file);
	}
	return $contents;
}


function rhino_compress($input, $output)
{
	$command = 'java -jar custom_rhino.jar -c INPUT > OUTPUT';
	$find = array('INPUT', 'OUTPUT');
	$replace =  array($input, $output);
	$command = str_replace($find, $replace, $command);
	echo "   adding \t\t {$input}\n".
	system($command);
}


function copy_files($outputs, $source, $filename)
{
	foreach($outputs as $dir)
	{
		if(copy($source, $dir.$filename))
			echo "   saving as \t\t{$dir}{$filename}\n";
		else
			echo " ! Error in saving {$dir}{$filename} !\n";
	}
}

?>