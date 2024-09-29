<?php declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Data\FibonacciSequence;
use PHPUnit\Framework\TestCase;

final class FibonacciSequenceTest extends TestCase
{
    protected FibonacciSequence $sequence;

    protected function setUp(): void
    {
        $this->sequence = new FibonacciSequence;
    }

    public function test_it_generates(): void
    {
        $this->assertEquals([], $this->sequence->setSize(-1)->generate());
        $this->assertEquals([], $this->sequence->setSize(0)->generate());
        $this->assertEquals([0], $this->sequence->setSize(1)->generate());
        $this->assertEquals([0, 1], $this->sequence->setSize(2)->generate());
        $this->assertEquals([0, 1, 1], $this->sequence->setSize(3)->generate());
        $this->assertEquals([0, 1, 1, 2, 3], $this->sequence->setSize(5)->generate());
        $this->assertEquals([0, 1, 1, 2, 3, 5, 8, 13, 21, 34], $this->sequence->setSize(10)->generate());
        $this->assertEquals([0, 1, 1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144, 233, 377], $this->sequence->setSize(15)->generate());
    }
}
