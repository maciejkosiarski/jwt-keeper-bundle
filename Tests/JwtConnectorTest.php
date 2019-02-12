<?php

require_once __DIR__ . '/../vendor/autoload.php';

class JwtKeeperTest
{
    public function testGetToken()
    {
        $jwtKeeper = new \MaciejKosiarski\JwtKeeperBundle\Service\JwtKeeper('', '', '');
	    echo $jwtKeeper->getToken();
	}
}


$t = new JwtKeeperTest();
$t->testGetToken();