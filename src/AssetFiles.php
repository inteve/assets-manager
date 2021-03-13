<?php

	namespace Inteve\AssetsManager;


	class AssetFiles
	{
		/** @var AssetFile[] */
		private $stylesheets = [];

		/** @var AssetFile[] */
		private $scripts = [];

		/** @var AssetFile[] */
		private $criticalScripts = [];


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
