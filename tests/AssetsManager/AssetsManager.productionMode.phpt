<?php

use Inteve\AssetsManager\AssetsManager;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$manager = new AssetsManager(TRUE);
	Assert::true($manager->isProductionMode());

	$manager = new AssetsManager(FALSE);
	Assert::false($manager->isProductionMode());
});
