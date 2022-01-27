<?php

use Inteve\AssetsManager\Bundle;
use Inteve\AssetsManager\AssetsManager;
use Inteve\AssetsManager\IAssetsBundle;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


class NetteFormsBundle implements IAssetsBundle
{
	public function getName()
	{
		return 'nette/forms';
	}


	public function registerAssets(Bundle $files)
	{
		$files->addScript('nette/forms/netteForms.js');
		$files->addCriticalScript('nette/forms/netteForms-critical.js');
		$files->addStylesheet('nette/forms/netteForms.css');
	}
}


class CmsFormsBundle implements IAssetsBundle
{
	public function getName()
	{
		return 'company/mycms';
	}


	public function registerAssets(Bundle $files)
	{
		if ($files->isSubset('forms')) {
			$files->requireBundle('nette/forms');
			$files->addScript('js/forms.prod.js', 'production');
			$files->addScript('js/forms.dev.js', 'development');
			$files->addCriticalScript('js/forms.dev-critical.js', 'development');
			$files->addStylesheet('cms-forms.css', 'development');
		}
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
		$files->requireBundle('nette/forms');
		$files->requireBundle('company/mycms', 'forms');
		$files->addScript('js/web.js');
		$files->addCriticalScript('js/web-critical.js');
		$files->addStylesheet('web.css');
	}
}


test(function () {
	$manager = new AssetsManager('development', '', [
		new WebBundle,
		new NetteFormsBundle,
		new CmsFormsBundle,
	]);

	$manager->addScript('js/auto-scroll.js');
	$manager->addCriticalScript('js/auto-scroll-critical.js');
	$manager->addStylesheet('theme.css');
	$manager->requireBundle('company/myweb');

	Assert::same([
		'nette/forms/netteForms.css',
		'cms-forms.css',
		'web.css',
		'theme.css',
	], extractPaths($manager->getStylesheets()));

	Assert::same([
		'nette/forms/netteForms.js',
		'js/forms.dev.js',
		'js/web.js',
		'js/auto-scroll.js',
	], extractPaths($manager->getScripts()));

	Assert::same([
		'nette/forms/netteForms-critical.js',
		'js/forms.dev-critical.js',
		'js/web-critical.js',
		'js/auto-scroll-critical.js',
	], extractPaths($manager->getCriticalScripts()));
});
