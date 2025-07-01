<?php

	declare(strict_types=1);

	namespace Inteve\AssetsManager;


	interface IFileHashProvider
	{
		/**
		 * @param  string $path
		 * @return string|NULL
		 */
		function getFileHash($path);
	}
