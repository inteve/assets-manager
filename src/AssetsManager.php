<?php

	namespace Inteve\AssetsManager;

	use CzProject\Assert\Assert;
	use Nette\Utils\Validators;


	class AssetsManager
	{
		/** @var bool */
		private $productionMode;

		/** @var AssetFile[] */
		private $stylesheets = [];

		/** @var AssetFile[] */
		private $scripts = [];

		/** @var AssetFile[] */
		private $criticalScripts = [];


		/**
		 * @param  bool
		 */
		public function __construct($productionMode = TRUE)
		{
			Assert::bool($productionMode);
			$this->productionMode = $productionMode;
		}


		/**
		 * @param  string
		 * @param  string
		 * @return string
		 */
		public function getPath($path, $basePath = '')
		{
			if (Validators::isUrl($path)) {
				return $path;
			}
			return rtrim($basePath, '/') . '/' . $path;
		}


		/**
		 * @return bool
		 */
		public function isProductionMode()
		{
			return $this->productionMode;
		}


		/**
		 * @param  string
		 * @param  string|NULL
		 * @return void
		 */
		public function addStylesheet($file, $environment = NULL)
		{
			$this->stylesheets[] = new AssetFile($file, $environment);
		}


		/**
		 * @param  string
		 * @param  string|NULL
		 * @return void
		 */
		public function addScript($file, $environment = NULL)
		{
			$this->scripts[] = new AssetFile($file, $environment);
		}


		/**
		 * @param  string
		 * @param  string|NULL
		 * @return void
		 */
		public function addCriticalScript($file, $environment = NULL)
		{
			$this->criticalScripts[] = new AssetFile($file, $environment);
		}


		/**
		 * @param  string|NULL
		 * @return AssetFile[]
		 */
		public function getStylesheets($environment = NULL)
		{
			return $this->getFiles($this->stylesheets, $environment);
		}


		/**
		 * @param  string|NULL
		 * @return AssetFile[]
		 */
		public function getScripts($environment = NULL)
		{
			return $this->getFiles($this->scripts, $environment);
		}


		/**
		 * @param  string|NULL
		 * @return AssetFile[]
		 */
		public function getCriticalScripts($environment = NULL)
		{
			return $this->getFiles($this->criticalScripts, $environment);
		}


		private function getFiles(array $files, $environment = NULL)
		{
			$res = [];

			foreach ($files as $file) {
				if ($file->isForEnvironment($environment)) {
					$res[] = $file;
				}
			}

			return $res;
		}
	}
