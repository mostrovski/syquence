<?php declare(strict_types = 1);

namespace App\Entity\Value;

use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

class GeometricSequence extends AbstractSequence
{
    #[NotNull]
    #[Type('numeric')]
    protected mixed $start;

    #[NotNull]
    #[Type('numeric')]
    protected mixed $ratio;

    public function getStart(): mixed
    {
        return $this->start;
    }

    public function setStart(mixed $value): static
    {
        $this->start = $value;

        return $this;
    }

    public function getRatio(): mixed
    {
        return $this->ratio;
    }

    public function setRatio(mixed $value): static
    {
        $this->ratio = $value;

        return $this;
    }
}
