JWT Keeper Bundle
=================

Bundle to keep fresh and valid json web token in file cache.

Installation
============

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require maciejkosiarski/jwt-keeper-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require maciejkosiarski/jwt-keeper-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
<?php
// config/bundles.php

return [
    // ...
    MaciejKosiarski\JwtKeeperBundle\JwtKeeperBundle::class => ['all' => true],
    // ...
];

```

Simple example:

```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstarctController;
use MaciejKosiarski\MonologFactoryBundle\Service\JwtKeeper;

class AppController extends AbstarctController
{
    public function index()
    {
        $jwtKeeper = new JwtKeeper('http://super-service/jwt', 'api', 'superpass');
        //return JWT in string
        $jwtKeeper->getToken();
        //return JWT in object
        $jwtKeeper->getJwt();
    }
    
    // ...
    
}
```

Services: [_JwtKeeper_](../master/Service/JwtKeeper.php), [_JwtProvider_](../master/Service/JwtProvider.php), [_JwtStorage_](../master/Service/JwtStorage.php), [_Jwt_](../master/Service/Jwt.php)