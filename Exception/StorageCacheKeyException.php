<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Exception;

class StorageCacheKeyException extends \Exception
{
	public function __construct(string $key)
	{
	    $msg = sprintf('Cache key to keep jwt was invalid [%s]. The preferred name should be md5 hash.', $key);
		parent::__construct($msg, 409);
	}
}
