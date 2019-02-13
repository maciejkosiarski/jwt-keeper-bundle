<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Exception;

class InvalidJwtContentException extends \Exception
{
	private $content;

	public function __construct(string $serviceUrl, string $content)
	{
		$this->content = $content;

		parent::__construct(sprintf('Service %s return invalid jwt content', $serviceUrl));
	}

	public function getContent(): string
	{
		return $this->content;
	}
}