<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Tests;

require_once __DIR__.'/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\GuzzleException;
use MaciejKosiarski\JwtKeeperBundle\Exception\InvalidJwtContentException;
use MaciejKosiarski\JwtKeeperBundle\Exception\JwtException;
use MaciejKosiarski\JwtKeeperBundle\Service\JwtKeeper;
use MaciejKosiarski\JwtKeeperBundle\Exception\StorageCacheKeyException;
use MaciejKosiarski\JwtKeeperBundle\Exception\StoreTokenException;
use MaciejKosiarski\JwtKeeperBundle\Exception\UnexpectedTokenTypeException;

class JwtKeeperTest extends TestCase
{
    /**
     * @throws GuzzleException
     * @throws InvalidJwtContentException
     * @throws JwtException
     * @throws StorageCacheKeyException
     * @throws StoreTokenException
     * @throws UnexpectedTokenTypeException
     */
    public function testGuzzleRequestException()
    {
        $this->expectException(RequestException::class);
        $jwtKeeper = new JwtKeeper('', '', '');
        $jwtKeeper->getJwt();
	}
}
