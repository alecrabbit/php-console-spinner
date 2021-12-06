<?php declare(strict_types=1);

use AlecRabbit\SpinnerOld\Core\Contracts\SpinnerInterface;
use AlecRabbit\SpinnerOld\PercentSpinner;

/**
 * @param SpinnerInterface $s
 * @param bool $withPercent
 */
function showSpinners(SpinnerInterface $s, bool $withPercent = false): void
{
    $microseconds = (int)($s->interval() * 1000000);
    echo $s->begin(); // Optional
    for ($i = 1; $i <= ITER; $i++) {
        if ($s instanceof PercentSpinner) {
            $s->spin($withPercent ? $i / ITER : null);
        } else {
            $s
                ->progress($withPercent ? $i / ITER : null)
                ->spin();
        }
        usleep($microseconds);
    }
    echo $s->end();
}

