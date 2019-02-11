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

class TokenApi implements Token
{
    /**
     * @var string
     */
    protected $jwtPath;
    /**
     * @var \PerformanceMedia\JwtConnector\Storage\Storage
     */
    protected $storage;
    /**
     * @var string
     */
    protected $login;
    /**
     * @var string
     */
    protected $password;

    public function __construct(string $jwtPath, Storage $storage, string $login, string $password)
    {
        $this->jwtPath = $jwtPath;
        $this->storage = $storage;
        $this->login = $login;
        $this->password = $password;
    }

    public function getToken()
    {
        return $this->fetchApiToken();
    }

    protected function fetchApiToken()
    {
        $data = ['username'=> $this->login, 'password' => $this->password];
        $datajson = json_encode($data);
        $request = curl_init();
        curl_setopt($request, CURLOPT_URL, $this->jwtPath);
        curl_setopt($request, CURLOPT_POST, true);
        curl_setopt($request, CURLOPT_POSTFIELDS,$datajson);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($datajson)
            ]
        );
        $result = curl_exec($request);
        $result = json_decode($result, true);

        if (!curl_errno($request)) {
            $httpCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
            if ($httpCode == 200) {
                $this->storage->storeToken($result['token']);
                return $result['token'];
            }
            throw new \Exception($result['message'], 410);
        }

        throw new \Exception('Error with connection. Check jwt site availability', 500);
    }
}