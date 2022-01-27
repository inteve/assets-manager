<?php

	namespace Inteve\AssetsManager;


	class Bundler
	{
		/** @var array<string, IAssetsBundle> */
		private $assetsBundles;

		/** @var array<string, Bundle> */
		private $requiredBundles = [];

		/** @var Bundle[]|NULL */
		private $sortedBundles;


		/**
		 * @param  IAssetsBundle[] $assetsBundles
		 */
		public function __construct(array $assetsBundles = [])
		{
			$this->assetsBundles = [];

			foreach ($assetsBundles as $assetsBundle) {
				$bundleName = $assetsBundle->getName();

				if (isset($this->assetsBundles[$bundleName])) {
					throw new InvalidStateException("Bundle '$bundleName' already exists.");
				}

				$this->assetsBundles[$bundleName] = $assetsBundle;
			}
		}


		/**
		 * @param  string $name
		 * @param  string|NULL $subset
		 * @return void
		 */
		public function requireBundle($name, $subset = NULL)
		{
			$bundleId = self::formatBundleId($name, $subset);

			if (isset($this->requiredBundles[$bundleId])) { // already required
				return;
			}

			if (!isset($this->assetsBundles[$name])) {
				throw new InvalidArgumentException("Bundle '$name' not exists.");
			}

			$bundle = new Bundle($this, $subset);
			$this->requiredBundles[$bundleId] = $bundle;
			$this->assetsBundles[$name]->registerAssets($bundle);
		}


		/**
		 * @param  string|NULL $environment
		 * @return AssetFile[]
		 */
		public function getStylesheets($environment = NULL)
		{
			$result = [];

			foreach ($this->getSortedBundles() as $bundle) {
				$files = $bundle->getStylesheets($environment);
				$result = array_merge($result, $files);
			}

			return $result;
		}


		/**
		 * @param  string|NULL $environment
		 * @return AssetFile[]
		 */
		public function getScripts($environment = NULL)
		{
			$result = [];

			foreach ($this->getSortedBundles() as $bundle) {
				$files = $bundle->getScripts($environment);
				$result = array_merge($result, $files);
			}

			return $result;
		}


		/**
		 * @param  string|NULL $environment
		 * @return AssetFile[]
		 */
		public function getCriticalScripts($environment = NULL)
		{
			$result = [];

			foreach ($this->getSortedBundles() as $bundle) {
				$files = $bundle->getCriticalScripts($environment);
				$result = array_merge($result, $files);
			}

			return $result;
		}


		/**
		 * @return Bundle[]
		 */
		private function getSortedBundles()
		{
			if ($this->sortedBundles === NULL) {
				$resolver = new \CzProject\DependencyPhp\Resolver;

				foreach ($this->requiredBundles as $bundleName => $bundle) {
					$resolver->add($bundleName, $bundle->getRequiredBundles());
				}

				$this->sortedBundles = [];

				foreach ($resolver->getResolved() as $bundleName) {
					$this->sortedBundles[] = $this->requiredBundles[$bundleName];
				}
			}

			return $this->sortedBundles;
		}


		/**
		 * @param  string $name
		 * @param  string|NULL $subset
		 * @return string
		 */
		public static function formatBundleId($name, $subset)
		{
			if ($subset === NULL) {
				return $name;
			}

			return $name . '@' . $subset;
		}
	}
