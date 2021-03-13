<?php

	namespace Inteve\AssetsManager;


	interface IAssetsBundle
	{
		/**
		 * @return string
		 */
		function getName();


		/**
		 * @return void
		 */
		function registerAssets(Bundle $bundle);
	}
