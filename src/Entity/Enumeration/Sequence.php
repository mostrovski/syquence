<?php declare(strict_types=1);

namespace App\Entity\Enumeration;

use App\Entity\Value\AbstractSequence;
use App\Entity\Value\ArithmeticSequence;
use App\Entity\Value\FibonacciSequence;
use App\Entity\Value\GeometricSequence;
use Symfony\Component\HttpFoundation\Request;

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

    public function mapData(Request $request): AbstractSequence
    {
        return match ($this) {
            self::Arithmetic => (new ArithmeticSequence)
                ->setStart($request->get('start'))
                ->setIncrement($request->get('increment'))
                ->setSize($request->get('size')),
            self::Geometric => (new GeometricSequence)
                ->setStart($request->get('start'))
                ->setRatio($request->get('ratio'))
                ->setSize($request->get('size')),
            self::Fibonacci => (new FibonacciSequence)
                ->setSize($request->get('size')),
        };
    }
}
