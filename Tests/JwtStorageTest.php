<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Tests;

require_once __DIR__.'/../vendor/autoload.php';

use MaciejKosiarski\JwtKeeperBundle\Exception\RetrieveTokenException;
use MaciejKosiarski\JwtKeeperBundle\Exception\StorageCacheKeyException;
use MaciejKosiarski\JwtKeeperBundle\Service\JwtStorage;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class JwtStorageTest extends TestCase
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
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\RetrieveTokenException
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\StorageCacheKeyException
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\StoreTokenException
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\UnexpectedTokenTypeException
     */
    public function testStorage(): void
    {
        $fakeToken = 'fake_token';
        $storage = new JwtStorage(md5('test_hash'));
        $storage->storeToken($fakeToken);

        $this->assertEquals($fakeToken, $storage->getToken());
    }

    public function testKeyException(): void
    {
        $this->expectException(StorageCacheKeyException::class);

        new JwtStorage('test_hash');
    }

    /**
     * @throws StorageCacheKeyException
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\RetrieveTokenException
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\UnexpectedTokenTypeException
     */
    public function testFindException(): void
    {
        $this->expectException(RetrieveTokenException::class);

        $storage = new JwtStorage(md5('test_hash'));
        $storage->getToken();
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
