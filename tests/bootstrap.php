<?php

use Inteve\AssetsManager\AssetFile;

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();


/**
 * @return void
 */
function test(callable $cb)
{
	$cb();
}


/**
 * @param  AssetFile[] $files
 * @return string[]
 */
function extractPaths(array $files)
{
	$res = [];

	foreach ($files as $file) {
		$res[] = $file->getPath();
	}

	return $res;
}


/**
 * @return string
 */
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
