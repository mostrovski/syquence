<?php declare(strict_types=1);

namespace App\Tests\Feature;

final class AuthTest extends TestCase
{
    protected string $resourceUri = '/api/auth';

    /**
     * @throws \Throwable
     */
    public function testBadRequests(): void
    {
        $requestBodies = [
            [],
            ['username' => 1],
            ['username' => null],
            ['password' => 2],
            ['password' => null],
            ['username' => 1, 'password' => 2],
            ['username' => null, 'password' => null],
            ['username' => 'some-username', 'password' => 2],
            ['username' => null, 'password' => 'some-password'],
        ];

        foreach ($requestBodies as $requestBody) {
            $this->http->request('POST', $this->resourceUri, ['json' => $requestBody]);

            self::assertResponseStatusCodeSame(400);
        }
    }

    /**
     * @throws \Throwable
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
     * @throws \Throwable
     */
    public function testWrongMethodRequests(): void
    {
        foreach (['GET', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'] as $method) {
            $this->authorizedRequest($method, $this->resourceUri);

            self::assertResponseStatusCodeSame(405);
        }
    }

    /**
     * @throws \Throwable
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
