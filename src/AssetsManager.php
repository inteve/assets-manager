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
		 * @param  string|NULL
		 * @return AssetFile[]
		 */
		public function getStylesheets($environment = NULL)
		{
			$res = [];

			foreach ($this->stylesheets as $file) {
				if ($file->isForEnvironment($environment)) {
					$res[] = $file;
				}
			}

			return $res;
		}


		/**
		 * @param  string|NULL
		 * @return AssetFile[]
		 */
		public function getScripts($environment = NULL)
		{
			$res = [];

			foreach ($this->scripts as $file) {
				if ($file->isForEnvironment($environment)) {
					$res[] = $file;
				}
			}

			return $res;
		}
	}
