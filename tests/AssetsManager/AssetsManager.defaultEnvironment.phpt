<?php

use Inteve\AssetsManager\AssetsManager;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$manager = new AssetsManager;
	Assert::null($manager->getDefaultEnvironment());

	$manager = new AssetsManager('production');
	Assert::same('production', $manager->getDefaultEnvironment());
});
