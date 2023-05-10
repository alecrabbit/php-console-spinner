<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Contract;

interface IWidthMeasurer
{
    public function measureWidth(string $string): int;
}
