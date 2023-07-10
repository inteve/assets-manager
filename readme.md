
# AssetsManager

[![Tests Status](https://github.com/inteve/assets-manager/workflows/Tests/badge.svg)](https://github.com/inteve/assets-manager/actions)

Assets manager for PHP apps.

<a href="https://www.janpecha.cz/donate/"><img src="https://buymecoffee.intm.org/img/donate-banner.v1.svg" alt="Donate" height="100"></a>


## Installation

[Download a latest package](https://github.com/inteve/assets-manager/releases) or use [Composer](http://getcomposer.org/):

```
composer require inteve/assets-manager
```

Inteve\Assets-manager requires PHP 5.6.0 or later.


## Usage

``` php
$currentEnvironment = PRODUCTION_MODE ? 'production' : 'development';
$manager = new Inteve\AssetsManager\AssetsManager($currentEnvironment, '/public/path');


// get public file path
echo $manager->getPath('css/my-file.css'); // '/public/path/css/my-file.css'
echo $manager->getPath('imgs/avatar.png'); // '/public/path/imgs/avatar.png'


// stylesheets
$manager->addStylesheet(string $file, string $environment = NULL);
$manager->addStylesheet('css/style.css');
$manager->addStylesheet('css/dev.css', 'development');

$assetFiles = $manager->getStylesheet();


// scripts
$manager->addScript(string $file, string $environment = NULL);
$manager->addScript('js/script.js');
$manager->addScript('js/prod.js', 'production');

$assetFiles = $manager->getScripts();


// critical scripts (scripts in <head> for example)
$manager->addCriticalScript(string $file, string $environment = NULL);
$manager->addCriticalScript('js/script.js');
$manager->addCriticalScript('js/prod.js', 'production');

$assetFiles = $manager->getCriticalScripts();
```


### HTML tags

```php
foreach ($manager->getStylesheetsTags() as $tag) {
	echo $tag;
}


foreach ($manager->getScriptsTags() as $tag) {
	echo $tag;
}


foreach ($manager->getCriticalScriptsTags() as $tag) {
	echo $tag;
}
```


### Cache busting

```php
$fileHashProvider = new Inteve\AssetsManager\Md5FileHashProvider(__DIR__ . '/real/path/to/assets');
$manager = new Inteve\AssetsManager\AssetsManager(
	$currentEnvironment,
	'/public/path/to/assets',
	[],
	$fileHashProvider
);

echo $manager->getPath('css/styles.css'); // prints something like '/public/path/to/assets/css/styles.ab9cd8ef76.css'
```


### External sources

*This isn't recommended usage.*

```php
$manager->addScripts('https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js');
```


### Bundles

```php
class JQueryBundle implements Inteve\AssetsManager\IAssetsBundle
{
	function getName()
	{
		return 'jquery';
	}


	function registerAssets(Bundle $bundle)
	{
		$bundle->addScripts('https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js');
	}
}


class ContactFormBundle implements Inteve\AssetsManager\IAssetsBundle
{
	function getName()
	{
		return 'myweb/contactForm';
	}


	function registerAssets(Bundle $bundle)
	{
		$bundle->requireBundle('jquery');
		$bundle->addScripts('components/contact-form.js');
		$bundle->addStylesheet('components/contact-form.css');
	}
}

$manager = new Inteve\AssetsManager\AssetsManager(
	$currentEnvironment,
	'/public/path/to/assets',
	[
		new JQueryBundle,
		new ContactFormBundle,
	]
);
$manager->requireBundle('myweb/contactForm');

echo implode("\n", $manager->getScriptsTags());
echo implode("\n", $manager->getStylesheetsTags());
```

Prints:

```html
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="/public/path/to/assets/components/contact-form.js"></script>
<link rel="stylesheet" type="text/css" href="/public/path/to/assets/components/contact-form.css">
```


------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
