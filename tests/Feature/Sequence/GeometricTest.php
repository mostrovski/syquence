<?php declare(strict_types=1);

namespace App\Tests\Feature\Sequence;

use App\Tests\Feature\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group geometric-sequence
 */
final class GeometricTest extends TestCase
{
    protected string $resourceUri = '/api/sequences/geometric';

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
                'ratio' => 'This value should not be null.',
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
            'ratio' => null,
            'size' => null,
        ]]);

        self::assertResponseIsUnprocessable();
        self::assertJsonEquals([
            'error' => [
                'start' => 'This value should not be null.',
                'ratio' => 'This value should not be null.',
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
            'ratio' => 1,
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
            'ratio' => 1,
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
    public function testItExpectsRatioToBeIntegerOrFloat(): void
    {
        $this->authorizedRequest('POST', $this->resourceUri, ['json' => [
            'start' => 1,
            'ratio' => '1',
            'size' => 5,
        ]]);

        self::assertResponseIsUnprocessable();
        self::assertJsonEquals([
            'error' => [
                'ratio' => 'This value should be of type int|float.',
            ],
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function testSuccessfulResponse(): void
    {
        $this->authorizedRequest('POST', $this->resourceUri, ['json' => [
            'start' => 10,
            'ratio' => -0.5,
            'size' => 5,
        ]]);

        self::assertResponseIsSuccessful();
        self::assertMatchesJsonSchema($this->getSchema('geometric.json'));
        self::assertJsonEquals(['data' => [10, -5, 2.5, -1.25, 0.625]]);
    }
}
