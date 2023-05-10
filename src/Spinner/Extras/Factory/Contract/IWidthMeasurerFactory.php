<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory\Contract;

use AlecRabbit\Spinner\Extras\Contract\IWidthMeasurer;

interface IWidthMeasurerFactory
{
    public function create(): IWidthMeasurer;
}
