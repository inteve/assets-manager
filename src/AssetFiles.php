<?php

	namespace Inteve\AssetsManager;


	class AssetFiles
	{
		/** @var array<int, AssetFile[]> */
		private $stylesheets = [];

		/** @var AssetFile[] */
		private $scripts = [];

		/** @var AssetFile[] */
		private $criticalScripts = [];


		/**
		 * @param  string $file
		 * @param  string|NULL $environment
		 * @param  int $category
		 * @return void
		 */
		public function addStylesheet($file, $environment = NULL, $category = AssetsManager::GENERIC)
		{
			if (!isset($this->stylesheets[$category])) {
				$this->stylesheets[$category] = [];
			}

			$this->stylesheets[$category][] = new AssetFile($file, $environment);
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
		 * @param  int $category
		 * @return AssetFile[]
		 */
		public function getStylesheets($environment = NULL, $category = AssetsManager::GENERIC)
		{
			return $this->getFiles(isset($this->stylesheets[$category]) ? $this->stylesheets[$category] : [], $environment);
		}


		/**
		 * @return int[]
		 */
		public function getStylesheetsCategories()
		{
			return array_keys($this->stylesheets);
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
