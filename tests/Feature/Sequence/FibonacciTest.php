<?php declare(strict_types=1);

namespace App\Tests\Feature\Sequence;

use App\Tests\Feature\TestCase;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class FibonacciTest extends TestCase
{
    protected string $resourceUri = '/api/sequences/fibonacci';

    /**
     * @throws TransportExceptionInterface
     * @throws \JsonException
     */
    public function testItExpectsParams(): void
    {
        $this->http->request('POST', $this->resourceUri);

        self::assertResponseIsUnprocessable();
        self::assertJsonEquals([
            'error' => [
                'size' => 'This value should not be null.',
            ],
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \JsonException
     */
    public function testItExpectsSizeToBeInteger(): void
    {
        $this->http->request('POST', $this->resourceUri, ['json' => [
            'size' => '5',
        ]]);

        self::assertResponseIsUnprocessable();
        self::assertJsonEquals([
            'error' => [
                'size' => 'This value should be of type int.',
            ],
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \JsonException
     */
    public function testSuccessfulResponse(): void
    {
        $this->http->request('POST', $this->resourceUri, ['json' => [
            'size' => 15,
        ]]);

        self::assertResponseIsSuccessful();
        self::assertJsonEquals(['data' => [
            0, 1, 1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144, 233, 377,
        ]]);
    }
}
