<?php
/**
 * Copyright (c) 2018.
 */

/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 17.04.18
 * Time: 07:31
 */
require_once __DIR__ . '/../vendor/autoload.php';

use PerformanceMedia\JwtConnector\ApiServices;
use PerformanceMedia\JwtConnector\JwtConnector;
use PerformanceMedia\JwtConnector\Storage\File;
use PerformanceMedia\JwtConnector\TokenLocal;


class JwtConnectorTest
{
    public function testGetToken()
    {
        $storage = new File(ApiServices::GOOGLE_ANALYTICS);
        $local = new TokenLocal($storage);
        $jwt = new JwtConnector(
            $local,
            '',
            $storage,
            '',
            ''
        );

        $token = $jwt->getToken();
        echo $token;
    }
}


$t = new JwtConnectorTest();
$t->testGetToken();