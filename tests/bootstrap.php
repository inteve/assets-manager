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


function prepareTempDir()
{
	static $dirs = [];

	@mkdir(__DIR__ . '/temp/');  # @ - directory may already exist

	$tempDir = __DIR__ . '/temp/' . getmypid();

	if (!isset($dirs[$tempDir])) {
		Tester\Helpers::purge($tempDir);
		$dirs[$tempDir] = TRUE;
	}

	return $tempDir;
}
