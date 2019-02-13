<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Exception;

class JwtException extends \Exception
{
	public function __construct(string $element, string $value)
	{
		parent::__construct(sprintf('Json web token get invalid %s value: %s', $element, $value));
	}
}