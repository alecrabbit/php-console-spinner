<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\IInterval;

interface IIntervalFactory
{
    /**
     * @deprecated No replacement. Consider it already removed.
     */
    public function createDefault(): IInterval;

    public function createNormalized(?int $interval): IInterval;

    public function createStill(): IInterval;
}
