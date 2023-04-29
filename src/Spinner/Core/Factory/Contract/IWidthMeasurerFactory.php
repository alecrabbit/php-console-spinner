<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\IWidthMeasurer;

interface IWidthMeasurerFactory
{
    public function create(): IWidthMeasurer;
}