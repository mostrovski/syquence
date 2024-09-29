<?php declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Data\ArithmeticSequence;
use PHPUnit\Framework\TestCase;

final class ArithmeticSequenceTest extends TestCase
{
    protected ArithmeticSequence $sequence;

    protected function setUp(): void
    {
        $this->sequence = new ArithmeticSequence;
    }

    public function test_it_generates(): void
    {
        $this->assertEquals([], $this->sequence->setStart(1)->setIncrement(1)->setSize(-1)->generate());
        $this->assertEquals([], $this->sequence->setStart(1)->setIncrement(1)->setSize(0)->generate());
        $this->assertEquals([1], $this->sequence->setStart(1)->setIncrement(1)->setSize(1)->generate());
        $this->assertEquals([1, 2, 3, 4, 5], $this->sequence->setStart(1)->setIncrement(1)->setSize(5)->generate());
        $this->assertEquals([0, -2, -4, -6, -8], $this->sequence->setStart(0)->setIncrement(-2)->setSize(5)->generate());
        $this->assertEquals([2, 1.5, 1, 0.5, 0], $this->sequence->setStart(2)->setIncrement(-0.5)->setSize(5)->generate());
    }
}
