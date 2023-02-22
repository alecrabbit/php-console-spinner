<?php


declare(strict_types=1);

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\FractionValue;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Factory\SpinnerFactory;

require_once __DIR__ . '/../bootstrap.php';

// * Run time settings * //
$runTime = 10;
$additionalRunTime = 3;
$messageDelay = 1;
$messageInterval = 2;
$progressRunTime = 5;
$progressSteps = 100;
$progressAutoFinish = true;

const MICROSECONDS_COEFFICIENT = 1000000;

$elapsed = 0;
$cycle = (int)(0.01 * MICROSECONDS_COEFFICIENT); // 10 ms
$timeLimit = $runTime * MICROSECONDS_COEFFICIENT;

$progressTimeLimit = $progressRunTime * MICROSECONDS_COEFFICIENT;
$progressAdvanceInterval = (int)($progressTimeLimit / $progressSteps);

$messageDelayMicroseconds = $messageDelay * MICROSECONDS_COEFFICIENT;
$messageIntervalMicroseconds = $messageInterval * MICROSECONDS_COEFFICIENT;
$t = [];
// * * //

$spinner = SpinnerFactory::create();

$stdout = new StreamOutput(STDOUT);
$echo = $stdout->writeln(...);

$progressValue =
    new FractionValue(
        steps: $progressSteps,
        autoFinish: $progressAutoFinish,
    );

$progressWidget = createProgressWidget($progressValue, $spinner);

$spinner->add($progressWidget);

$spinInterval = (int)$spinner->getInterval()->toMicroseconds();

while ($elapsed < $timeLimit) {
    if ($elapsed % $spinInterval === 0) {
        $start = hrtime(true);
        $spinner->spin();
        $t[] = hrtime(true) - $start;
    }

    if ($elapsed % $progressAdvanceInterval === 0) {
        $progressValue->advance();
    }

    if ($elapsed > $messageDelayMicroseconds && $elapsed % $messageIntervalMicroseconds === 0) {
        $spinner->wrap(
            $echo,
            sprintf(
                '%s▕ %s▕ %s▕ %s▕',
                '(STDOUT)',
                (new DateTimeImmutable())->format('Y-m-d H:i:s.u'),
                sprintf(
                    'Time Avg: %sμs',
                    number_format((array_sum($t) / count($t)) / 1000, 3),
                ),
                sprintf(
                    'Memory Real: %sK Peak: %sK',
                    number_format(memory_get_usage(true) / 1024),
                    number_format(memory_get_peak_usage(true) / 1024),
                ),
            ),
        );
        if (count($t) > 400) { // remove oldest
            $spinner->wrap($echo, 'Cleansing time array...');
            $t = array_slice($t, 300);
        }
    }

    usleep($cycle);
    $elapsed += $cycle;
}

if (!$progressAutoFinish) {
    $spinner->wrap($progressValue->finish(...));
}

$spinner->wrap($echo, 'About to remove progress widget...');
if ($progressValue->isFinished()) {
    $spinner->remove($progressWidget);
    $progressValue = null;
}
$spinner->wrap($echo, 'Progress widget removed.');

spinForSeconds($additionalRunTime, $spinInterval, $spinner, $cycle);

$spinner->finalize('');

/**
 * Functions
 */
function spinForSeconds(int $seconds, int $spinInterval, ISpinner $spinner, int $cycle): void
{
    $elapsed = 0;
    $timeLimit = $seconds * MICROSECONDS_COEFFICIENT;

    while ($elapsed < $timeLimit) {
        if ($elapsed % $spinInterval === 0) {
            $spinner->spin();
        }

        usleep($cycle);
        $elapsed += $cycle;
    }
}


