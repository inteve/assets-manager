<?php

use Inteve\AssetsManager\AssetsManager;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$manager = new AssetsManager;
	$manager->addStylesheet('styles.css');
	$manager->addStylesheet('dev.less', 'development');

	$manager->addScript('scripts.js');
	$manager->addScript('prod.js', 'production');

	$manager->addCriticalScript('critical-scripts.js');
	$manager->addCriticalScript('critical-prod.js', 'production');

	$stylesheetsTags = [];

	foreach ($manager->getStylesheetsTags('development') as $assetTag) {
		$stylesheetsTags[] = (string) $assetTag;
	}

	Assert::same([
		'<link rel="stylesheet" type="text/css" href="/styles.css">',
		'<link rel="stylesheet/less" type="text/css" href="/dev.less">',
	], $stylesheetsTags);

	$scriptsTags = [];

	foreach ($manager->getScriptsTags('production') as $assetTag) {
		$scriptsTags[] = (string) $assetTag;
	}

	Assert::same([
		'<script src="/scripts.js"></script>',
		'<script src="/prod.js"></script>',
	], $scriptsTags);

	$criticalScriptsTags = [];

	foreach ($manager->getCriticalScriptsTags('production') as $assetTag) {
		$criticalScriptsTags[] = (string) $assetTag;
	}

	Assert::same([
		'<script src="/critical-scripts.js"></script>',
		'<script src="/critical-prod.js"></script>',
	], $criticalScriptsTags);
});
