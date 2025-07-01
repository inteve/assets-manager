<?php

declare(strict_types=1);

use Inteve\AssetsManager\Bundle;
use Inteve\AssetsManager\AssetsManager;
use Inteve\AssetsManager\IAssetsBundle;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


class LibBundle implements IAssetsBundle
{
	public function getName()
	{
		return 'company/lib';
	}


	public function registerAssets(Bundle $files)
	{
		$files->addStylesheet('lib/generic.css', NULL, AssetsManager::GENERIC);
		$files->addStylesheet('lib/elements.css', NULL, AssetsManager::ELEMENTS);
		$files->addStylesheet('lib/utils.css', NULL, AssetsManager::UTILITIES);
	}
}


class CmsBundle implements IAssetsBundle
{
	public function getName()
	{
		return 'company/mycms';
	}


	public function registerAssets(Bundle $files)
	{
		$files->requireBundle('company/lib');
		$files->addStylesheet('cms/base.css', 'development', AssetsManager::GENERIC);
		$files->addStylesheet('cms/layout.css', 'development', AssetsManager::OBJECTS);
		$files->addStylesheet('cms/contact-form.css', 'development', AssetsManager::COMPONENTS);
	}
}


class WebBundle implements IAssetsBundle
{
	public function getName()
	{
		return 'company/myweb';
	}


	public function registerAssets(Bundle $files)
	{
		$files->requireBundle('company/mycms');
		$files->addStylesheet('web/layout.css', NULL, AssetsManager::OBJECTS);
		$files->addStylesheet('web/avatar.css', NULL, AssetsManager::COMPONENTS);
	}
}


test(function () {
	$manager = new AssetsManager('development', '', [
		new WebBundle,
		new LibBundle,
		new CmsBundle,
	]);

	$manager->addStylesheet('object-theme.css', NULL, AssetsManager::OBJECTS);
	$manager->requireBundle('company/myweb');

	Assert::same([
		// generic
		'lib/generic.css',
		'cms/base.css',

		// elements
		'lib/elements.css',

		// objects
		'cms/layout.css',
		'web/layout.css',
		'object-theme.css',

		// components
		'cms/contact-form.css',
		'web/avatar.css',

		// utils
		'lib/utils.css',
	], extractPaths($manager->getStylesheets()));
});
