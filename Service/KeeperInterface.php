<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Service;

interface KeeperInterface
{
    public function getJwt(): Jwt;

    public function getToken(): string;
}
