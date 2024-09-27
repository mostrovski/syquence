<?php

namespace App\Controller;

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
                    'title' => 'Arithmetic',
                ],
                'geometric' => [
                    'id' => 'geometric',
                    'title' => 'Geometric',
                ],
                'fibonacci' => [
                    'id' => 'fibonacci',
                    'title' => 'Fibonacci',
                ],
            ],
        ]);
    }

    #[Route('/api/sequences/{id}', name: 'api_sequence_show', methods: 'GET')]
    public function show(string $id): JsonResponse
    {
        $sequence = match ($id) {
            'arithmetic' => [1, 2, 3, 4, 5],
            'geometric' => [100, 50, 25, 12.5, 6.25],
            'fibonacci' => [0, 1, 1, 2, 3, 5, 8, 13, 21, 34],
            default => null,
        };

        if ($sequence === null) {
            return $this->json(['error' => 'Sequence not found'], 404);
        }

        return $this->json(['data' => $sequence]);
    }
}
