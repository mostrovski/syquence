<?php declare(strict_types=1);

namespace App\Tests\Feature\Sequence;

use App\Tests\Feature\TestCase;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class ArithmeticTest extends TestCase
{
    protected string $resourceUri = '/api/sequences/arithmetic';

    /**
     * @throws TransportExceptionInterface
     * @throws \JsonException
     */
    public function testItExpectsParams(): void
    {
        $this->authorizedRequest('POST', $this->resourceUri);

        self::assertResponseIsUnprocessable();
        self::assertJsonEquals([
            'error' => [
                'start' => 'This value should not be null.',
                'increment' => 'This value should not be null.',
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
        $this->authorizedRequest('POST', $this->resourceUri, ['json' => [
            'start' => 1,
            'increment' => 1,
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
    public function testItExpectsStartToBeIntegerOrFloat(): void
    {
        $this->authorizedRequest('POST', $this->resourceUri, ['json' => [
            'start' => '1',
            'increment' => 1,
            'size' => 5,
        ]]);

        self::assertResponseIsUnprocessable();
        self::assertJsonEquals([
            'error' => [
                'start' => 'This value should be of type int|float.',
            ],
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \JsonException
     */
    public function testItExpectsIncrementToBeIntegerOrFloat(): void
    {
        $this->authorizedRequest('POST', $this->resourceUri, ['json' => [
            'start' => 1,
            'increment' => '1',
            'size' => 5,
        ]]);

        self::assertResponseIsUnprocessable();
        self::assertJsonEquals([
            'error' => [
                'increment' => 'This value should be of type int|float.',
            ],
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \JsonException
     */
    public function testSuccessfulResponse(): void
    {
        $this->authorizedRequest('POST', $this->resourceUri, ['json' => [
            'start' => 2,
            'increment' => -0.25,
            'size' => 5,
        ]]);

        self::assertResponseIsSuccessful();
        self::assertJsonEquals(['data' => [2, 1.75, 1.5, 1.25, 1]]);
    }
}
