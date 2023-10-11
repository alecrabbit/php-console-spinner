<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProvider;
use AlecRabbit\Spinner\Exception\DomainException;

final readonly class LoopProvider implements ILoopProvider
{
    public function __construct(
        protected ?ILoop $loop,
    ) {
    }

    public function hasLoop(): bool
    {
        return $this->loop instanceof ILoop;
    }

    public function getLoop(): ILoop
    {
        return
            $this->loop ?? throw new DomainException('Loop is not set.');
    }
}
