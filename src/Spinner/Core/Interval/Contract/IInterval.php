<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Interval\Contract;

interface IInterval
{
    public function toMilliseconds(): float|int;

    public function toSeconds(): float|int;

    public static function createDefault(): IInterval;
}
