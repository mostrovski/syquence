<?php declare(strict_types=1);

namespace App\Tests\Feature\Sequence;

use App\Tests\Feature\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group arithmetic-sequence
 */
final class ArithmeticTest extends TestCase
{
    protected string $resourceUri = '/api/sequences/arithmetic';

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
                'start' => 'This value should not be null.',
                'increment' => 'This value should not be null.',
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
            'start' => null,
            'increment' => null,
            'size' => null,
        ]]);

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
     * @throws \Throwable
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
     * @throws \Throwable
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
     * @throws \Throwable
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
     * @throws \Throwable
     */
    public function testSuccessfulResponse(): void
    {
        $this->authorizedRequest('POST', $this->resourceUri, ['json' => [
            'start' => 2,
            'increment' => -0.25,
            'size' => 5,
        ]]);

        self::assertResponseIsSuccessful();
        self::assertMatchesJsonSchema($this->getSchema('arithmetic.json'));
        self::assertJsonEquals(['data' => [2, 1.75, 1.5, 1.25, 1]]);
    }
}
