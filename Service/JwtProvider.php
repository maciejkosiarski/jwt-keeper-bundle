<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use MaciejKosiarski\JwtKeeperBundle\Exception\InvalidJwtContentException;
use MaciejKosiarski\JwtKeeperBundle\Exception\RetrieveTokenException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class JwtProvider
{
	private $username;
	private $password;
	private $jwtStorage;
	private $request;

	/**
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\StorageCacheKeyException
	 */
	public function __construct(string $authUrl, string $username, string $password)
	{
		$this->username = $username;
		$this->password = $password;
		$this->jwtStorage = new JwtStorage(md5( $authUrl . $username . $password));
		$this->request = new Request('POST', $authUrl);
	}

    /**
     * @throws InvalidJwtContentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\JwtException
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\RetrieveTokenException
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\StoreTokenException
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\UnexpectedTokenTypeException
     */
	public function provideJwt(): Jwt
	{
		if (!$this->jwtIsValid()) {
			$this->refreshJwt();
		}

		return $this->getJwt($this->jwtStorage->getToken());
	}

    /**
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\JwtException
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\UnexpectedTokenTypeException
     */
	private function jwtIsValid(): bool
	{
	    try {
            $token = $this->jwtStorage->getToken();
            $jwt = $this->getJwt($token);

            if (!$jwt->getExpiration()) {
                return false;
            }

            $currentDate = new \DateTime();

            return !((int) $currentDate->format('U') > $jwt->getExpiration());
        } catch (RetrieveTokenException $e) {
            return false;
        }
	}

	/**
	 * @throws InvalidJwtContentException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\StoreTokenException
	 */
	private function refreshJwt(): void
	{
		$response = (new Client())->send($this->request, $this->getRequestOptions());

		if ($response->getStatusCode() !== 200) {
			$message = sprintf('Error with service %s API connection. Check jwt auth site.', $this->getJwtRoute());
			throw new HttpException($response->getStatusCode(), $message);
		}

		$content = json_decode($response->getBody()->getContents());

		if (!property_exists($content, 'token')) {
			throw new InvalidJwtContentException($this->getJwtRoute(), $response->getBody()->getContents());
		}

		$this->storeJwt($content->token);
	}

	/**
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\StoreTokenException
	 */
	private function storeJwt(string $jwt): void
	{
		$this->jwtStorage->storeToken($jwt);
	}

	/**
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\JwtException
	 */
	private function getJwt(string $token): Jwt
	{
		$parts = explode('.', $token);

		return new Jwt($token, base64_decode($parts[0]), base64_decode($parts[1]));
	}

	private function getRequestOptions(): array
	{
		return [
			'headers' => [
				'Cache-Control' => 'no-cache',
				'Content-Type' => 'application/json',
			],
			'json' => [
				'username'=> $this->username,
				'password' => $this->password,
			],
		];
	}

	private function getJwtRoute(): string
	{
		return $this->request->getUri()->getHost() . $this->request->getUri()->getPath();
	}
}
