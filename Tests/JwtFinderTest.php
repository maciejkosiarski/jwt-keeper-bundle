<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\Tests;

require_once __DIR__ . '/../vendor/autoload.php';

use MaciejKosiarski\JwtKeeperBundle\Service\Jwt;
use MaciejKosiarski\JwtKeeperBundle\Service\JwtFinder;
use PHPUnit\Framework\TestCase;

class JwtFinderTest extends TestCase
{
    /**
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\ScanResponseException
     */
    public function testHS256()
    {
        $hs256 = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c';

        $payload = [
            'sub' => '1234567890',
            'name' => 'John Doe',
            'iat' => 1516239022,
        ];

        $finder = new JwtFinder();
        $jwt = $finder->findJwt($this->getResponse($hs256));
        $this->assertInstanceOf(Jwt::class, $jwt);
        $this->assertEquals($hs256, $jwt->getToken());
        $this->assertEquals('HS256', $jwt->getAlgorithm());
        $this->assertEquals($payload, $jwt->getPayload());
    }

    /**
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\ScanResponseException
     */
    public function testHS384()
    {
        $hs384 = 'eyJhbGciOiJIUzM4NCIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.bQTnz6AuMJvmXXQsVPrxeQNvzDkimo7VNXxHeSBfClLufmCVZRUuyTwJF311JHuh';

        $payload = [
            'sub' => '1234567890',
            'name' => 'John Doe',
            'admin' => true,
            'iat' => 1516239022,
        ];

        $finder = new JwtFinder();
        $jwt = $finder->findJwt($this->getResponse($hs384));

        $this->assertInstanceOf(Jwt::class, $jwt);
        $this->assertEquals($hs384, $jwt->getToken());
        $this->assertEquals('HS384', $jwt->getAlgorithm());
        $this->assertEquals($payload, $jwt->getPayload());
    }

    /**
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\ScanResponseException
     */
    public function testRS256()
    {
        $rs256 = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.POstGetfAytaZS82wHcjoTyoqhMyxXiWdR7Nn7A29DNSl0EiXLdwJ6xC6AfgZWF1bOsS_TuYI3OG85AmiExREkrS6tDfTQ2B3WXlrr-wp5AokiRbz3_oB4OxG-W9KcEEbDRcZc0nH3L7LzYptiy1PtAylQGxHTWZXtGz4ht0bAecBgmpdgXMguEIcoqPJ1n3pIWk_dUZegpqx0Lka21H6XxUTxiy8OcaarA8zdnPUnV6AmNP3ecFawIFYdvJB_cm-GvpCSbr8G8y_Mllj8f4x9nBH8pQux89_6gUY618iYv7tuPWBFfEbLxtF2pZS6YC1aSfLQxeNe8djT9YjpvRZA';

        $payload = [
            'sub' => '1234567890',
            'name' => 'John Doe',
            'admin' => true,
            'iat' => 1516239022,
        ];

        $finder = new JwtFinder();
        $jwt = $finder->findJwt($this->getResponse($rs256));

        $this->assertInstanceOf(Jwt::class, $jwt);
        $this->assertEquals($rs256, $jwt->getToken());
        $this->assertEquals('RS256', $jwt->getAlgorithm());
        $this->assertEquals($payload, $jwt->getPayload());
    }

    /**
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\ScanResponseException
     */
    public function testES256()
    {
        $es256 = 'eyJhbGciOiJFUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.tyh-VfuzIxCyGYDlkBA7DfyjrqmSHu6pQ2hoZuFqUSLPNY2N0mpHb3nk5K17HWP_3cYHBw7AhHale5wky6-sVA';

        $payload = [
            'sub' => '1234567890',
            'name' => 'John Doe',
            'admin' => true,
            'iat' => 1516239022,
        ];

        $finder = new JwtFinder();
        $jwt = $finder->findJwt($this->getResponse($es256));

        $this->assertInstanceOf(Jwt::class, $jwt);
        $this->assertEquals($es256, $jwt->getToken());
        $this->assertEquals('ES256', $jwt->getAlgorithm());
        $this->assertEquals($payload, $jwt->getPayload());
    }

    /**
     * @throws \MaciejKosiarski\JwtKeeperBundle\Exception\ScanResponseException
     */
    public function testPS256()
    {
        $ps256 = 'eyJhbGciOiJQUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.hZnl5amPk_I3tb4O-Otci_5XZdVWhPlFyVRvcqSwnDo_srcysDvhhKOD01DigPK1lJvTSTolyUgKGtpLqMfRDXQlekRsF4XhAjYZTmcynf-C-6wO5EI4wYewLNKFGGJzHAknMgotJFjDi_NCVSjHsW3a10nTao1lB82FRS305T226Q0VqNVJVWhE4G0JQvi2TssRtCxYTqzXVt22iDKkXeZJARZ1paXHGV5Kd1CljcZtkNZYIGcwnj65gvuCwohbkIxAnhZMJXCLaVvHqv9l-AAUV7esZvkQR1IpwBAiDQJh4qxPjFGylyXrHMqh5NlT_pWL2ZoULWTg_TJjMO9TuQ';

        $payload = [
            'sub' => '1234567890',
            'name' => 'John Doe',
            'admin' => true,
            'iat' => 1516239022,
        ];

        $finder = new JwtFinder();
        $jwt = $finder->findJwt($this->getResponse($ps256));

        $this->assertInstanceOf(Jwt::class, $jwt);
        $this->assertEquals($ps256, $jwt->getToken());
        $this->assertEquals('PS256', $jwt->getAlgorithm());
        $this->assertEquals($payload, $jwt->getPayload());
    }


    private function getResponse(string $token): array
    {
        return [
            'status' => 'success',
            'content' => [
                'date' => '2015-03-14',
                'token' => $token,
            ],
        ];
    }
}
