<?php
/**
 * Copyright (c) 2018.
 */

/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 16.04.18
 * Time: 13:39
 */

namespace PerformanceMedia\JwtConnector\Storage;


class File implements Storage
{
    const PATH = 'var/tokens';
    /**
     * @var string
     */
    private $nameApiService;

    /**
     * File constructor.
     *
     * @param string $nameApiService
     */
    public function __construct(string $nameApiService)
    {
        $this->nameApiService = $nameApiService;
        if (!is_dir(self::PATH)) {
            mkdir(self::PATH, 0777, true);
        }
    }

    public function storeToken(string $token)
    {
        return file_put_contents($this->createFileName(), $token);
    }

    public function getToken(): string
    {
        if (!is_file($this->createFileName())) {
            return false;
        }
        return file_get_contents($this->createFileName());
    }

    protected function createFileName()
    {
        return self::PATH."/$this->nameApiService";
    }
}