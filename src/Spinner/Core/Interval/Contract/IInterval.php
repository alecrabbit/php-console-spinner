<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Interval\Contract;

interface IInterval
{
    public function toMicroseconds(): float;

    public function toMilliseconds(): float;

    public function toSeconds(): float;

    public static function createDefault(): IInterval;
}
