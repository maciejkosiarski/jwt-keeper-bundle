<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Service;

class Jwt
{
	private $token;
	private $header;
	private $payload;

	public function __construct(string $token, $header, $payload)
	{
		$this->token = $token;
		$this->header = $header;
		$this->payload = $payload;
	}

	public function getToken(): string
	{
		return $this->token;
	}

	public function getHeader()
	{
		return $this->header;
	}

	public function getPayload()
	{
		return $this->payload;
	}
}