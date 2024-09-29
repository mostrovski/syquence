<?php declare(strict_types=1);

namespace App\Entity\Data;

class FibonacciSequence extends AbstractSequence
{
    /**
     * @return array<int, int>
     */
    public function generate(): array
    {
        $sequence = [];
        $size = (int) $this->getSize();

        for ($i = 0; $i < $size; ++$i) {
            $sequence[] = match ($i) {
                0 => 0,
                1 => 1,
                default => $sequence[$i - 1] + $sequence[$i - 2],
            };
        }

        return $sequence;
    }
}
