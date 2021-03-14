<?php

use Inteve\AssetsManager\Bundle;
use Inteve\AssetsManager\Bundler;
use Inteve\AssetsManager\Bundles;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

$bundler = new Bundler([]);

test(function () use ($bundler) {
	$netteFormsBundle = new Bundles\FrontpackLessBundle('');

	$bundle = new Bundle($bundler);
	$netteFormsBundle->registerAssets($bundle);

	Assert::same([
		'less.config.js',
		'less.js',
	], extractPaths($bundle->getCriticalScripts('development')));
});


test(function () use ($bundler) {
	$netteFormsBundle = new Bundles\FrontpackLessBundle('assets/path', 'production');

	$bundle = new Bundle($bundler);
	$netteFormsBundle->registerAssets($bundle);

	Assert::same([
		'assets/path/less.config.js',
		'assets/path/less.js',
	], extractPaths($bundle->getCriticalScripts('production')));
});
