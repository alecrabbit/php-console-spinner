<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ACharsRotor;
use AlecRabbit\Spinner\Core\Contract\IRotor;

final class NoCharsRotor extends ACharsRotor
{
    public function next(float|int|null $interval = null): string
    {
        return '';
    }

    public function __construct()
    {
        // initialize with defaults
        parent::__construct();
    }
}
