<?php

declare(strict_types=1);

use Inteve\AssetsManager\AssetsManager;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


function createAssetsManager($environment)
{
	$manager = new AssetsManager($environment);
	$manager->addStylesheet('styles.css');
	$manager->addStylesheet('dev.less', 'development');

	$manager->addScript('scripts.js');
	$manager->addScript('prod.js', 'production');

	$manager->addCriticalScript('critical-scripts.js');
	$manager->addCriticalScript('critical-prod.js', 'production');

	return $manager;
}


test(function () {
	$manager = createAssetsManager('development');

	$stylesheetsTags = [];

	foreach ($manager->getStylesheetsTags() as $assetTag) {
		$stylesheetsTags[] = (string) $assetTag;
	}

	Assert::same([
		'<link rel="stylesheet" type="text/css" href="/styles.css">',
		'<link rel="stylesheet/less" type="text/css" href="/dev.less">',
	], $stylesheetsTags);
});


test(function () {
	$manager = createAssetsManager('production');

	$scriptsTags = [];

	foreach ($manager->getScriptsTags() as $assetTag) {
		$scriptsTags[] = (string) $assetTag;
	}

	Assert::same([
		'<script src="/scripts.js"></script>',
		'<script src="/prod.js"></script>',
	], $scriptsTags);

	$criticalScriptsTags = [];

	foreach ($manager->getCriticalScriptsTags() as $assetTag) {
		$criticalScriptsTags[] = (string) $assetTag;
	}

	Assert::same([
		'<script src="/critical-scripts.js"></script>',
		'<script src="/critical-prod.js"></script>',
	], $criticalScriptsTags);
});
