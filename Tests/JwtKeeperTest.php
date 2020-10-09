<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Tests;

require_once __DIR__.'/../vendor/autoload.php';

use MaciejKosiarski\JwtKeeperBundle\Service\Jwt;
use MaciejKosiarski\JwtKeeperBundle\Service\JwtStorage;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\GuzzleException;
use MaciejKosiarski\JwtKeeperBundle\Exception\InvalidJwtContentException;
use MaciejKosiarski\JwtKeeperBundle\Exception\JwtException;
use MaciejKosiarski\JwtKeeperBundle\Service\JwtKeeper;
use MaciejKosiarski\JwtKeeperBundle\Exception\StorageCacheKeyException;
use MaciejKosiarski\JwtKeeperBundle\Exception\StoreTokenException;
use MaciejKosiarski\JwtKeeperBundle\Exception\UnexpectedTokenTypeException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class JwtKeeperTest extends TestCase
{
    private $testHash;

    /**
     * @throws \Psr\Cache\InvalidArgumentException
     */
    protected function setUp(): void
    {
        $this->testHash = md5('test_hash');

        $cache = new FilesystemAdapter();
        $cache->delete(JwtStorage::STORAGE .'.'. $this->testHash);
    }

    /**
     * @throws GuzzleException
     * @throws InvalidJwtContentException
     * @throws JwtException
     * @throws StorageCacheKeyException
     * @throws StoreTokenException
     * @throws UnexpectedTokenTypeException
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\RetrieveTokenException
     */
    public function testJWT(): void
    {
        $testJWT = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c';
        $storage = new JwtStorage($this->testHash);
        $storage->storeToken($testJWT);
        $expectedPayload = [
            'sub' => '1234567890',
            'name' => 'John Doe',
            'iat' => 1516239022,
        ];

        $jwtKeeper = new JwtKeeper('test', '_', 'hash');
        $this->assertInstanceOf(Jwt::class, $jwtKeeper->getJwt());
        $this->assertEquals($testJWT, $jwtKeeper->getToken());
        $this->assertEquals('JWT', $jwtKeeper->getJwt()->getType());
        $this->assertEquals('HS256', $jwtKeeper->getJwt()->getAlgorithm());
        $this->assertEquals($expectedPayload, $jwtKeeper->getJwt()->getPayload());
    }

    /**
     * @throws GuzzleException
     * @throws InvalidJwtContentException
     * @throws JwtException
     * @throws StorageCacheKeyException
     * @throws StoreTokenException
     * @throws UnexpectedTokenTypeException
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\RetrieveTokenException
     */
    public function testGuzzleRequestException(): void
    {
        $this->expectException(RequestException::class);
        $jwtKeeper = new JwtKeeper('', '', '');
        $jwtKeeper->getJwt();
	}

    /**
     * @throws \Psr\Cache\InvalidArgumentException
     */
    protected function tearDown(): void
    {
        $cache = new FilesystemAdapter();
        $cache->delete(JwtStorage::STORAGE .'.'. $this->testHash);
    }
}
