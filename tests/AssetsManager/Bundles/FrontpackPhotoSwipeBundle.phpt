<?php

use Inteve\AssetsManager\Bundle;
use Inteve\AssetsManager\Bundler;
use Inteve\AssetsManager\Bundles;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

$bundler = new Bundler([]);

test(function () use ($bundler) {
	$netteFormsBundle = new Bundles\FrontpackPhotoSwipe('');

	$bundle = new Bundle($bundler);
	$netteFormsBundle->registerAssets($bundle);

	Assert::same([
		'photoswipe.css',
		'default-skin/default-skin.css',
	], extractPaths($bundle->getStylesheets()));

	Assert::same([
		'photoswipe.min.js',
		'photoswipe-ui-default.min.js',
	], extractPaths($bundle->getScripts()));

	Assert::same([], extractPaths($bundle->getCriticalScripts()));
});


test(function () use ($bundler) {
	$netteFormsBundle = new Bundles\FrontpackPhotoSwipe('assets/path', 'assets/path-handler');

	$bundle = new Bundle($bundler);
	$netteFormsBundle->registerAssets($bundle);

	Assert::same([
		'assets/path/photoswipe.css',
		'assets/path/default-skin/default-skin.css',
	], extractPaths($bundle->getStylesheets()));

	Assert::same([
		'assets/path/photoswipe.min.js',
		'assets/path/photoswipe-ui-default.min.js',
		'assets/path-handler/photoswipe-handler.js',
	], extractPaths($bundle->getScripts()));

	Assert::same([], extractPaths($bundle->getCriticalScripts()));
});
