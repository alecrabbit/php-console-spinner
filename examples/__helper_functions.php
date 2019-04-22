<?php declare(strict_types=1);

// ************************ Functions ************************
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\Core\Contracts\SpinnerOutputInterface;
use AlecRabbit\Spinner\Core\Spinner;

/**
 * @param Spinner $s
 * @param Themes $theme
 * @param bool $inline
 * @param array $exampleMessages
 * @param SpinnerOutputInterface $output
 */
function display(
    Spinner $s,
    Themes $theme,
    bool $inline,
    array $exampleMessages,
    SpinnerOutputInterface $output = null
): void {
    if (null === $output) {
        $output = new class implements SpinnerOutputInterface
        {

            public function write($messages, $newline = false, $options = 0)
            {
                if (!is_iterable($messages)) {
                    $messages = [$messages];
                }
                foreach ($messages as $message) {
                    echo $message . ($newline ? PHP_EOL : '');
                }
            }
        };
    }
    $s->inline($inline);
    $emulatedMessages = scaleEmulatedMessages();
    $microseconds = (int)($s->interval() * 1000000);

    $output->write($theme->lightCyan('Example: '), true);
    foreach ($exampleMessages as $m) {
        $output->write($theme->lightCyan($m), true);

    }
    if (!$inline) {
        $output->write('', true);
    }

    $s->begin(); // Hides cursor and makes first spin
    for ($i = 0; $i < ITERATIONS; $i++) {
        usleep($microseconds); // Here you are doing your task
        if (array_key_exists($i, $emulatedMessages)) {
            // It's your job to echo erase sequence when needed
            $s->erase();
            if ($inline) {
                $output->write('', true);
            }
            $output->write($theme->none($emulatedMessages[$i] . '...'));
            if (!$inline) {
                $output->write('', true);
            }
        }
        // It's your job to call spin() with approx. equal intervals
        // (each class has recommended interval for comfortable animation)
        $s->spin($i / ITERATIONS);  // You can pass percentage to spin() method (float from 0 to 1)
    }
    $s->end();
    if ($inline) {
        $output->write('', true);
    }
    $output->write($theme->none('Done!') . PHP_EOL, true);

    $output->write('', true);
}

/**
 * @return array
 */
function scaleEmulatedMessages(): array
{
    $c = ITERATIONS / 100;
    $simulated = [];
    foreach (MESSAGES as $key => $message) {
        $simulated[(int)$key * $c] = $message;
    }
    return $simulated;
}
