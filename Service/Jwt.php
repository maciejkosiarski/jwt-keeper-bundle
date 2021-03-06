<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Service;

use MaciejKosiarski\JwtKeeperBundle\Exception\JwtException;

class Jwt
{
	private $token;
	private $type;
	private $algorithm;
	private $expiration;
	private $issuedAt;
	private $payload;

	/**
	 * @throws JwtException
	 */
	public function __construct(string $token, string $header, string $payload)
	{
		$this->token = $token;

		$this->loadJwt($header, $payload);
	}

	public function getToken(): string
	{
		return $this->token;
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function getAlgorithm(): string
	{
		return $this->algorithm;
	}

	public function getExpiration(): ?int
	{
		return $this->expiration;
	}

	public function getPayload(): array
	{
		return $this->payload;
	}

	/**
	 * @throws JwtException
	 */
	private function loadJwt(string $header, string $payload)
	{
		$header = json_decode($header);
		$payload = json_decode($payload);

		if (!$payload) {
			throw new JwtException('payload', 'null');
		}

		if (!$header) {
			throw new JwtException('header', 'null');
		}

		if (!property_exists($header, 'typ')) {
			throw new JwtException('token type', 'null');
		}

		if (!property_exists($header, 'alg')) {
			throw new JwtException('algorithm', 'null');
		}

		if (property_exists($payload, 'exp')) {
			if (!preg_match('#[0-9]#', (string) $payload->exp)) {
				throw new JwtException('expiration', (string) $payload->exp);
			}
			$this->expiration = (int)$payload->exp;
		}

		if (property_exists($payload, 'iat')) {
			if (!preg_match('#[0-9]#', (string) $payload->iat)) {
				throw new JwtException('issued at', (string) $payload->iat);
			}
			$this->issuedAt = (int)$payload->iat;
		}

		$this->type = $header->typ;
		$this->algorithm = $header->alg;
		$this->payload = (array) $payload;
	}
}
