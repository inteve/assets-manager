<?php

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();


function test($cb)
{
	$cb();
}


function extractPaths(array $files)
{
	$res = [];

	foreach ($files as $file) {
		$res[] = $file->getPath();
	}

	return $res;
}
