<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Exception;

class StorageFileNameException extends \Exception
{
	public function __construct()
	{
		parent::__construct('File name to keep jwt is invalid. The preferred name should be md5 hash.', 409);
	}
}