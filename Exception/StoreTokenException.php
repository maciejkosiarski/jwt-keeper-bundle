<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Exception;

class StoreTokenException extends \Exception
{
	public function __construct(string $cacheKey)
	{
		parent::__construct(sprintf('Cant store json web token in %s cache', $cacheKey), 412);
	}
}
