<?php declare(strict_types=1);

namespace App\Tests\Feature;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class TestCase extends ApiTestCase
{
    protected Client $http;
    protected string $token = '';

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function setUp(): void
    {
        $this->http = static::createClient();

        if (empty($this->token)) {
            $this->token = $this->retrieveToken();
        }
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function retrieveToken(): string
    {
        $response = $this->http->request('POST', '/auth', ['json' => [
            'username' => 'chuck',
            'password' => 'norris',
        ]]);

        return (string) ($response->toArray()['token'] ?? null);
    }

    /**
     * @param array<string, mixed> $options
     *
     * @throws TransportExceptionInterface
     */
    protected function authorizedRequest(string $method, string $url, array $options = []): ResponseInterface
    {
        $withToken = array_merge($options, ['auth_bearer' => $this->token]);

        return $this->http->request($method, $url, $withToken);
    }
}
