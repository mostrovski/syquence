<?php declare(strict_types=1);

namespace App\Entity\Data;

use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

class GeometricSequence extends AbstractSequence
{
    #[NotNull]
    #[Type(['int', 'float'])]
    protected mixed $start;

    #[NotNull]
    #[Type(['int', 'float'])]
    protected mixed $ratio;

    /**
     * @return array<int, int|float>
     */
    public function generate(): array
    {
        $size = (int) $this->getSize();

        if ($size <= 0) {
            return [];
        }

        $current = (float) $this->getStart();
        $ratio = (float) $this->getRatio();
        $sequence = [];

        for ($i = 0; $i < $size; ++$i) {
            $sequence[] = $current;
            $current *= $ratio;
        }

        return $sequence;
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
