<?php

	declare(strict_types=1);

	namespace Inteve\AssetsManager;


	class Md5FileHashProvider implements IFileHashProvider
	{
		/** @var string */
		private $realBasePath;

		/** @var int */
		private $hashLength;


		/**
		 * @param string $realBasePath
		 * @param int $hashLength
		 */
		public function __construct($realBasePath, $hashLength = 10)
		{
			$this->realBasePath = $realBasePath;
			$this->hashLength = $hashLength;
		}


		/**
		 * @param  string $path
		 * @return string|NULL
		 */
		public function getFileHash($path)
		{
			$realPath = $this->realBasePath . '/' . $path;

			if (!is_file($realPath)) {
				return NULL;
			}

			$hash = md5_file($realPath);
			return is_string($hash) ? substr($hash, 0, $this->hashLength) : NULL;
		}
	}
