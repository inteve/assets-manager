<?php

declare(strict_types=1);

use Inteve\AssetsManager\AssetsManager;
use Inteve\AssetsManager\Md5FileHashProvider;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


class DummyFileHashProvider implements \Inteve\AssetsManager\IFileHashProvider
{
	public function getFileHash($path)
	{
		return '000000';
	}
}


test(function () {
	$directory = __DIR__ . '/../temp/';
	$fileHashProvider = new Md5FileHashProvider($directory);

	$contents = [];
	$contents['a.js'] = 'document.write();';
	$contents['css/styles.css'] = 'body {color:red}';

	$manager = new AssetsManager('production', '/assets/', [], $fileHashProvider);

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


test(function () {
	$fileHashProvider = new DummyFileHashProvider;
	$manager = new AssetsManager('production', '/assets/', [], $fileHashProvider);

	Assert::same('/assets/scripts.000000.js', $manager->getPath('scripts.js'));
	Assert::same('/assets/styles.000000.css', $manager->getPath('styles.css'));
	Assert::same('/assets/styles.000000.less', $manager->getPath('styles.less'));
	Assert::same('/assets/favicon.ico', $manager->getPath('favicon.ico'));
	Assert::same('/assets/image.jpg', $manager->getPath('image.jpg'));
});
