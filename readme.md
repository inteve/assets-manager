
# AssetsManager

[![Build Status](https://travis-ci.org/inteve/assets-manager.svg?branch=master)](https://travis-ci.org/inteve/assets-manager)

Assets manager for PHP apps.

<a href="https://www.paypal.me/janpecha/5eur"><img src="https://buymecoffee.intm.org/img/button-paypal-white.png" alt="Buy me a coffee" height="35"></a>


## Installation

[Download a latest package](https://github.com/inteve/assets-manager/releases) or use [Composer](http://getcomposer.org/):

```
composer require inteve/assets-manager
```

Inteve\Assets-manager requires PHP 5.6.0 or later.


## Usage

``` php
$manager = new Inteve\AssetsManager\AssetsManager;

// stylesheets
$manager->addStylesheet(string $file, string $environment = NULL);
$manager->addStylesheet('css/style.css');
$manager->addStylesheet('css/dev.css', 'development');

$assetFiles = $manager->getStylesheet(string $environment = NULL);
$assetFiles = $manager->getStylesheet(); // returns 'css/style.css'
$assetFiles = $manager->getStylesheet('development'); // returns 'css/style.css' & 'css/dev.css'


// scripts
$manager->addScript(string $file, string $environment = NULL);
$manager->addScript('js/script.js');
$manager->addScript('js/prod.js', 'production');

$assetFiles = $manager->getScripts(string $environment = NULL);
$assetFiles = $manager->getScripts(); // returns 'js/script.js'
$assetFiles = $manager->getScripts('production'); // returns 'js/script.js' & 'js/prod.js'


// critical scripts (scripts in <head> for example)
$manager->addCriticalScript(string $file, string $environment = NULL);
$manager->addCriticalScript('js/script.js');
$manager->addCriticalScript('js/prod.js', 'production');

$assetFiles = $manager->addCriticalScript(string $environment = NULL);
$assetFiles = $manager->addCriticalScript(); // returns 'js/script.js'
$assetFiles = $manager->addCriticalScript('production'); // returns 'js/script.js' & 'js/prod.js'
```

------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
