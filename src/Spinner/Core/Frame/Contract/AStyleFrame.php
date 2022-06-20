<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Core\Frame\Contract;

abstract class AStyleFrame implements IStyleFrame
{
    public function __construct(
        protected readonly string $sequence,
    ) {
    }

    public function getSequence(): string
    {
        return $this->sequence;
    }
}
