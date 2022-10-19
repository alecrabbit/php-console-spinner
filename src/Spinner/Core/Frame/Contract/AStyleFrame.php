<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Core\Frame\Contract;

abstract class AStyleFrame implements IStyleFrame
{
    public function __construct(
        protected readonly string $sequenceStart,
        protected readonly string $sequenceEnd,
    ) {
    }

    public static function createEmpty(): static
    {
        return new static('', '');
    }

    public function getStyleSequenceStart(): string
    {
        return $this->sequenceStart;
    }

    public function getStyleSequenceEnd(): string
    {
        return $this->sequenceEnd;
    }
}
