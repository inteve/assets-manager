<?php

declare(strict_types=1);

use Inteve\AssetsManager\IFileHashProvider;
use Inteve\AssetsManager\NetteCacheFileHashProvider;
use Nette\Configurator;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';
define('TEMP_DIR', prepareTempDir());
define('WWW_DIR', TEMP_DIR . '/www');
@mkdir(WWW_DIR, 0777, TRUE);

test(function () {
	$configurator = new Configurator;
	$configurator->setTempDirectory(TEMP_DIR);
	$configurator->addParameters([
		'wwwDir' => WWW_DIR,
	]);
	$configurator->addConfig(__DIR__ . '/config/NetteCacheExtension.1.neon');

	/** @var \Nette\DI\Container $container */
	$container = $configurator->createContainer();
	Assert::true($container instanceof \Nette\DI\Container);

	$fileHashProvider = $container->getByType(IFileHashProvider::class);
	Assert::true($fileHashProvider instanceof NetteCacheFileHashProvider);

	$content = 'Hello';
	file_put_contents(WWW_DIR . '/style.css', $content);

	Assert::same(substr(md5($content), 0, 8), $fileHashProvider->getFileHash('style.css'));
});
