<?php /** @noinspection PhpComposerExtensionStubsInspection */
declare(strict_types=1);

use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\Core\AbstractSpinner;

require_once __DIR__ . '/__ext_check.php';

__check_for_extension('pcntl', 'ext-pcntl is required', __FILE__);

/**
 * @param AbstractSpinner $s
 * @param Themes $theme
 */
function longRun(AbstractSpinner $s, Themes $theme): void
{
    echo $theme->cyan('Example: Entering long running state... ') . PHP_EOL;
    echo $theme->dark('Use Ctrl + C to exit.') . PHP_EOL;
    echo PHP_EOL;
    $microseconds = (int)($s->interval() * 1000000);
    $run = true;
    pcntl_signal(SIGINT, static function () use (&$run) {
        $run = false;
    });
    echo $s->begin(); // Optional, begin() does same as spin() but also Cursor::hide(),
    while ($run) {
        usleep($microseconds);
        pcntl_signal_dispatch();
        echo $s->spin();
    }
    echo $s->end();
    echo PHP_EOL;
}

