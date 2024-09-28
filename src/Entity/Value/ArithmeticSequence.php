<?php declare(strict_types = 1);

namespace App\Entity\Value;

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
