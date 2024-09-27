<?php declare(strict_types = 1);

namespace App\Entity\Value;

use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

abstract class AbstractSequence
{
    #[Type('digit', message: 'The size should be a positive integer.')]
    #[NotNull]
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
}
