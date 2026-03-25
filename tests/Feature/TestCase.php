<?php declare(strict_types=1);

namespace App\Tests\Feature;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\HttpClient\ResponseInterface;

use function Symfony\Component\String\u;

abstract class TestCase extends ApiTestCase
{
    protected Client $http;
    protected string $token = '';

    /**
     * @throws \Throwable
     */
    protected function setUp(): void
    {
        static::$alwaysBootKernel = true;
        $this->http = static::createClient();

        if (empty($this->token)) {
            $this->token = $this->retrieveToken();
        }
    }

    /**
     * @throws \Throwable
     */
    protected function retrieveToken(): string
    {
        $response = $this->http->request('POST', '/api/auth', ['json' => [
            'username' => 'chuck',
            'password' => 'norris',
        ]]);

        return (string) ($response->toArray()['token'] ?? null);
    }

    /**
     * @param array<string, mixed> $options
     *
     * @throws \Throwable
     */
    protected function authorizedRequest(string $method, string $url, array $options = []): ResponseInterface
    {
        $withToken = array_merge($options, ['auth_bearer' => $this->token]);

        return $this->http->request($method, $url, $withToken);
    }

    protected function getSchema(string $fileName): string
    {
        return (new Filesystem())->readFile(
            u($fileName)
                ->trimPrefix('/')
                ->trimPrefix('documentation/models')
                ->prepend('documentation/models/')
                ->toString()
        );
    }
}
