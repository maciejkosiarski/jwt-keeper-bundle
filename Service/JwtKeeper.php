<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Service;

class JwtKeeper
{
	private $jwt;
	private $jwtProvider;

	public function __construct(string $jwtPath, string $username, string $password)
	{
		$this->jwtProvider = new JwtProvider($jwtPath, $username, $password);
	}

	/**
	 * @throws \Exception
	 */
	public function getToken()
	{
		return $this->jwtProvider->provideJwt();
	}
}