<?php
/**
 * Copyright (c) 2018.
 */

/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 16.04.18
 * Time: 13:04
 */
namespace PerformanceMedia\JwtConnector;

use PerformanceMedia\JwtConnector\Storage\Storage;

class JwtConnector extends TokenApi
{
    /**
     * @var \PerformanceMedia\JwtConnector\TokenLocal
     */
    private $token;

    public function __construct(TokenLocal $token = null, string $jwtPath, Storage $storage, string $login, string $password)
    {
        parent::__construct($jwtPath, $storage, $login, $password);
        $this->token = $token;
    }

    public function getToken()
    {
        if ($this->token !== null && $token = $this->token->getToken()) {
            return $token;
        }
        return parent::getToken();
    }
}