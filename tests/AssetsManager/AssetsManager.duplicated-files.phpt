<?php

use Inteve\AssetsManager\Bundle;
use Inteve\AssetsManager\AssetsManager;
use Inteve\AssetsManager\IAssetsBundle;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


class BundleA implements IAssetsBundle
{
	public function getName()
	{
		return 'bundle/a';
	}


	public function registerAssets(Bundle $files)
	{
		$files->addScript('bundles/common.js');
		$files->addScript('bundles/a.js');
	}
}


class BundleB implements IAssetsBundle
{
	public function getName()
	{
		return 'bundle/b';
	}


	public function registerAssets(Bundle $files)
	{
		$files->requireBundle('bundle/a');
		$files->addScript('bundles/common.js');
		$files->addScript('bundles/b.js');
	}
}


class BundleC implements IAssetsBundle
{
	public function getName()
	{
		return 'bundle/c';
	}


	public function registerAssets(Bundle $files)
	{
		$files->requireBundle('bundle/a');
		$files->addScript('bundles/common.js');
		$files->addScript('bundles/c.js');
	}
}


test(function () {
	$manager = new AssetsManager('development', '', [
		new BundleA,
		new BundleB,
		new BundleC,
	]);

	$manager->addScript('web.js');
	$manager->requireBundle('bundle/c');
	$manager->requireBundle('bundle/b');

	Assert::same([
		'bundles/common.js',
		'bundles/a.js',
		'bundles/c.js',
		'bundles/b.js',
		'web.js'
	], extractPaths($manager->getScripts()));
});
