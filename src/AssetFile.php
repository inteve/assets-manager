<?php

	declare(strict_types=1);

	namespace Inteve\AssetsManager;

	use CzProject\Assert\Assert;


	class AssetFile
	{
		/** @var string */
		private $path;

		/** @var string|NULL */
		private $environment;


		/**
		 * @param  string $path
		 * @param  string|NULL $environment
		 */
		public function __construct($path, $environment)
		{
			Assert::string($path);
			Assert::stringOrNull($environment);

			$this->path = $path;
			$this->environment = $environment;
		}


		/**
		 * @return string
		 */
		public function getPath()
		{
			return $this->path;
		}


		/**
		 * @param  string|NULL $environment
		 * @return bool
		 */
		public function isForEnvironment($environment)
		{
			return $this->environment === NULL || $this->environment === $environment;
		}


		/**
		 * @param  string $type
		 * @return bool
		 */
		public function isOfType($type)
		{
			$extension = pathinfo($this->path, PATHINFO_EXTENSION);
			return strtolower($extension) === strtolower($type);
		}
	}
