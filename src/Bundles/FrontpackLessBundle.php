<?php

	namespace Inteve\AssetsManager\Bundles;

	use Inteve\AssetsManager\IAssetsBundle;
	use Inteve\AssetsManager\Bundle;


	class FrontpackLessBundle implements IAssetsBundle
	{
		/** @var string */
		private $basePath;

		/** @var string|NULL */
		private $environment;


		/**
		 * @param string $basePath
		 * @param string|NULL $environment
		 */
		public function __construct($basePath, $environment = 'development')
		{
			$this->basePath = $basePath . ($basePath !== '' ? '/' : '');
			$this->environment = $environment;
		}


		public function getName()
		{
			return 'frontpack/less';
		}


		public function registerAssets(Bundle $bundle)
		{
			$bundle->addCriticalScript($this->basePath . 'less.config.js', $this->environment);
			$bundle->addCriticalScript($this->basePath . 'less.js', $this->environment);
		}
	}
