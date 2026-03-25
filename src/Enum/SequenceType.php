<?php declare(strict_types=1);

namespace App\Enum;

enum SequenceType: string
{
    case ARITHMETIC = 'arithmetic';
    case GEOMETRIC = 'geometric';
    case FIBONACCI = 'fibonacci';

    public function getId(): string
    {
        return match ($this) {
            self::ARITHMETIC => self::ARITHMETIC->value,
            self::GEOMETRIC => self::GEOMETRIC->value,
            self::FIBONACCI => self::FIBONACCI->value,
        };
    }

    public function getTitle(): string
    {
        return match ($this) {
            self::ARITHMETIC => 'Arithmetic progression',
            self::GEOMETRIC => 'Geometric progression',
            self::FIBONACCI => 'Fibonacci sequence',
        };
    }
}
