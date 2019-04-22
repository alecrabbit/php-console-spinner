<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Adapters;

use AlecRabbit\Spinner\Core\Contracts\SpinnerOutputInterface;

/**
 * Class EchoOutputAdapter
 */
class EchoOutputAdapter implements SpinnerOutputInterface
{
    /** {@inheritDoc} */
    public function write($messages, $newline = false, $options = 0): void
    {
        if (!is_iterable($messages)) {
            $messages = [$messages];
        }
        foreach ($messages as $message) {
            echo $message . ($newline ? PHP_EOL : '');
        }
    }
}