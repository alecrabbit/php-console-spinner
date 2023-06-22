<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IInterval;

interface INullableIntervalContainer
{
    public function getSmallest(): ?IInterval;

    public function add(?IInterval $interval): void;

    public function remove(?IInterval $interval): void;
}
