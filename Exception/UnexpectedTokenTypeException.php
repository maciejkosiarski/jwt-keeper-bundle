<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Exception;

class UnexpectedTokenTypeException extends \Exception
{
	public function __construct($value, string $expectedType)
	{
	    $msg = sprintf('Expected token of type %s, %s given',
            $expectedType, \is_object($value) ? \get_class($value) : \gettype($value));

		parent::__construct($msg);
	}
}
