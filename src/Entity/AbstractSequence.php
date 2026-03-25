<?php declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

abstract class AbstractSequence implements Sequence
{
    #[NotNull]
    #[Type('int')]
    protected mixed $size = null;

    public function getSize(): mixed
    {
        return $this->size;
    }

    public function setSize(mixed $value): static
    {
        $this->size = $value;

        return $this;
    }

    /**
     * @return array<int, int|float>
     */
    abstract public function generate(): array;
}
