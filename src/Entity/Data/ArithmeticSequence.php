<?php declare(strict_types=1);

namespace App\Entity\Data;

use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

class ArithmeticSequence extends AbstractSequence
{
    #[NotNull]
    #[Type(['int', 'float'])]
    protected mixed $start;

    #[NotNull]
    #[Type(['int', 'float'])]
    protected mixed $increment;

    /**
     * @return array<int, int|float>
     */
    public function generate(): array
    {
        $size = (int) $this->getSize();

        if ($size <= 0) {
            return [];
        }

        $start = (float) $this->getStart();
        $increment = (float) $this->getIncrement();

        return range(start: $start, end: $start + $increment * ($size - 1), step: $increment);
    }

    public function getStart(): mixed
    {
        return $this->start;
    }

    public function setStart(mixed $value): static
    {
        $this->start = $value;

        return $this;
    }

    public function getIncrement(): mixed
    {
        return $this->increment;
    }

    public function setIncrement(mixed $value): static
    {
        $this->increment = $value;

        return $this;
    }
}
