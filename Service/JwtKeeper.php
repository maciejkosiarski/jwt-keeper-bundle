<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Service;

class JwtKeeper
{
	private $jwt;
	private $jwtProvider;

	/**
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\StorageFileNameException
	 */
	public function __construct(string $serviceUrl, string $username, string $password)
	{
		$this->jwtProvider = new JwtProvider($serviceUrl, $username, $password);
	}

	/**
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\InvalidJwtContentException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\JwtException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\StoreTokenException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\UnexpectedTokenTypeException
	 */
	public function getJwt(): Jwt
	{
		$this->provideJwt();
		return $this->jwt;
	}

	/**
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\InvalidJwtContentException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\JwtException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\StoreTokenException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\UnexpectedTokenTypeException
	 */
	public function getToken(): string
	{
		return $this->getJwt()->getToken();
	}

	/**
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\InvalidJwtContentException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\JwtException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\StoreTokenException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\UnexpectedTokenTypeException
	 */
	private function provideJwt(): void
	{
		$this->jwt = $this->jwtProvider->provideJwt();
	}
}