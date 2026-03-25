<?php declare(strict_types=1);

namespace App\Entity;

interface Sequence
{
    /**
     * @return array<int, int|float>
     */
    public function generate(): array;
}
