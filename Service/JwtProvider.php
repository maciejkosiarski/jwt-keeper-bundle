<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Service;

use GuzzleHttp\Client;

class JwtProvider
{
	//private $jwtPath;
	private $username;
	private $password;
	private $jwtStorage;
	private $httpClient;

	/**
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\StorageFileNameException
	 */
	public function __construct(string $jwtPath, string $username, string $password)
	{
		//$this->jwtPath = $jwtPath;
		$this->username = $username;
		$this->password = $password;
		$this->jwtStorage = new JwtStorage(md5( $jwtPath . $username . $password));
		$this->httpClient = new Client([['base_uri' => $jwtPath]]);
	}

	/**
	 * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\UnexpectedTokenTypeException
	 */
	public function provideJwt(): string
	{
		if (!$this->jwtIsValid()) {
			$this->refreshJwt();
		}

		return $this->jwtStorage->getToken();
	}

	//TODO to refactore
	private function jwtIsValid(): bool
	{
		if (!$token = $this->jwtStorage->getToken()) {
			return false;
		}

		$jwt = $this->parseJwt($token);

		if (!$jwt->getPayload()) {
			return false;
		}

		$info = json_decode($jwt->getPayload()['tokenInfo'], true);

		return !((new \DateTime())->format('U') > $info['exp'] - 300);
	}

	/**
	 * @throws \Exception
	 */
	private function refreshJwt(): void
	{
		$options = [
			'headers' => [
				'Content-Type' => 'application/json',
			],
			'body' => [
				'username'=> $this->username,
				'password' => $this->password,
			],
		];

		$response = $this->httpClient->request('POST', 'jwt', $options);

//		$content = json_encode(['username'=> $this->username, 'password' => $this->password,]);
//
//		$request = curl_init();
//
//		curl_setopt($request, CURLOPT_URL, $this->jwtPath);
//		curl_setopt($request, CURLOPT_POST, true);
//		curl_setopt($request, CURLOPT_POSTFIELDS, $content);
//		curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
//		curl_setopt($request, CURLOPT_HTTPHEADER, [
//				'Content-Type: application/json',
//				'Content-Length: ' . strlen($content)
//			]
//		);
//
//		$result = json_decode(curl_exec($request), true);

		if ($response->getStatusCode() !== 200) {
			$this->storeJwt($response->getBody()->getContents());
		}

		throw new \Exception('Error with connection. Check jwt site availability', 500);
	}

	private function storeJwt(string $jwt): void
	{
		$this->jwtStorage->storeToken($jwt);
	}

	private function parseJwt(string $token): Jwt
	{
		$parts = explode('.', $token);

		return new Jwt($token, base64_decode($parts[0]), base64_decode($parts[1]));
	}
}