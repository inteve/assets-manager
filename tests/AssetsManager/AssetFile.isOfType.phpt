<?php

declare(strict_types=1);

use Inteve\AssetsManager\AssetFile;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$file = new AssetFile('js/scripts.Js', NULL);
	Assert::true($file->isOfType('js'));
	Assert::true($file->isOfType('JS'));
	Assert::false($file->isOfType('Css'));
});
