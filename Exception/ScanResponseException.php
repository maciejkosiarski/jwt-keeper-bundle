<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Exception;

class ScanResponseException extends \Exception
{
    public function __construct()
    {
        parent::__construct('JWT was not found in response');
    }
}
