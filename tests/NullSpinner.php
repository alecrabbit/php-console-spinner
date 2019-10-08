<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Spinner\Core\Spinner;

class NullSpinner extends Spinner
{
    protected const INTERVAL = 0.125;
    protected const FRAMES = [];
}
