<?php

	namespace Inteve\AssetsManager;

	use CzProject\Assert\Assert;
	use Nette\Utils\Html;
	use Nette\Utils\Validators;


	class AssetsManager
	{
		/** @var string */
		private $publicBasePath;

		/** @var string|NULL */
		private $defaultEnvironment;

		/** @var AssetFiles */
		private $assetFiles;

		/** @var Bundler|NULL */
		private $bundler;

		/** @var IFileHashProvider|NULL */
		private $fileHashProvider;


		/**
		 * @param  string $publicBasePath
		 * @param  string|NULL $defaultEnvironment
		 * @param  IAssetsBundle[] $assetsBundles
		 */
		public function __construct(
			$publicBasePath = '',
			$defaultEnvironment = NULL,
			array $assetsBundles = [],
			IFileHashProvider $fileHashProvider = NULL
		)
		{
			Assert::string($publicBasePath);
			Assert::stringOrNull($defaultEnvironment);
			$this->publicBasePath = $publicBasePath;
			$this->defaultEnvironment = $defaultEnvironment;
			$this->bundler = !empty($assetsBundles) ? new Bundler($assetsBundles) : NULL;
			$this->fileHashProvider = $fileHashProvider;
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

			if ($this->fileHashProvider !== NULL) {
				$hash = $this->fileHashProvider->getFileHash($path);

				if ($hash !== NULL) {
					$pathInfo = pathinfo($path);

					if (isset($pathInfo['extension'])) {
						$path = ($pathInfo['dirname'] !== '.' ? ($pathInfo['dirname'] . '/') : '') . $pathInfo['filename'] . '.' . $hash . '.' . $pathInfo['extension'];
						return rtrim($this->publicBasePath, '/') . '/' . $path;
					}
				}
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

			return $this->removeDuplicates($result);
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

			return $this->removeDuplicates($result);
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

			return $this->removeDuplicates($result);
		}


		/**
		 * @param  string|NULL $environment
		 * @return Html[]
		 */
		public function getStylesheetsTags($environment = NULL)
		{
			$tags = [];

			foreach ($this->getStylesheets($environment) as $file) {
				$rel = 'stylesheet';

				if ($file->isOfType('less')) {
					$rel = 'stylesheet/less';
				}

				$tags[] = Html::el('link')
					->rel($rel)
					->type('text/css')
					->href($this->getPath($file));
			}

			return $tags;
		}


		/**
		 * @param  string|NULL $environment
		 * @return Html[]
		 */
		public function getScriptsTags($environment = NULL)
		{
			$tags = [];

			foreach ($this->getScripts($environment) as $file) {
				$tags[] = Html::el('script')->src($this->getPath($file));
			}

			return $tags;
		}


		/**
		 * @param  string|NULL $environment
		 * @return Html[]
		 */
		public function getCriticalScriptsTags($environment = NULL)
		{
			$tags = [];

			foreach ($this->getCriticalScripts($environment) as $file) {
				$tags[] = Html::el('script')->src($this->getPath($file));
			}

			return $tags;
		}


		/**
		 * @param  AssetFile[] $files
		 * @return AssetFile[]
		 */
		private function removeDuplicates(array $files)
		{
			$result = [];
			$usedPaths = []; // path => TRUE

			foreach ($files as $file) {
				$path = $file->getPath();

				if (isset($usedPaths[$path])) {
					continue;
				}

				$result[] = $file;
				$usedPaths[$path] = TRUE;
			}

			return $result;
		}
	}
