<?php

	namespace Inteve\AssetsManager;


	interface IFileHashProvider
	{
		/**
		 * @param  string $path
		 * @return string|NULL
		 */
		function getFileHash($path);
	}
