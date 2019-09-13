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
    /** @var resource */
    protected $stream;

    /**
     * StdErrOutputAdapter constructor.
     * @param bool|resource $stream
     */
    public function __construct($stream = STDERR)
    {
        if (!\is_resource($stream)) {
            throw new \InvalidArgumentException('$stream is bool. It should never happen.');
        }
        $this->stream = $stream;
    }


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
     * @param bool $newline Whether to add a newline or not
     */
    protected function doWrite(string $message, bool $newline): void
    {
        if ($newline) {
            $message .= PHP_EOL;
        }

        if (false === @fwrite($this->stream, $message)) {
            // should never happen
            throw new \RuntimeException('Unable to write output.');
        }

        fflush($this->stream);
    }

    /**
     * @return resource
     */
    public function getStream()
    {
        return $this->stream;
    }
}
