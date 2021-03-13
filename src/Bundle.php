<?php

	namespace Inteve\AssetsManager;


	class Bundle
	{
		/** @var Bundler */
		private $bundler;

		/** @var AssetFiles */
		private $assetFiles;

		/** @var string[] */
		private $requireBundles = [];


		public function __construct(Bundler $bundler)
		{
			$this->bundler = $bundler;
			$this->assetFiles = new AssetFiles;
		}


		/**
		 * @param  string $name
		 * @return void
		 */
		public function requireBundle($name)
		{
			$this->bundler->requireBundle($name);
			$this->requireBundles[] = $name;
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
