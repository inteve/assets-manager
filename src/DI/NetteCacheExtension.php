<?php

	namespace Inteve\AssetsManager\DI;

	use Nette;


	class NetteCacheExtension extends Nette\DI\CompilerExtension
	{
		/** @var array<string, mixed> */
		private $defaults = [
		];

		/** @var string */
		private $realBasePath;

		/** @var int */
		private $hashLength;


		/**
		 * @param string $realBasePath
		 * @param int $hashLength
		 */
		public function __construct($realBasePath, $hashLength = 10)
		{
			$this->realBasePath = $realBasePath;
			$this->hashLength = $hashLength;
		}


		public function loadConfiguration()
		{
			$this->validateConfig($this->defaults);
			$builder = $this->getContainerBuilder();

			$builder->addDefinition($this->prefix('fileHashProvider'))
				->setFactory(\Inteve\AssetsManager\NetteCacheFileHashProvider::class, [
					'realBasePath' => $this->realBasePath,
					'hashLength' => $this->hashLength,
				]);
		}
	}
