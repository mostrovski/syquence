<?php declare(strict_types=1);

namespace App\Tests\Feature;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class AuthTest extends TestCase
{
    protected string $resourceUri = '/api/auth';

    /**
     * @throws TransportExceptionInterface
     */
    public function testBadRequests(): void
    {
        $requestBodies = [
            [],
            ['username' => ''],
            ['username' => 'some-username'],
            ['password' => ''],
            ['password' => 'some-password'],
            ['username' => '', 'password' => ''],
            ['username' => 1, 'password' => 2],
            ['username' => 'some-username', 'password' => ''],
            ['username' => '', 'password' => 'some-password'],
        ];

        foreach ($requestBodies as $requestBody) {
            $this->http->request('POST', $this->resourceUri, ['json' => $requestBody]);

            self::assertResponseStatusCodeSame(400);
        }
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testInvalidCredentials(): void
    {
        $this->http->request('POST', $this->resourceUri, ['json' => [
            'username' => 'some-username',
            'password' => 'some-password',
        ]]);

        self::assertResponseStatusCodeSame(401);
        self::assertJsonContains(['message' => 'Invalid credentials.']);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function testWrongMethodRequests(): void
    {
        foreach (['GET', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'] as $method) {
            $this->authorizedRequest($method, $this->resourceUri);

            self::assertResponseStatusCodeSame(405);
        }
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function testSuccessfulResponse(): void
    {
        $this->http->request('POST', $this->resourceUri, ['json' => [
            'username' => 'chuck',
            'password' => 'norris',
        ]]);

        self::assertResponseIsSuccessful();
        self::assertMatchesJsonSchema($this->getSchema('token.json'));
    }
}
