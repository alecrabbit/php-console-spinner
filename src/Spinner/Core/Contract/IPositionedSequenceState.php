<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IPositionedSequenceState extends ISequenceState
{
    public function getPosition(): IPoint;
}
