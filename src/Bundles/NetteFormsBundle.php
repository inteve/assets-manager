<?php

	namespace Inteve\AssetsManager\Bundles;

	use Inteve\AssetsManager\IAssetsBundle;
	use Inteve\AssetsManager\Bundle;


	class NetteFormsBundle implements IAssetsBundle
	{
		/** @var string */
		private $basePath;


		/**
		 * @param string $basePath
		 */
		public function __construct($basePath)
		{
			$this->basePath = $basePath . ($basePath !== '' ? '/' : '');
		}


		public function getName()
		{
			return 'nette/forms';
		}


		public function registerAssets(Bundle $bundle)
		{
			$bundle->addScript($this->basePath . 'netteForms.js');
		}
	}
