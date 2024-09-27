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

    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(string $id, Request $request, SequenceGenerator $generate): JsonResponse
    {
        try {
            $sequence = Sequence::from($id);
        } catch (Throwable) {
            return $this->json(
                ['error' => 'Sequence not found.'],
                status: Response::HTTP_NOT_FOUND,
            );
        }

        $errors = $this->validator->validate($sequence->mapData($request));

        if (count($errors) > 0) {
            return $this->json(
                ['error' => $this->transformErrors($errors)],
                status: Response::HTTP_PRECONDITION_FAILED,
            );
        }

        return $this->json([
            'data' => match ($sequence) {
                Sequence::Arithmetic => $generate->arithmetic(
                    (float) $request->get('start'),
                    (float) $request->get('increment'),
                    (int) $request->get('size'),
                ),
                Sequence::Geometric => $generate->geometric(
                    (float) $request->get('start'),
                    (float) $request->get('ratio'),
                    (int) $request->get('size'),
                ),
                Sequence::Fibonacci => $generate->fibonacci((int) $request->get('size')),
            },
        ]);
    }
}
