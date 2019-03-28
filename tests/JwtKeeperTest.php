<?php

namespace MaciejKosiarski\JwtKeeperBundle\Tests;

class JwtKeeperTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\InvalidJwtContentException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\JwtException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\StorageFileNameException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\StoreTokenException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\UnexpectedTokenTypeException
	 */
    public function testGetToken()
    {
        $jwtKeeper = new \MaciejKosiarski\JwtKeeperBundle\Service\JwtKeeper('', '', '');

        $this->assertInstanceOf(\MaciejKosiarski\JwtKeeperBundle\Service\JwtKeeper::class ,$jwtKeeper);
	}
}