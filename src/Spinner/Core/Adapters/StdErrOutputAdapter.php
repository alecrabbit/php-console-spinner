<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Adapters;

use AlecRabbit\Spinner\Core\Contracts\OutputInterface;

/**
 * Class StdErrOutputAdapter
 *
 * @codeCoverageIgnore
 */
class StdErrOutputAdapter implements OutputInterface
{
    /** {@inheritDoc} */
    public function write($messages, $newline = false, $options = 0): void
    {
        if (!is_iterable($messages)) {
            $messages = [$messages];
        }
        foreach ($messages as $message) {
            $this->doWrite($message, $newline);
        }
    }

    /**
     * Writes a message to STDERR.
     *
     * @param string $message A message to write to STDERR
     * @param bool   $newline Whether to add a newline or not
     */
    protected function doWrite(string $message, bool $newline): void
    {
        if ($newline) {
            $message .= PHP_EOL;
        }

        if (false === @fwrite(STDERR, $message)) {
            // should never happen
            throw new \RuntimeException('Unable to write output.');
        }

        fflush(STDERR);
    }
}
