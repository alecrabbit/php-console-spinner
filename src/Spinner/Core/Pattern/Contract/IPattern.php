<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Contract;

use AlecRabbit\Spinner\Contract\IInterval;

interface IPattern
{
    public function getPattern(): iterable;

    public function getInterval(): IInterval;
}