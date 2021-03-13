<?php

	namespace Inteve\AssetsManager;

	use CzProject\Assert\Assert;
	use Nette\Utils\Validators;


	class AssetsManager
	{
		/** @var string */
		private $publicBasePath;

		/** @var string|NULL */
		private $defaultEnvironment;

		/** @var AssetFiles */
		private $assetFiles;


		/**
		 * @param  string $publicBasePath
		 * @param  string|NULL $defaultEnvironment
		 */
		public function __construct($publicBasePath = '', $defaultEnvironment = NULL)
		{
			Assert::string($publicBasePath);
			Assert::stringOrNull($defaultEnvironment);
			$this->publicBasePath = $publicBasePath;
			$this->defaultEnvironment = $defaultEnvironment;
			$this->assetFiles = new AssetFiles;
		}


		/**
		 * @param  string|AssetFile $path
		 * @return string
		 */
		public function getPath($path)
		{
			if ($path instanceof AssetFile) {
				$path = $path->getPath();
			}

			if (Validators::isUrl($path)) {
				return $path;
			}
			return rtrim($this->publicBasePath, '/') . '/' . $path;
		}


		/**
		 * @return string|NULL
		 */
		public function getDefaultEnvironment()
		{
			return $this->defaultEnvironment;
		}


		/**
		 * @param  string $file
		 * @param  string|NULL $environment
		 * @return void
		 */
		public function addStylesheet($file, $environment = NULL)
		{
			$this->assetFiles->addStylesheet($file, $environment);
		}


		/**
		 * @param  string $file
		 * @param  string|NULL $environment
		 * @return void
		 */
		public function addScript($file, $environment = NULL)
		{
			$this->assetFiles->addScript($file, $environment);
		}


		/**
		 * @param  string $file
		 * @param  string|NULL $environment
		 * @return void
		 */
		public function addCriticalScript($file, $environment = NULL)
		{
			$this->assetFiles->addCriticalScript($file, $environment);
		}


		/**
		 * @param  string|NULL $environment
		 * @return AssetFile[]
		 */
		public function getStylesheets($environment = NULL)
		{
			return $this->assetFiles->getStylesheets($environment);
		}


		/**
		 * @param  string|NULL $environment
		 * @return AssetFile[]
		 */
		public function getScripts($environment = NULL)
		{
			return $this->assetFiles->getScripts($environment);
		}


		/**
		 * @param  string|NULL $environment
		 * @return AssetFile[]
		 */
		public function getCriticalScripts($environment = NULL)
		{
			return $this->assetFiles->getCriticalScripts($environment);
		}
	}
