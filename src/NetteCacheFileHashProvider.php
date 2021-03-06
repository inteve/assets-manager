<?php

	namespace Inteve\AssetsManager;

	use Nette;


	class NetteCacheFileHashProvider implements IFileHashProvider
	{
		/** @var Nette\Caching\Cache */
		private $cache;

		/** @var string */
		private $realBasePath;

		/** @var IFileHashProvider */
		private $fileHashProvider;


		/**
		 * @param string $realBasePath
		 * @param int $hashLength
		 */
		public function __construct($realBasePath, $hashLength = 10, Nette\Caching\IStorage $storage)
		{
			$this->cache = new Nette\Caching\Cache($storage, 'inteve/assets-manager');
			$this->realBasePath = $realBasePath;
			$this->fileHashProvider = new Md5FileHashProvider($realBasePath, $hashLength);
		}


		/**
		 * @param  string $path
		 * @return string|NULL
		 */
		public function getFileHash($path)
		{
			return $this->cache->load($this->realBasePath . '/' . $path, function () use ($path) {
				return $this->fileHashProvider->getFileHash($path);
			});
		}
	}
