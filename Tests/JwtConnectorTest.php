<?php

require_once __DIR__ . '/../vendor/autoload.php';

class JwtKeeperTest
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
	    echo $jwtKeeper->getToken();
	}
}


$t = new JwtKeeperTest();
$t->testGetToken();