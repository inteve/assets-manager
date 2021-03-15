<?php

	namespace Inteve\AssetsManager\Bundles;

	use Inteve\AssetsManager\IAssetsBundle;
	use Inteve\AssetsManager\Bundle;


	class FrontpackPhotoSwipe implements IAssetsBundle
	{
		/** @var string */
		private $photoswipeBasePath;

		/** @var string|NULL */
		private $handlerBasePath;


		/**
		 * @param string $photoswipeBasePath
		 * @param string $handlerBasePath
		 */
		public function __construct($photoswipeBasePath, $handlerBasePath = NULL)
		{
			$this->photoswipeBasePath = $photoswipeBasePath . ($photoswipeBasePath !== '' ? '/' : '');

			if ($handlerBasePath !== NULL) {
				$this->handlerBasePath = $handlerBasePath . ($handlerBasePath !== '' ? '/' : '');
			}
		}


		public function getName()
		{
			return 'frontpack/photoswipe';
		}


		public function registerAssets(Bundle $bundle)
		{
			$bundle->addStylesheet($this->photoswipeBasePath . 'photoswipe.css');
			$bundle->addStylesheet($this->photoswipeBasePath . 'default-skin/default-skin.css');

			$bundle->addScript($this->photoswipeBasePath . 'photoswipe.min.js');
			$bundle->addScript($this->photoswipeBasePath . 'photoswipe-ui-default.min.js');

			if ($this->handlerBasePath !== NULL) {
				$bundle->addScript($this->handlerBasePath . 'photoswipe-handler.js');
			}
		}
	}
