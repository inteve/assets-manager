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

		/** @var array<string, IAssetsBundle> */
		private $assetsBundles;

		/** @var AssetFiles */
		private $assetFiles;

		/** @var Bundler|NULL */
		private $bundler;


		/**
		 * @param  string $publicBasePath
		 * @param  string|NULL $defaultEnvironment
		 * @param  IAssetsBundle[] $assetsBundles
		 */
		public function __construct(
			$publicBasePath = '',
			$defaultEnvironment = NULL,
			array $assetsBundles = []
		)
		{
			Assert::string($publicBasePath);
			Assert::stringOrNull($defaultEnvironment);
			$this->publicBasePath = $publicBasePath;
			$this->defaultEnvironment = $defaultEnvironment;
			$this->bundler = !empty($assetsBundles) ? new Bundler($assetsBundles) : NULL;
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
		 * @param  string $name
		 * @return void
		 */
		public function requireBundle($name)
		{
			if ($this->bundler === NULL) {
				throw new InvalidStateException('No bundles.');
			}

			$this->bundler->requireBundle($name);
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
			$result = $this->bundler !== NULL ? $this->bundler->getStylesheets($environment) : [];

			foreach ($this->assetFiles->getStylesheets($environment) as $file) {
				$result[] = $file;
			}

			return $result;
		}


		/**
		 * @param  string|NULL $environment
		 * @return AssetFile[]
		 */
		public function getScripts($environment = NULL)
		{
			$result = $this->bundler !== NULL ? $this->bundler->getScripts($environment) : [];

			foreach ($this->assetFiles->getScripts($environment) as $file) {
				$result[] = $file;
			}

			return $result;
		}


		/**
		 * @param  string|NULL $environment
		 * @return AssetFile[]
		 */
		public function getCriticalScripts($environment = NULL)
		{
			$result = $this->bundler !== NULL ? $this->bundler->getCriticalScripts($environment) : [];

			foreach ($this->assetFiles->getCriticalScripts($environment) as $file) {
				$result[] = $file;
			}

			return $result;
		}
	}
