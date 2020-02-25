<?php

use Inteve\AssetsManager\AssetsManager;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$manager = new AssetsManager;
	$manager->addStylesheet('styles.css');
	$manager->addStylesheet('dev.css', 'development');

	$manager->addScript('scripts.js');
	$manager->addScript('prod.js', 'production');

	Assert::same([
		'styles.css',
	], extractPaths($manager->getStylesheets()));

	Assert::same([
		'styles.css',
		'dev.css',
	], extractPaths($manager->getStylesheets('development')));

	Assert::same([
		'scripts.js',
	], extractPaths($manager->getScripts()));

	Assert::same([
		'scripts.js',
		'prod.js',
	], extractPaths($manager->getScripts('production')));
});
