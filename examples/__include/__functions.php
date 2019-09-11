<?php declare(strict_types=1);

use AlecRabbit\Spinner\Core\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\PercentSpinner;

/**
 * @param int $max
 * @return int
 */
function rnd(int $max): int
{
    try {
        return random_int(0, $max);
    } catch (Exception $e) {
        return 0;
    }
}
