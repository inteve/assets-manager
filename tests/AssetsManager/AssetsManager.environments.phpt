<?php

use Inteve\AssetsManager\AssetsManager;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


function createAssetsManager($environment)
{
	$manager = new AssetsManager($environment);
	$manager->addStylesheet('styles.css');
	$manager->addStylesheet('dev.css', 'development');

	$manager->addScript('scripts.js');
	$manager->addScript('prod.js', 'production');

	$manager->addCriticalScript('scripts.js');
	$manager->addCriticalScript('prod.js', 'production');

	return $manager;
}


test(function () {
	$manager = createAssetsManager('development');

	Assert::same([
		'styles.css',
		'dev.css',
	], extractPaths($manager->getStylesheets()));
});


test(function () {
	$manager = createAssetsManager('production');

	Assert::same([
		'scripts.js',
		'prod.js',
	], extractPaths($manager->getScripts()));

	Assert::same([
		'scripts.js',
		'prod.js',
	], extractPaths($manager->getCriticalScripts()));
});
