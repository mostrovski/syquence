<?php declare(strict_types=1);

namespace App\Tests\Feature\Sequence;

use App\Tests\Feature\TestCase;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class GeometricTest extends TestCase
{
    protected string $resourceUri = '/api/sequences/geometric';

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
                'start' => 'This value should not be null.',
                'ratio' => 'This value should not be null.',
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
            'start' => 1,
            'ratio' => 1,
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
    public function test_it_expects_start_to_be_integer_or_float(): void
    {
        $this->http->request('POST', $this->resourceUri, ['json' => [
            'start' => '1',
            'ratio' => 1,
            'size' => 5,
        ]]);

        self::assertResponseIsUnprocessable();
        self::assertJsonEquals([
            'error'=> [
                'start' => 'This value should be of type int|float.',
            ],
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \JsonException
     */
    public function test_it_expects_ratio_to_be_integer_or_float(): void
    {
        $this->http->request('POST', $this->resourceUri, ['json' => [
            'start' => 1,
            'ratio' => '1',
            'size' => 5,
        ]]);

        self::assertResponseIsUnprocessable();
        self::assertJsonEquals([
            'error'=> [
                'ratio' => 'This value should be of type int|float.',
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
            'start' => 10,
            'ratio' => -0.5,
            'size' => 5,
        ]]);

        self::assertResponseIsSuccessful();
        self::assertJsonEquals(['data'=> [10, -5, 2.5, -1.25, 0.625]]);
    }
}
