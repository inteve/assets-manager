<?php

declare(strict_types=1);

use Inteve\AssetsManager\Bundle;
use Inteve\AssetsManager\Bundler;
use Inteve\AssetsManager\Bundles;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

$bundler = new Bundler([]);

test(function () use ($bundler) {
	$netteFormsBundle = new Bundles\NetteFormsBundle('');

	$bundle = new Bundle($bundler);
	$netteFormsBundle->registerAssets($bundle);

	Assert::same([
		'netteForms.js',
	], extractPaths($bundle->getScripts()));
});


test(function () use ($bundler) {
	$netteFormsBundle = new Bundles\NetteFormsBundle('assets/path');

	$bundle = new Bundle($bundler);
	$netteFormsBundle->registerAssets($bundle);

	Assert::same([
		'assets/path/netteForms.js',
	], extractPaths($bundle->getScripts()));
});
