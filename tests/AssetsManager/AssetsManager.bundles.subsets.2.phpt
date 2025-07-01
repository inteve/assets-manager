<?php

declare(strict_types=1);

use Inteve\AssetsManager\Bundle;
use Inteve\AssetsManager\AssetsManager;
use Inteve\AssetsManager\IAssetsBundle;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


class JsLibBundle implements IAssetsBundle
{
	public function getName()
	{
		return 'js/lib';
	}


	public function registerAssets(Bundle $bundle)
	{
		if ($bundle->isSubset('dom')) {
			$bundle->addScript('js/lib/dom.js');

		} elseif ($bundle->isSubset('bem')) {
			$bundle->requireBundle('js/lib', 'dom');
			$bundle->addScript('js/lib/bem.js');

		} elseif ($bundle->isSubset('modal')) {
			$bundle->requireBundle('js/lib', 'bem');
			$bundle->addScript('js/lib/modal.js');

		} else {
			throw new \RuntimeException('Unknow subset ' . $bundle->getSubset());
		}
	}
}


class CmsBundle implements IAssetsBundle
{
	public function getName()
	{
		return 'company/mycms';
	}


	public function registerAssets(Bundle $bundle)
	{
		if ($bundle->isSubset('contactForm')) {
			$bundle->requireBundle('js/lib', 'modal');

		} else {
			throw new \RuntimeException('Unknow subset ' . $bundle->getSubset());
		}
	}
}


class WebBundle implements IAssetsBundle
{
	public function getName()
	{
		return 'company/myweb';
	}


	public function registerAssets(Bundle $bundle)
	{
		$bundle->addScript('js/web.js');

		if ($bundle->isSubset('page-contact')) {
			$bundle->requireBundle('company/mycms', 'contactForm');

		} else {
			throw new \RuntimeException('Unknow subset ' . $bundle->getSubset());
		}
	}
}


test(function () {
	$manager = new AssetsManager('development', '', [
		new WebBundle,
		new JsLibBundle,
		new CmsBundle,
	]);

	$manager->addScript('js/auto-scroll.js');
	$manager->requireBundle('company/myweb', 'page-contact');

	Assert::same([
		'js/lib/dom.js',
		'js/lib/bem.js',
		'js/lib/modal.js',
		'js/web.js',
		'js/auto-scroll.js',
	], extractPaths($manager->getScripts()));
});
