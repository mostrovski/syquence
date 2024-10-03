<?php declare(strict_types=1);

namespace App\Tests\Feature\Sequence;

use App\Tests\Feature\TestCase;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class IndexTest extends TestCase
{
    protected string $resourceUri = '/api/sequences';

    /**
     * @throws TransportExceptionInterface
     * @throws \JsonException
     */
    public function testSuccessfulResponse(): void
    {
        $this->authorizedRequest('GET', $this->resourceUri);

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
