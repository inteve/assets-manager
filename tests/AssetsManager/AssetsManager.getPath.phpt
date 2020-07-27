<?php

use Inteve\AssetsManager\AssetsManager;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$manager = new AssetsManager;
	Assert::same('/js/script.js', $manager->getPath('js/script.js'));
	Assert::same('/js/script.js', $manager->getPath('js/script.js', '/'));
	Assert::same('/assets/js/script.js', $manager->getPath('js/script.js', '/assets'));
	Assert::same('http://example.com/app/js/script.js', $manager->getPath('js/script.js', 'http://example.com/app/'));
	Assert::same('http://example.com/styles.css', $manager->getPath('http://example.com/styles.css', '/assets'));
});
