<?php declare(strict_types=1);

namespace App\Controller;

use App\Dto\SequenceParametersDto;
use App\Enum\SequenceType;
use App\Service\SequenceFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/sequences', name: 'api_sequences_')]
class SequenceController extends AbstractApiController
{
    #[Route(name: 'index', methods: 'GET')]
    public function index(): JsonResponse
    {
        $data = [];

        foreach (SequenceType::cases() as $sequence) {
            $id = $sequence->getId();
            $data[$id] = [
                'id' => $id,
                'title' => $sequence->getTitle(),
            ];
        }

        return $this->json(['data' => $data]);
    }

    #[Route('/{id}', name: 'generate', methods: 'POST')]
    public function generate(
        string $id,
        Request $request,
        SerializerInterface $serializer,
        SequenceFactory $factory,
    ): JsonResponse {
        try {
            $sequenceType = SequenceType::from($id);
        } catch (\Throwable) {
            return $this->json(
                ['error' => 'Sequence not found.'],
                status: Response::HTTP_NOT_FOUND,
            );
        }

        try {
            $parameters = $serializer->deserialize($request->getContent(), SequenceParametersDto::class, 'json');
        } catch (\Throwable) {
            return $this->json(
                ['error' => 'Invalid parameters.'],
                status: Response::HTTP_BAD_REQUEST,
            );
        }

        $sequence = $factory->create($sequenceType, $parameters);
        $errors = $this->validator->validate($sequence);

        if (count($errors) > 0) {
            return $this->json(
                ['error' => $this->transformErrors($errors)],
                status: Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        }

        return $this->json(['data' => $sequence->generate()]);
    }
}
