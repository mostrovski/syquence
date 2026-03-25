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
