<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Service;

use MaciejKosiarski\JwtKeeperBundle\Exception\JwtException;
use MaciejKosiarski\JwtKeeperBundle\Exception\ScanResponseException;

class JwtFinder
{
    /**
     * @throws ScanResponseException
     */
    public function findJwt(array $response): Jwt
    {
        return $this->scanResponse($response);
    }

    /**
     * @throws ScanResponseException
     */
    private function scanResponse(array $response): Jwt
    {
        foreach ($response as $element) {
            if (is_array($element)) {
                try {
                    if ($jwt = $this->scanResponse($element)) {
                        return $jwt;
                    }
                } catch (ScanResponseException $e) {}
            }

            if (is_string($element)) {
                if ($jwt = $this->validJwt($element)) {
                    return $jwt;
                }
            }
        }

        throw new ScanResponseException();
    }

    private function validJwt(string $jwt): ?Jwt
    {
        try {
            $parts = explode('.', $jwt);
            if (count($parts) > 1) {
                return new Jwt($jwt, base64_decode($parts[0]), base64_decode($parts[1]));
            }
            return null;
        } catch (JwtException $e) {
            return null;
        }
    }
}
