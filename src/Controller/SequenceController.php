<?php declare(strict_types=1);

namespace App\Controller;

use App\Services\SequenceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class SequenceController extends AbstractController
{
    #[Route('/api/sequences', name: 'api_sequence', methods: 'GET')]
    public function index(): JsonResponse
    {
        return $this->json([
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

    #[Route('/api/sequences/{id}', name: 'api_sequence_show', methods: 'GET')]
    public function show(string $id, SequenceService $sequence): JsonResponse
    {
        $result = match ($id) {
            'arithmetic' => $sequence->arithmetic(start: 1, increment: 1, size: 5),
            'geometric' => $sequence->geometric(start: 100, ratio: 0.5, size: 5),
            'fibonacci' => $sequence->fibonacci(size: 10),
            default => null,
        };

        if ($result === null) {
            return $this->json(['error' => 'Sequence not found'], 404);
        }

        return $this->json(['data' => $result]);
    }
}
