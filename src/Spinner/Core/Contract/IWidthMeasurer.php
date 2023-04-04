<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core\Contract;

interface IWidthMeasurer
{
    public function getWidth(string $string): int;
}
