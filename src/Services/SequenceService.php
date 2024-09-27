<?php declare(strict_types=1);

namespace App\Services;

class SequenceService
{
    public function arithmetic(int|float $start, int|float $increment, int $size): array
    {
        if ($size <= 0) {
            return [];
        }

        return range(start: $start, end: $start + $increment * ($size - 1), step: $increment);
    }

    public function geometric(int|float $start, int|float $ratio, int $size): array
    {
        $current = $start;
        $sequence = [];

        for ($i = 0; $i < $size; $i++) {
            $sequence[] = $current;
            $current *= $ratio;
        }

        return $sequence;
    }

    public function fibonacci(int $size): array
    {
        $sequence = [];

        for ($i = 0; $i < $size; $i++) {
            $sequence[] = match ($i) {
                0 => 0,
                1 => 1,
                default => $sequence[$i - 1] + $sequence[$i - 2],
            };
        }

        return $sequence;
    }
}
