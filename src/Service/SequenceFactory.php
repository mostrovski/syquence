<?php declare(strict_types=1);

namespace App\Service;

use App\Dto\SequenceParametersDto;
use App\Entity\ArithmeticSequence;
use App\Entity\FibonacciSequence;
use App\Entity\GeometricSequence;
use App\Entity\Sequence;
use App\Enum\SequenceType;

class SequenceFactory
{
    public function create(SequenceType $type, SequenceParametersDto $parameters): Sequence
    {
        return match ($type) {
            SequenceType::ARITHMETIC => (new ArithmeticSequence())
                ->setStart($parameters->getStart())
                ->setIncrement($parameters->getIncrement())
                ->setSize($parameters->getSize()),
            SequenceType::GEOMETRIC => (new GeometricSequence())
                ->setStart($parameters->getStart())
                ->setRatio($parameters->getRatio())
                ->setSize($parameters->getSize()),
            SequenceType::FIBONACCI => (new FibonacciSequence())
                ->setSize($parameters->getSize()),
        };
    }
}
