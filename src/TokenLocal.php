<?php
/**
 * Copyright (c) 2018.
 */

/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 18.04.18
 * Time: 13:02
 */

namespace PerformanceMedia\JwtConnector;


use PerformanceMedia\JwtConnector\Storage\Storage;

class TokenLocal implements Token
{
    private $storage;
    private $token;

    /**
     * JwtConnector constructor.
     *
     * @param \PerformanceMedia\JwtConnector\Storage\Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function getToken()
    {
        if($this->validateToken()) {
            return $this->token;
        }
        return false;
    }

    protected function validateToken()
    {
        $tokenInfo = $this->fetchStorageToken();
        if (!$tokenInfo) {
            return false;
        }
        $info = json_decode($tokenInfo['tokenInfo'], true);
        return !((new \DateTime())->format('U') > $info['exp'] - 300);
    }

    protected function fetchStorageToken() : array
    {
        $token = $this->storage->getToken();
        if (!$token) {
            return [];
        }
        $parts = explode('.', $token);
        $info = [
            'cipherAlgorithm' => base64_decode($parts[0]),
            'tokenInfo' => base64_decode($parts[1]),
            'token' => $token
        ];
        $this->token = $token;
        return $info;
    }
}