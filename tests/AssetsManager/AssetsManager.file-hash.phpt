<?php

use Inteve\AssetsManager\AssetsManager;
use Inteve\AssetsManager\Md5FileHashProvider;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$directory = __DIR__ . '/../temp/';
	$fileHashProvider = new Md5FileHashProvider($directory);

	$contents = [];
	$contents['a.js'] = 'document.write();';
	$contents['css/styles.css'] = 'body {color:red}';

	$manager = new AssetsManager('/assets/', NULL, [], $fileHashProvider);

	foreach ($contents as $file => $content) {
		$realPath = $directory . '/' . $file;
		@mkdir(dirname($realPath), 0777, TRUE);
		file_put_contents($realPath, $content);
		$hash = substr(md5_file($realPath), 0, 10);
		$newName = '/assets/' . str_replace('.', '.' . $hash . '.', $file);

		Assert::same($newName, $manager->getPath($file));
	}

	Assert::same('http://example.com/file.css', $manager->getPath('http://example.com/file.css'));
});
