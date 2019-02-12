<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Exception;

class StoreTokenException extends \Exception
{
	public function __construct(string $path)
	{
		parent::__construct(sprintf('Cant store json web token in %s file', $path), 412);
	}
}