<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Contract;

use AlecRabbit\Spinner\Core\Contract\IInterval;
use AlecRabbit\Spinner\Core\Procedure\Contract\IProcedure;

interface IPattern
{
    public function getPattern(): iterable;

    public function getInterval(): IInterval;
}