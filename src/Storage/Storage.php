<?php
/**
 * Copyright (c) 2018.
 */

/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 16.04.18
 * Time: 13:35
 */
namespace PerformanceMedia\JwtConnector\Storage;

interface Storage
{
    public function storeToken(string $token);

    public function getToken(): string;
}