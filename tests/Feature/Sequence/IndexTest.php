<?php declare(strict_types=1);

namespace App\Tests\Feature\Sequence;

use App\Tests\Feature\TestCase;

final class IndexTest extends TestCase
{
    protected string $resourceUri = '/api/sequences';

    /**
     * @throws \Throwable
     */
    public function testSuccessfulResponse(): void
    {
        $this->authorizedRequest('GET', $this->resourceUri);

        self::assertMatchesJsonSchema($this->getSchema('sequences.json'));

        self::assertJsonEquals([
            'data' => [
                'arithmetic' => [
                    'id' => 'arithmetic',
                    'title' => 'Arithmetic progression',
                ],
                'geometric' => [
                    'id' => 'geometric',
                    'title' => 'Geometric progression',
                ],
                'fibonacci' => [
                    'id' => 'fibonacci',
                    'title' => 'Fibonacci sequence',
                ],
            ],
        ]);
    }
}
