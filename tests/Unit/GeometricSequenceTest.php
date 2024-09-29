<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Data\GeometricSequence;
use PHPUnit\Framework\TestCase;

final class GeometricSequenceTest extends TestCase
{
    protected GeometricSequence $sequence;

    protected function setUp(): void
    {
        $this->sequence = new GeometricSequence();
    }

    public function testItGenerates(): void
    {
        $this->assertEquals([], $this->sequence->setStart(1)->setRatio(1)->setSize(-1)->generate());
        $this->assertEquals([], $this->sequence->setStart(1)->setRatio(1)->setSize(0)->generate());
        $this->assertEquals([1], $this->sequence->setStart(1)->setRatio(1)->setSize(1)->generate());
        $this->assertEquals([0, 0, 0, 0, 0], $this->sequence->setStart(0)->setRatio(1)->setSize(5)->generate());
        $this->assertEquals([1, 1, 1, 1, 1], $this->sequence->setStart(1)->setRatio(1)->setSize(5)->generate());
        $this->assertEquals([1, 2, 4, 8, 16], $this->sequence->setStart(1)->setRatio(2)->setSize(5)->generate());
        $this->assertEquals([1, -2, 4, -8, 16], $this->sequence->setStart(1)->setRatio(-2)->setSize(5)->generate());
        $this->assertEquals([100, 50, 25, 12.5, 6.25], $this->sequence->setStart(100)->setRatio(0.5)->setSize(5)->generate());
    }
}
