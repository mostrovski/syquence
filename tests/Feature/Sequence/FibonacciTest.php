<?php declare(strict_types=1);

namespace App\Tests\Feature\Sequence;

use App\Tests\Feature\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group fibonacci-sequence
 */
final class FibonacciTest extends TestCase
{
    protected string $resourceUri = '/api/sequences/fibonacci';

    /**
     * @throws \Throwable
     */
    public function testItExpectsParams(): void
    {
        $this->authorizedRequest('POST', $this->resourceUri);

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        self::assertJsonEquals(['error' => 'Invalid parameters.']);
    }

    /**
     * @throws \Throwable
     */
    public function testItRejectsNullableParams(): void
    {
        $this->authorizedRequest('POST', $this->resourceUri, ['json' => []]);

        self::assertResponseIsUnprocessable();
        self::assertJsonEquals([
            'error' => [
                'size' => 'This value should not be null.',
            ],
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function testItRejectsNullParams(): void
    {
        $this->authorizedRequest('POST', $this->resourceUri, ['json' => [
            'size' => null,
        ]]);

        self::assertResponseIsUnprocessable();
        self::assertJsonEquals([
            'error' => [
                'size' => 'This value should not be null.',
            ],
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function testItExpectsSizeToBeInteger(): void
    {
        $this->authorizedRequest('POST', $this->resourceUri, ['json' => [
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
     * @throws \Throwable
     */
    public function testSuccessfulResponse(): void
    {
        $this->authorizedRequest('POST', $this->resourceUri, ['json' => [
            'size' => 15,
        ]]);

        self::assertResponseIsSuccessful();
        self::assertMatchesJsonSchema($this->getSchema('fibonacci.json'));
        self::assertJsonEquals(['data' => [
            0, 1, 1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144, 233, 377,
        ]]);
    }
}
