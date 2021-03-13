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

		/** @var AssetFile[] */
		private $stylesheets = [];

		/** @var AssetFile[] */
		private $scripts = [];

		/** @var AssetFile[] */
		private $criticalScripts = [];


		/**
		 * @param  string
		 * @param  string|NULL
		 */
		public function __construct($publicBasePath = '', $defaultEnvironment = NULL)
		{
			Assert::string($publicBasePath);
			Assert::stringOrNull($defaultEnvironment);
			$this->publicBasePath = $publicBasePath;
			$this->defaultEnvironment = $defaultEnvironment;
		}


		/**
		 * @param  string
		 * @return string
		 */
		public function getPath($path)
		{
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
