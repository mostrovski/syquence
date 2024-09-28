<?php declare(strict_types=1);

namespace App\Tests\Unit;

use App\Service\SequenceGenerator;
use PHPUnit\Framework\TestCase;

final class SequenceServiceTest extends TestCase
{
    protected SequenceGenerator $sequence;

    protected function setUp(): void
    {
        $this->sequence = new SequenceGenerator;
    }

    public function test_it_generates_arithmetic_sequences(): void
    {
        $this->assertEquals([], $this->sequence->arithmetic(start: 1, increment: 1, size: -1));
        $this->assertEquals([], $this->sequence->arithmetic(start: 1, increment: 1, size: 0));
        $this->assertEquals([1], $this->sequence->arithmetic(start: 1, increment: 1, size: 1));
        $this->assertEquals([1, 2, 3, 4, 5], $this->sequence->arithmetic(start: 1, increment: 1, size: 5));
        $this->assertEquals([0, -2, -4, -6, -8], $this->sequence->arithmetic(start: 0, increment: -2, size: 5));
        $this->assertEquals([2, 1.5, 1, 0.5, 0], $this->sequence->arithmetic(start: 2, increment: -0.5, size: 5));
    }

    public function test_it_generates_geometric_sequences(): void
    {
        $this->assertEquals([], $this->sequence->geometric(start: 1, ratio: 1, size: -1));
        $this->assertEquals([], $this->sequence->geometric(start: 1, ratio: 1, size: 0));
        $this->assertEquals([1], $this->sequence->geometric(start: 1, ratio: 1, size: 1));
        $this->assertEquals([0, 0, 0, 0, 0], $this->sequence->geometric(start: 0, ratio: 1, size: 5));
        $this->assertEquals([1, 1, 1, 1, 1], $this->sequence->geometric(start: 1, ratio: 1, size: 5));
        $this->assertEquals([1, 2, 4, 8, 16], $this->sequence->geometric(start: 1, ratio: 2, size: 5));
        $this->assertEquals([1, -2, 4, -8, 16], $this->sequence->geometric(start: 1, ratio: -2, size: 5));
        $this->assertEquals([100, 50, 25, 12.5, 6.25], $this->sequence->geometric(start: 100, ratio: 0.5, size: 5));
    }

    public function test_it_generates_fibonacci_sequences(): void
    {
        $this->assertEquals([], $this->sequence->fibonacci(size: -1));
        $this->assertEquals([], $this->sequence->fibonacci(size: 0));
        $this->assertEquals([0], $this->sequence->fibonacci(size: 1));
        $this->assertEquals([0, 1], $this->sequence->fibonacci(size: 2));
        $this->assertEquals([0, 1, 1], $this->sequence->fibonacci(size: 3));
        $this->assertEquals([0, 1, 1, 2, 3], $this->sequence->fibonacci(size: 5));
        $this->assertEquals([0, 1, 1, 2, 3, 5, 8, 13, 21, 34], $this->sequence->fibonacci(size: 10));
        $this->assertEquals([0, 1, 1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144, 233, 377], $this->sequence->fibonacci(size: 15));
    }
}
