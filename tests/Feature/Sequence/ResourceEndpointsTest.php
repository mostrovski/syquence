<?php declare(strict_types=1);

namespace App\Tests\Feature\Sequence;

use App\Entity\Enumeration\Sequence;
use App\Tests\Feature\TestCase;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class ResourceEndpointsTest extends TestCase
{
    protected string $resourceUri = '/api/sequences';

    /**
     * @throws TransportExceptionInterface
     */
    public function testIndexExists(): void
    {
        $this->http->request('GET', $this->resourceUri);

        self::assertResponseIsSuccessful();
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function testGenerateEndpointExistsForKnownSequences(): void
    {
        foreach (Sequence::cases() as $sequence) {
            $response = $this->http->request('POST', $this->resourceUri.'/'.$sequence->getId());

            self::assertNotEquals(404, $response->getStatusCode());
        }
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \JsonException
     */
    public function testItReturnsNotFondForUnknownSequences(): void
    {
        $this->http->request('POST', $this->resourceUri.'/unknown-sequence-type');

        self::assertResponseStatusCodeSame(404);
        self::assertJsonEquals(['error' => 'Sequence not found.']);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function testBadRequests(): void
    {
        foreach (Sequence::cases() as $sequence) {
            $this->http->request(
                'POST',
                $this->resourceUri.'/'.$sequence->getId(),
                ['json' => ['size' => [15]],
                ]);

            self::assertResponseStatusCodeSame(400);
        }
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function testWrongMethodRequests(): void
    {
        foreach (['POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'] as $method) {
            $this->http->request($method, $this->resourceUri);

            self::assertResponseStatusCodeSame(405);
        }

        foreach (Sequence::cases() as $sequence) {
            foreach (['GET', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'] as $method) {
                $this->http->request($method, $this->resourceUri.'/'.$sequence->getId());

                self::assertResponseStatusCodeSame(405);
            }
        }
    }
}
