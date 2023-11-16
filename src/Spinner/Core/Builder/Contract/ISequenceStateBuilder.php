<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Core\Contract\ISequenceState;

// TODO (2023-11-16 12:53) [Alec Rabbit]: add implementation and use in Driver
interface ISequenceStateBuilder
{
    public function withSequence(string $sequence): ISequenceStateBuilder;

    public function withWidth(int $width): ISequenceStateBuilder;

    public function withPreviousWidth(int $previousWidth): ISequenceStateBuilder;

    public function build(): ISequenceState;
}
