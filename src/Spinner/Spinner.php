<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract\ISpinnerConfig;

final class Spinner
{
    public function __construct(
        private ISpinnerConfig $configuration
    )
    {
    }

}
