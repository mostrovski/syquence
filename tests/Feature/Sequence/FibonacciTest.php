<?php declare(strict_types=1);

namespace App\Tests\Feature\Sequence;

use App\Tests\Feature\TestCase;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class FibonacciTest extends TestCase
{
    protected string $resourceUri = '/api/sequences/fibonacci';

    /**
     * @throws TransportExceptionInterface
     * @throws \JsonException
     */
    public function test_it_expects_params(): void
    {
        $this->http->request('POST', $this->resourceUri);

        self::assertResponseIsUnprocessable();
        self::assertJsonEquals([
            'error'=> [
                'size' => 'This value should not be null.',
            ],
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \JsonException
     */
    public function test_it_expects_size_to_be_integer(): void
    {
        $this->http->request('POST', $this->resourceUri, ['json' => [
            'size' => '5',
        ]]);

        self::assertResponseIsUnprocessable();
        self::assertJsonEquals([
            'error'=> [
                'size' => 'This value should be of type int.',
            ],
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \JsonException
     */
    public function test_successful_response(): void
    {
        $this->http->request('POST', $this->resourceUri, ['json' => [
            'size' => 15,
        ]]);

        self::assertResponseIsSuccessful();
        self::assertJsonEquals(['data'=> [
            0, 1, 1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144, 233, 377
        ]]);
    }
}
