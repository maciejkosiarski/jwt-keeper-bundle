<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Service;

use MaciejKosiarski\JwtKeeperBundle\Exception\RetrieveTokenException;
use MaciejKosiarski\JwtKeeperBundle\Exception\StorageCacheKeyException;
use MaciejKosiarski\JwtKeeperBundle\Exception\StoreTokenException;
use MaciejKosiarski\JwtKeeperBundle\Exception\UnexpectedTokenTypeException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class JwtStorage
{
	const STORAGE = 'jwt-keeper';

	private $key;
	private $cache;

	/**
	 * @throws StorageCacheKeyException
	 */
	public function __construct(string $cacheKey)
	{
		if (!(strlen($cacheKey) === 32)) {
			throw new StorageCacheKeyException($cacheKey);
		}
        $this->key = $cacheKey;
		$this->cache = new FilesystemAdapter();
	}

	/**
	 * @throws StoreTokenException
	 */
	public function storeToken(string $token): void
	{
	    $cachedJwt = $this->cache->getItem($this->getCacheKey());
        $cachedJwt->set($token);

		if (!$this->cache->save($cachedJwt)) {
			throw new StoreTokenException($this->getCacheKey());
		}
	}

    /**
     * @throws RetrieveTokenException
     * @throws UnexpectedTokenTypeException
     */
	public function getToken(): string
	{
        $cachedJwt = $this->cache->getItem($this->getCacheKey());

        if (!$cachedJwt->isHit()) {
            throw new RetrieveTokenException();
        }

        $token = $cachedJwt->get();

        if (is_string($token)) {
            return $token;
        }

		throw new UnexpectedTokenTypeException($token, 'string');
	}

	private function getCacheKey(): string
	{
		return sprintf('%s.%s', self::STORAGE, $this->key);
	}
}
