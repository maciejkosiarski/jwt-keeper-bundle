<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Exception;

class RetrieveTokenException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Could not find token in cache. Something is broken.');
    }
}
