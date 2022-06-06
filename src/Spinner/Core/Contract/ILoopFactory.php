<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ILoopFactory
{
    public static function getLoop(): ILoop;
}
