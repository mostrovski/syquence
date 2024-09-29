<?php declare(strict_types=1);

namespace App\Tests\Feature\Sequence;

use App\Entity\Enumeration\Sequence;
use App\Tests\Feature\TestCase;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ResourceEndpointsTest extends TestCase
{
    protected string $resourceUri = '/api/sequences';

    /**
     * @throws TransportExceptionInterface
     */
    public function test_index_exists(): void
    {
        $this->http->request('GET', $this->resourceUri);

        self::assertResponseIsSuccessful();
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function test_generate_endpoint_exists_for_known_sequences(): void
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
    public function test_it_returns_not_fond_for_unknown_sequences(): void
    {
        $this->http->request('POST', $this->resourceUri.'/unknown-sequence-type');

        self::assertResponseStatusCodeSame(404);
        self::assertJsonEquals(['error' => 'Sequence not found.']);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function test_bad_requests(): void
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
    public function test_wrong_method_requests(): void
    {
        foreach (['POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'] as $method) {
            $this->http->request($method, $this->resourceUri);

            self::assertResponseStatusCodeSame(405);
        }

        foreach (Sequence::cases() as $sequence) {
            foreach (['GET', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'] as $method) {
                $this->http->request($method, $this->resourceUri . '/' . $sequence->getId());

                self::assertResponseStatusCodeSame(405);
            }

        }
    }
}
