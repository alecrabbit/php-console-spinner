<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Extras\Contract\ILoop;

interface ILoopFactory
{
    public static function create(): ILoop;
}