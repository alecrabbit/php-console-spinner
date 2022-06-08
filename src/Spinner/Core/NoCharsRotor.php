<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ACharsRotor;

final class NoCharsRotor extends ACharsRotor
{
    public function __construct()
    {
        // initialize with defaults
        parent::__construct();
    }

    public function next(float|int|null $interval = null): string
    {
        return '';
    }
}
