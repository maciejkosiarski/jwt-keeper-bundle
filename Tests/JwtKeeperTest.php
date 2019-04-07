<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\GuzzleException;
use MaciejKosiarski\JwtKeeperBundle\Exception\InvalidJwtContentException;
use MaciejKosiarski\JwtKeeperBundle\Exception\JwtException;
use MaciejKosiarski\JwtKeeperBundle\Service\JwtKeeper;
use MaciejKosiarski\JwtKeeperBundle\Exception\StorageFileNameException;
use MaciejKosiarski\JwtKeeperBundle\Exception\StoreTokenException;
use MaciejKosiarski\JwtKeeperBundle\Exception\UnexpectedTokenTypeException;

class JwtKeeperTest extends TestCase
{
    /**
     * @throws GuzzleException
     * @throws InvalidJwtContentException
     * @throws JwtException
     * @throws StorageFileNameException
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