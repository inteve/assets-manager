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
		 * @param  string $publicBasePath
		 * @param  string|NULL $defaultEnvironment
		 */
		public function __construct($publicBasePath = '', $defaultEnvironment = NULL)
		{
			Assert::string($publicBasePath);
			Assert::stringOrNull($defaultEnvironment);
			$this->publicBasePath = $publicBasePath;
			$this->defaultEnvironment = $defaultEnvironment;
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
			$this->stylesheets[] = new AssetFile($file, $environment);
		}


		/**
		 * @param  string $file
		 * @param  string|NULL $environment
		 * @return void
		 */
		public function addScript($file, $environment = NULL)
		{
			$this->scripts[] = new AssetFile($file, $environment);
		}


		/**
		 * @param  string $file
		 * @param  string|NULL $environment
		 * @return void
		 */
		public function addCriticalScript($file, $environment = NULL)
		{
			$this->criticalScripts[] = new AssetFile($file, $environment);
		}


		/**
		 * @param  string|NULL $environment
		 * @return AssetFile[]
		 */
		public function getStylesheets($environment = NULL)
		{
			return $this->getFiles($this->stylesheets, $environment);
		}


		/**
		 * @param  string|NULL $environment
		 * @return AssetFile[]
		 */
		public function getScripts($environment = NULL)
		{
			return $this->getFiles($this->scripts, $environment);
		}


		/**
		 * @param  string|NULL $environment
		 * @return AssetFile[]
		 */
		public function getCriticalScripts($environment = NULL)
		{
			return $this->getFiles($this->criticalScripts, $environment);
		}


		/**
		 * @param  AssetFile[] $files
		 * @param  string|NULL $environment
		 * @return AssetFile[]
		 */
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
