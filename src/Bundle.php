<?php

	declare(strict_types=1);

	namespace Inteve\AssetsManager;


	class Bundle
	{
		/** @var Bundler */
		private $bundler;

		/** @var string|NULL */
		private $subset;

		/** @var AssetFiles */
		private $assetFiles;

		/** @var string[] */
		private $requireBundles = [];


		/**
		 * @param Bundler $bundler
		 * @param string|NULL $subset
		 */
		public function __construct(Bundler $bundler, $subset = NULL)
		{
			$this->bundler = $bundler;
			$this->subset = $subset;
			$this->assetFiles = new AssetFiles;
		}


		/**
		 * @param  string $subset
		 * @return bool
		 */
		public function isSubset($subset)
		{
			return $this->subset === $subset;
		}


		/**
		 * @return string|NULL
		 */
		public function getSubset()
		{
			return $this->subset;
		}


		/**
		 * @param  string $name
		 * @param  string|NULL $subset
		 * @return void
		 */
		public function requireBundle($name, $subset = NULL)
		{
			$this->bundler->requireBundle($name, $subset);
			$this->requireBundles[] = Bundler::formatBundleId($name, $subset);
		}


		/**
		 * @return string[]
		 */
		public function getRequiredBundles()
		{
			return $this->requireBundles;
		}


		/**
		 * @param  string $file
		 * @param  string|NULL $environment
		 * @param  int $category
		 * @return void
		 */
		public function addStylesheet($file, $environment = NULL, $category = AssetsManager::GENERIC)
		{
			$this->assetFiles->addStylesheet($file, $environment, $category);
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
		 * @param  int $category
		 * @return AssetFile[]
		 */
		public function getStylesheets($environment = NULL, $category = AssetsManager::GENERIC)
		{
			return $this->assetFiles->getStylesheets($environment, $category);
		}


		/**
		 * @return int[]
		 */
		public function getStylesheetsCategories()
		{
			return $this->assetFiles->getStylesheetsCategories();
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
