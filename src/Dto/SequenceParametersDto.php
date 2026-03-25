<?php declare(strict_types=1);

namespace App\Dto;

class SequenceParametersDto
{
    protected string|int|null $size = null;
    protected string|float|int|null $start = null;
    protected string|float|int|null $increment = null;
    protected string|float|int|null $ratio = null;

    public function getSize(): string|int|null
    {
        return $this->size;
    }

    public function setSize(string|int|null $size): SequenceParametersDto
    {
        $this->size = $size;

        return $this;
    }

    public function getStart(): string|float|int|null
    {
        return $this->start;
    }

    public function setStart(string|float|int|null $start): SequenceParametersDto
    {
        $this->start = $start;

        return $this;
    }

    public function getIncrement(): string|float|int|null
    {
        return $this->increment;
    }

    public function setIncrement(string|float|int|null $increment): SequenceParametersDto
    {
        $this->increment = $increment;

        return $this;
    }

    public function getRatio(): string|float|int|null
    {
        return $this->ratio;
    }

    public function setRatio(string|float|int|null $ratio): SequenceParametersDto
    {
        $this->ratio = $ratio;

        return $this;
    }
}
