<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Enumeration\Sequence;
use App\Service\SequenceGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

#[Route('api/sequences', name: 'api_sequences_')]
class SequenceController extends AbstractApiController
{
    #[Route(name: 'index', methods: 'GET')]
    public function index(): JsonResponse
    {
        $data = [];

        foreach (Sequence::cases() as $sequence) {
            $data[$sequence->value] = [
                'id' => $sequence->getId(),
                'title' => $sequence->getTitle(),
            ];
        }

        return $this->json(['data' => $data]);
    }

    #[Route('/{id}', name: 'show', methods: 'POST')]
    public function generate(string $id, Request $request, SequenceGenerator $generate): JsonResponse
    {
        try {
            $sequence = Sequence::from($id);
        } catch (Throwable) {
            return $this->json(
                ['error' => 'Sequence not found.'],
                status: Response::HTTP_NOT_FOUND,
            );
        }

        $payload = $request->getPayload();
        $errors = $this->validator->validate($sequence->mapData($payload));

        if (count($errors) > 0) {
            return $this->json(
                ['error' => $this->transformErrors($errors)],
                status: Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        }

        return $this->json([
            'data' => match ($sequence) {
                Sequence::Arithmetic => $generate->arithmetic(
                    (float) $payload->get('start'),
                    (float) $payload->get('increment'),
                    (int) $payload->get('size'),
                ),
                Sequence::Geometric => $generate->geometric(
                    (float) $payload->get('start'),
                    (float) $payload->get('ratio'),
                    (int) $payload->get('size'),
                ),
                Sequence::Fibonacci => $generate->fibonacci((int) $payload->get('size')),
            },
        ]);
    }
}
