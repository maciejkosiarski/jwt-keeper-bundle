<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Service;

use MaciejKosiarski\JwtKeeperBundle\Exception\StorageFileNameException;
use MaciejKosiarski\JwtKeeperBundle\Exception\StoreTokenException;
use MaciejKosiarski\JwtKeeperBundle\Exception\UnexpectedTokenTypeException;

class JwtStorage
{
	const STORAGE_DIR = 'var/jwt';

	private $fileNameHash;

	/**
	 * @throws StorageFileNameException
	 */
	public function __construct(string $fileNameHash)
	{
		if (!strlen($fileNameHash) === 32) {
			throw new StorageFileNameException();
		}

		$this->fileNameHash = $fileNameHash . '.txt';

		if (!is_dir(self::STORAGE_DIR)) {
			mkdir(self::STORAGE_DIR, 0777, true);
		}
	}

	/**
	 * @throws StoreTokenException
	 */
	public function storeToken(string $token): void
	{
		if (!file_put_contents($this->getPath(), $token)) {
			throw new StoreTokenException($this->getPath());
		}
	}

	/**
	 * @throws UnexpectedTokenTypeException
	 */
	public function getToken(): ?string
	{
		if (!is_file($this->getPath())) {
			return null;
		}

		$token = file_get_contents($this->getPath());

		if (is_string($token)) {
			return $token;
		}

		throw new UnexpectedTokenTypeException($token, 'string');
	}

	private function getPath(): string
	{
		return sprintf('%s/%s', self::STORAGE_DIR, $this->fileNameHash);
	}
}