<?php

spl_autoload_register(function($className){
	$path = __DIR__ . '/../src/';
	
	$classNamePath = str_replace('\\', '/', $className);

	// var_dump($classNamePath, $path . $classNamePath . '.php');

	require $path . $classNamePath . '.php';
});


