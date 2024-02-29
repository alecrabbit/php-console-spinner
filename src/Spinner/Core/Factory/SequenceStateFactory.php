<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Factory\Contract\ISequenceStateFactory;
use AlecRabbit\Spinner\Core\SequenceState;

final readonly class SequenceStateFactory implements ISequenceStateFactory
{
    public function __construct(
        private ISequenceStateBuilder $stateBuilder,
    ) {
    }


    public function create(?ISequenceFrame $frame = null, ?ISequenceState $previous = null): ISequenceState
    {
        $frame ??= $this->emptyFrame();
        $previous ??= $this->emptyState();

        return $this->stateBuilder
            ->withSequenceFrame($frame)
            ->withPrevious($previous)
            ->build()
        ;
    }

    private function emptyFrame(): ISequenceFrame
    {
        return new CharSequenceFrame('', 0);
    }

    private function emptyState(): ISequenceState
    {
        return new SequenceState('', 0, 0);
    }
}
