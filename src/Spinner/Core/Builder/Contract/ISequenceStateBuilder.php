<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Exception\LogicException;

interface ISequenceStateBuilder
{
    public function withSequence(string $sequence): ISequenceStateBuilder;

    public function withSequenceFrame(ISequenceFrame $frame): ISequenceStateBuilder;

    public function withWidth(int $width): ISequenceStateBuilder;

    public function withPreviousWidth(int $previousWidth): ISequenceStateBuilder;

    public function withPrevious(ISequenceState $previous): ISequenceStateBuilder;

    /**
     * @throws LogicException
     */
    public function build(): ISequenceState;
}
