<?php

use Inteve\AssetsManager\AssetsManager;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$manager = new AssetsManager;
	Assert::same('/js/script.js', $manager->getPath('js/script.js'));
	Assert::same('/js/script.js', $manager->getPath('js/script.js', '/'));

	$manager = new AssetsManager('/assets');
	Assert::same('/assets/js/script.js', $manager->getPath('js/script.js'));
	Assert::same('http://example.com/styles.css', $manager->getPath('http://example.com/styles.css'));

	$manager = new AssetsManager('http://example.com/app/');
	Assert::same('http://example.com/app/js/script.js', $manager->getPath('js/script.js'));
});


test(function () {
	$manager = new AssetsManager('/assets');
	$manager->addScript('js/scripts.js');
	$manager->addScript('http://example.com/js/scripts.js');
	$result = [];

	foreach ($manager->getScripts() as $file) {
		$result[] = $manager->getPath($file);
	}

	Assert::same([
		'/assets/js/scripts.js',
		'http://example.com/js/scripts.js',
	], $result);
});
