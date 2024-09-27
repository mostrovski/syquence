<?php declare(strict_types=1);

namespace App\Entity\Enumeration;

use App\Entity\Value\AbstractSequence;
use App\Entity\Value\ArithmeticSequence;
use App\Entity\Value\FibonacciSequence;
use App\Entity\Value\GeometricSequence;
use Symfony\Component\HttpFoundation\InputBag;

enum Sequence: string
{
    case Arithmetic = 'arithmetic';
    case Geometric = 'geometric';
    case Fibonacci = 'fibonacci';

    public function getId(): string
    {
        return match ($this) {
            self::Arithmetic => self::Arithmetic->value,
            self::Geometric => self::Geometric->value,
            self::Fibonacci => self::Fibonacci->value,
        };
    }

    public function getTitle(): string
    {
        return match ($this) {
            self::Arithmetic => 'Arithmetic progression',
            self::Geometric => 'Geometric progression',
            self::Fibonacci => 'Fibonacci sequence',
        };
    }

    public function mapData(InputBag $payload): AbstractSequence
    {
        return match ($this) {
            self::Arithmetic => (new ArithmeticSequence)
                ->setStart($payload->get('start'))
                ->setIncrement($payload->get('increment'))
                ->setSize($payload->get('size')),
            self::Geometric => (new GeometricSequence)
                ->setStart($payload->get('start'))
                ->setRatio($payload->get('ratio'))
                ->setSize($payload->get('size')),
            self::Fibonacci => (new FibonacciSequence)
                ->setSize($payload->get('size')),
        };
    }
}
